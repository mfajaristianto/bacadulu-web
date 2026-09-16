<?php

namespace App\Services\BacaPublisher;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class BacaPublisherClient
{
    public function configured(): bool
    {
        if ($this->mockEnabled()) {
            return is_file((string) config('bacapublisher.mock_file'));
        }

        return trim((string) config('bacapublisher.api_url')) !== ''
            && trim((string) config('bacapublisher.api_key')) !== '';
    }

    public function mockEnabled(): bool
    {
        return (bool) config('bacapublisher.mock', false);
    }

    public function assertConfigured(): void
    {
        if ($this->configured()) {
            return;
        }

        if ($this->mockEnabled()) {
            throw new RuntimeException(
                'BACAPUBLISHER_MOCK=true tetapi file mock tidak ditemukan di storage/app/bacapublisher/mock-submissions.json.'
            );
        }

        throw new RuntimeException(
            'Integrasi BacaPublisher belum dikonfigurasi. Isi BACAPUBLISHER_API_URL dan BACAPUBLISHER_API_KEY di .env, atau aktifkan BACAPUBLISHER_MOCK=true untuk tes lokal.'
        );
    }

    /**
     * Ambil seluruh submission dari endpoint OMP dengan pagination offset/count.
     */
    public function submissions(): array
    {
        $this->assertConfigured();

        if ($this->mockEnabled()) {
            $payload = $this->mockPayload();

            if (isset($payload['id']) && !isset($payload['items'])) {
                return [$payload];
            }

            $items = $payload['items'] ?? [];

            return is_array($items) ? $items : [];
        }

        $pageSize = (int) config('bacapublisher.page_size', 50);
        $offset = 0;
        $items = [];
        $itemsMax = null;

        do {
            $payload = $this->getJson(
                $this->endpoint('submissions'),
                [
                    'offset' => $offset,
                    'count' => $pageSize,
                ]
            );

            // Beberapa instalasi/versi dapat mengembalikan single object.
            if (isset($payload['id']) && !isset($payload['items'])) {
                return [$payload];
            }

            $pageItems = $payload['items'] ?? [];
            if (!is_array($pageItems)) {
                $pageItems = [];
            }

            $items = array_merge($items, $pageItems);
            $itemsMax = isset($payload['itemsMax'])
                ? (int) $payload['itemsMax']
                : count($items);

            $offset += count($pageItems);

            if ($pageItems === []) {
                break;
            }
        } while ($offset < $itemsMax);

        return $items;
    }

    public function publication(array $submission, array $publication): array
    {
        if ($this->mockEnabled()) {
            // Fixture /submissions sudah membawa publication dasar.
            // Jangan melakukan request API sungguhan saat tes lokal tanpa key.
            return $publication;
        }

        $href = trim((string) ($publication['_href'] ?? ''));

        if ($href === '') {
            $submissionId = $submission['id'] ?? null;
            $publicationId = $publication['id'] ?? null;

            if (!$submissionId || !$publicationId) {
                return $publication;
            }

            $href = $this->endpoint(
                'submissions/' . rawurlencode((string) $submissionId)
                . '/publications/' . rawurlencode((string) $publicationId)
            );
        }

        try {
            $detail = $this->getJson($href);

            return array_replace_recursive($publication, $detail);
        } catch (Throwable $e) {
            // Listing submissions sudah cukup untuk import dasar. Detail publication
            // hanya enrichment, jadi jangan gagalkan seluruh sinkronisasi karena 404.
            if (str_contains($e->getMessage(), 'HTTP 404')) {
                return $publication;
            }

            throw $e;
        }
    }

    /**
     * Metadata publik tambahan (sinopsis dan cover URL) dari halaman catalog.
     * Dipakai sebagai fallback bila field tersebut tidak diberikan endpoint API.
     */
    public function catalogMetadata(?string $url): array
    {
        $url = trim((string) $url);

        if ($url === '') {
            return [];
        }

        try {
            $response = Http::timeout((int) config('bacapublisher.timeout', 25))
                ->connectTimeout((int) config('bacapublisher.connect_timeout', 8))
                ->retry(2, 350, throw: false)
                ->withHeaders([
                    'User-Agent' => 'BacaDulu-Publisher-Sync/1.0',
                    'Accept' => 'text/html,application/xhtml+xml',
                ])
                ->get($url);

            if (!$response->successful()) {
                return [];
            }

            return $this->parseCatalogHtml($response->body(), $url);
        } catch (Throwable) {
            return [];
        }
    }

    /**
     * Download image bytes tanpa resize atau recompress.
     */
    public function downloadImage(string $url): ?array
    {
        $url = trim($url);

        if ($url === '' || !filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        try {
            $response = Http::timeout((int) config('bacapublisher.timeout', 25))
                ->connectTimeout((int) config('bacapublisher.connect_timeout', 8))
                ->retry(2, 400, throw: false)
                ->withHeaders([
                    'User-Agent' => 'BacaDulu-Publisher-Sync/1.0',
                    'Accept' => 'image/*,*/*;q=0.8',
                ])
                ->get($url);

            if (!$response->successful()) {
                return null;
            }

            $body = $response->body();
            if ($body === '') {
                return null;
            }

            $maxBytes = (int) config('bacapublisher.max_cover_bytes', 15 * 1024 * 1024);
            if (strlen($body) > $maxBytes) {
                return null;
            }

            $contentType = strtolower((string) $response->header('Content-Type'));
            $contentType = trim(explode(';', $contentType)[0] ?? '');

            $extension = match ($contentType) {
                'image/jpeg', 'image/jpg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp',
                'image/gif' => 'gif',
                default => $this->extensionFromUrl($url),
            };

            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
                return null;
            }

            return [
                'body' => $body,
                'extension' => $extension === 'jpeg' ? 'jpg' : $extension,
                'content_type' => $contentType,
            ];
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * Cari URL cover dari response API; jika hanya uploadName tersedia,
     * susun kandidat URL public/presses/{contextId}/filename.
     */
    public function coverUrl(array $submission, array $publication, array $catalog = []): ?string
    {
        $catalogCover = trim((string) ($catalog['cover_url'] ?? ''));
        if ($catalogCover !== '') {
            return $catalogCover;
        }

        $cover = $publication['coverImage'] ?? null;
        $coverEntry = $this->firstLocalizedArray($cover, (string) ($publication['locale'] ?? $submission['locale'] ?? 'en'));

        if (is_array($coverEntry)) {
            foreach (['url', 'href', 'src', 'imageUrl', 'fileUrl', 'temporaryFileUrl'] as $key) {
                $value = trim((string) ($coverEntry[$key] ?? ''));
                if ($value !== '') {
                    return $this->absoluteUrl($value, (string) ($publication['urlPublished'] ?? $submission['urlPublished'] ?? ''));
                }
            }

            $uploadName = trim((string) ($coverEntry['uploadName'] ?? ''));
            $contextId = $submission['contextId'] ?? null;

            if ($uploadName !== '' && $contextId) {
                $root = $this->siteRoot();
                if ($root !== '') {
                    return $root
                        . '/public/presses/'
                        . rawurlencode((string) $contextId)
                        . '/'
                        . rawurlencode($uploadName);
                }
            }
        }

        return null;
    }

    public function testConnection(): array
    {
        $this->assertConfigured();

        if ($this->mockEnabled()) {
            $payload = $this->mockPayload();

            return [
                'items_max' => (int) ($payload['itemsMax'] ?? count($payload['items'] ?? [])),
                'ok' => true,
                'mock' => true,
            ];
        }

        $payload = $this->getJson(
            $this->endpoint('submissions'),
            ['offset' => 0, 'count' => 1]
        );

        return [
            'items_max' => (int) ($payload['itemsMax'] ?? (isset($payload['id']) ? 1 : 0)),
            'ok' => true,
            'mock' => false,
        ];
    }

    private function mockPayload(): array
    {
        $path = (string) config('bacapublisher.mock_file');

        if ($path === '' || !is_file($path)) {
            throw new RuntimeException(
                'File mock BacaPublisher tidak ditemukan: storage/app/bacapublisher/mock-submissions.json'
            );
        }

        $json = file_get_contents($path);

        if ($json === false || trim($json) === '') {
            throw new RuntimeException('File mock BacaPublisher kosong atau tidak dapat dibaca.');
        }

        $payload = json_decode($json, true);

        if (!is_array($payload)) {
            throw new RuntimeException('JSON mock BacaPublisher tidak valid.');
        }

        return $payload;
    }

    private function getJson(string $url, array $query = []): array
    {
        $this->assertConfigured();

        if (config('bacapublisher.auth_mode') === 'query') {
            $query[(string) config('bacapublisher.auth_query', 'apiToken')] = (string) config('bacapublisher.api_key');
        }

        $response = $this->request()->get($url, $query);

        $this->throwForResponse($response, $url);

        $json = $response->json();

        if (!is_array($json)) {
            throw new RuntimeException('Response BacaPublisher bukan JSON yang valid.');
        }

        return $json;
    }

    private function request(): PendingRequest
    {
        $request = Http::acceptJson()
            ->timeout((int) config('bacapublisher.timeout', 25))
            ->connectTimeout((int) config('bacapublisher.connect_timeout', 8))
            ->retry(2, 450, throw: false)
            ->withHeaders([
                'User-Agent' => 'BacaDulu-Publisher-Sync/1.0',
            ]);

        $mode = (string) config('bacapublisher.auth_mode', 'bearer');
        $key = (string) config('bacapublisher.api_key');

        if ($mode === 'header') {
            return $request->withHeaders([
                (string) config('bacapublisher.auth_header', 'X-API-Key') => $key,
            ]);
        }

        if ($mode === 'query') {
            return $request;
        }

        return $request->withToken($key);
    }

    private function throwForResponse(Response $response, string $url): void
    {
        if ($response->successful()) {
            return;
        }

        $status = $response->status();

        if (in_array($status, [401, 403], true)) {
            throw new RuntimeException(
                "BacaPublisher menolak autentikasi (HTTP {$status}). Periksa API Key dan BACAPUBLISHER_AUTH_MODE."
            );
        }

        $message = $response->json('errorMessage')
            ?? $response->json('message')
            ?? $response->reason();

        throw new RuntimeException(
            'Request BacaPublisher gagal (HTTP '
            . $status
            . '): '
            . trim((string) $message)
            . ' [' . $this->safeUrl($url) . ']'
        );
    }

    private function endpoint(string $path): string
    {
        return rtrim((string) config('bacapublisher.api_url'), '/')
            . '/'
            . ltrim($path, '/');
    }

    private function siteRoot(): string
    {
        $apiUrl = trim((string) config('bacapublisher.api_url'));
        if ($apiUrl === '') {
            return '';
        }

        if (str_contains($apiUrl, '/index.php/')) {
            return rtrim(explode('/index.php/', $apiUrl, 2)[0], '/');
        }

        $parts = parse_url($apiUrl);
        if (!$parts || empty($parts['scheme']) || empty($parts['host'])) {
            return '';
        }

        $root = $parts['scheme'] . '://' . $parts['host'];
        if (!empty($parts['port'])) {
            $root .= ':' . $parts['port'];
        }

        return $root;
    }

    private function parseCatalogHtml(string $html, string $baseUrl): array
    {
        $result = [];

        if (class_exists(\DOMDocument::class)) {
            $previous = libxml_use_internal_errors(true);

            $dom = new \DOMDocument();
            $loaded = $dom->loadHTML(
                '<?xml encoding="utf-8" ?>' . $html,
                LIBXML_NOWARNING | LIBXML_NOERROR
            );

            if ($loaded) {
                $xpath = new \DOMXPath($dom);

                $ogImage = $xpath->query('//meta[@property="og:image"]/@content')->item(0);
                if ($ogImage) {
                    $result['cover_url'] = $this->absoluteUrl($ogImage->nodeValue, $baseUrl);
                }

                if (empty($result['cover_url'])) {
                    $coverQueries = [
                        '//*[contains(concat(" ", normalize-space(@class), " "), " cover ")]//img/@src',
                        '//img[contains(@src,"coverImage")]/@src',
                        '//img[contains(@src,"submission_")]/@src',
                    ];

                    foreach ($coverQueries as $query) {
                        $node = $xpath->query($query)->item(0);
                        if ($node) {
                            $result['cover_url'] = $this->absoluteUrl($node->nodeValue, $baseUrl);
                            break;
                        }
                    }
                }

                $abstractQueries = [
                    '//*[contains(concat(" ", normalize-space(@class), " "), " abstract ")]//*[contains(concat(" ", normalize-space(@class), " "), " value ")]',
                    '//*[contains(concat(" ", normalize-space(@class), " "), " abstract ")]',
                ];

                foreach ($abstractQueries as $query) {
                    $node = $xpath->query($query)->item(0);
                    if ($node) {
                        $inner = $this->innerHtml($node);
                        $plain = trim(preg_replace('/\s+/u', ' ', strip_tags($inner)) ?? '');
                        if ($plain !== '' && mb_strlen($plain) > 20) {
                            $result['description'] = trim($inner);
                            break;
                        }
                    }
                }
            }

            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }

        if (empty($result['cover_url'])) {
            if (preg_match('/<meta[^>]+property=["\']og:image["\'][^>]+content=["\']([^"\']+)["\']/i', $html, $match)) {
                $result['cover_url'] = $this->absoluteUrl(html_entity_decode($match[1]), $baseUrl);
            } elseif (preg_match('/<meta[^>]+content=["\']([^"\']+)["\'][^>]+property=["\']og:image["\']/i', $html, $match)) {
                $result['cover_url'] = $this->absoluteUrl(html_entity_decode($match[1]), $baseUrl);
            }
        }

        return array_filter(
            $result,
            static fn ($value) => $value !== null && $value !== ''
        );
    }

    private function innerHtml(\DOMNode $node): string
    {
        $html = '';

        foreach ($node->childNodes as $child) {
            $html .= $node->ownerDocument?->saveHTML($child) ?? '';
        }

        return $html;
    }

    private function firstLocalizedArray(mixed $value, string $locale): ?array
    {
        if (!is_array($value)) {
            return null;
        }

        if (isset($value[$locale]) && is_array($value[$locale])) {
            return $value[$locale];
        }

        foreach ($value as $entry) {
            if (is_array($entry)) {
                return $entry;
            }
        }

        return null;
    }

    private function absoluteUrl(?string $url, string $baseUrl): string
    {
        $url = trim((string) $url);

        if ($url === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $url)) {
            return $url;
        }

        $parts = parse_url($baseUrl);
        if (!$parts || empty($parts['scheme']) || empty($parts['host'])) {
            return $url;
        }

        $origin = $parts['scheme'] . '://' . $parts['host'];
        if (!empty($parts['port'])) {
            $origin .= ':' . $parts['port'];
        }

        if (str_starts_with($url, '/')) {
            return $origin . $url;
        }

        $path = (string) ($parts['path'] ?? '/');
        $directory = rtrim(str_replace('\\', '/', dirname($path)), '/');

        return $origin . ($directory ? $directory : '') . '/' . ltrim($url, '/');
    }

    private function extensionFromUrl(string $url): string
    {
        $path = (string) parse_url($url, PHP_URL_PATH);
        return strtolower((string) pathinfo($path, PATHINFO_EXTENSION));
    }

    private function safeUrl(string $url): string
    {
        $parts = parse_url($url);
        if (!$parts) {
            return 'endpoint';
        }

        return ($parts['scheme'] ?? 'https')
            . '://'
            . ($parts['host'] ?? 'publisher')
            . ($parts['path'] ?? '');
    }
}
