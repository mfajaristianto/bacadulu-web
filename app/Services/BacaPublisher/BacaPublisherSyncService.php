<?php

namespace App\Services\BacaPublisher;

use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class BacaPublisherSyncService
{
    public function __construct(
        private readonly BacaPublisherClient $client,
        private readonly BacaPublisherMapper $mapper,
    ) {
    }

    public function configured(): bool
    {
        return $this->client->configured();
    }

    public function testConnection(): array
    {
        return $this->client->testConnection();
    }

    public function sync(): array
    {
        $this->client->assertConfigured();

        $result = [
            'received' => 0,
            'created' => 0,
            'unchanged' => 0,
            'pending_updates' => 0,
            'skipped' => 0,
            'failed' => 0,
            'warnings' => [],
            'errors' => [],
        ];

        $submissions = $this->client->submissions();
        $result['received'] = count($submissions);

        foreach ($submissions as $submission) {
            if (!is_array($submission)) {
                $result['skipped']++;
                continue;
            }

            $submissionId = $submission['id'] ?? 'unknown';

            try {
                // Hanya data published yang masuk ke workflow BacaDulu.
                if ((int) ($submission['status'] ?? 0) !== 3) {
                    $result['skipped']++;
                    continue;
                }

                $publication = $this->mapper->chooseCurrentPublication($submission);

                if (!$publication) {
                    $result['skipped']++;
                    $result['warnings'][] = "Submission {$submissionId} tidak memiliki publication yang dapat diimport.";
                    continue;
                }

                $publication = $this->client->publication($submission, $publication);

                $catalogUrl = (string) (
                    $submission['urlPublished']
                        ?? $publication['urlPublished']
                        ?? ''
                );

                $catalog = $this->client->catalogMetadata($catalogUrl);
                $coverUrl = $this->client->coverUrl($submission, $publication, $catalog);

                $payload = $this->mapper->map(
                    $submission,
                    $publication,
                    $catalog,
                    $coverUrl,
                );

                if (trim((string) ($payload['external_id'] ?? '')) === '') {
                    $result['skipped']++;
                    $result['warnings'][] = "Submission {$submissionId} dilewati karena external ID kosong.";
                    continue;
                }

                if (trim((string) ($payload['title'] ?? '')) === '') {
                    $result['skipped']++;
                    $result['warnings'][] = "Submission {$submissionId} dilewati karena judul kosong.";
                    continue;
                }

                $book = Book::query()
                    ->where('source', 'bacapublisher')
                    ->where('external_id', (string) $payload['external_id'])
                    ->first();

                if (!$book) {
                    $this->createFromPayload($payload, $result);
                    $result['created']++;
                    continue;
                }

                $book->forceFill([
                    'last_synced_at' => now(),
                    'source_updated_at' => $payload['source_updated_at'] ?? $book->source_updated_at,
                ])->save();

                $baseline = is_array($book->api_payload) ? $book->api_payload : [];

                if ($baseline === []) {
                    // Record external lama yang belum punya baseline: simpan snapshot dulu
                    // tanpa menimpa data hasil edit admin.
                    $book->update([
                        'api_payload' => $payload,
                        'external_cover_url' => $book->external_cover_url ?: ($payload['cover_url'] ?? null),
                        'has_pending_sync' => false,
                        'pending_api_payload' => null,
                    ]);

                    $result['unchanged']++;
                    continue;
                }

                if ($this->fingerprint($baseline) === $this->fingerprint($payload)) {
                    $result['unchanged']++;
                    continue;
                }

                // Jangan timpa data yang sudah direview/edit admin. Simpan perubahan
                // terbaru dari API sebagai pending update sampai admin menerapkannya.
                $book->update([
                    'pending_api_payload' => $payload,
                    'has_pending_sync' => true,
                ]);

                $result['pending_updates']++;
            } catch (Throwable $e) {
                $result['failed']++;
                $result['errors'][] = "Submission {$submissionId}: " . $e->getMessage();
            }
        }

        return $result;
    }

    public function applyPendingUpdate(Book $book): Book
    {
        $payload = is_array($book->pending_api_payload)
            ? $book->pending_api_payload
            : [];

        if ($payload === []) {
            throw new RuntimeException('Tidak ada update API yang menunggu review untuk buku ini.');
        }

        $updates = $this->payloadToBookFields($payload, preserveEmpty: true);

        $newCoverPath = null;
        $oldCoverPath = $book->cover;
        $incomingCoverUrl = trim((string) ($payload['cover_url'] ?? ''));

        if (
            (bool) config('bacapublisher.download_covers', true)
            && $incomingCoverUrl !== ''
            && $this->canReplaceCoverFromApi($book)
            && $incomingCoverUrl !== (string) $book->external_cover_url
        ) {
            $newCoverPath = $this->saveRemoteCover(
                $incomingCoverUrl,
                (string) $book->external_id,
                (string) ($payload['publication_id'] ?? 'publication')
            );

            if ($newCoverPath) {
                $updates['cover'] = $newCoverPath;
            }
        }

        DB::transaction(function () use ($book, $payload, $updates, $incomingCoverUrl) {
            $book->update(array_merge($updates, [
                'api_payload' => $payload,
                'pending_api_payload' => null,
                'has_pending_sync' => false,
                'external_cover_url' => $incomingCoverUrl !== ''
                    ? $incomingCoverUrl
                    : $book->external_cover_url,
                'source_updated_at' => $payload['source_updated_at'] ?? $book->source_updated_at,
                'last_synced_at' => now(),

                // Perubahan sumber perlu ditinjau ulang sebelum tampil pada Publisher.
                'publisher_status' => Book::STATUS_PENDING,
                'publisher_review_note' => 'Metadata diperbarui dari BacaPublisher dan menunggu review admin.',
                'publisher_approved_at' => null,
            ]));
        });

        if (
            $newCoverPath
            && $oldCoverPath
            && $oldCoverPath !== $newCoverPath
            && str_starts_with($oldCoverPath, 'book-covers/bacapublisher-')
        ) {
            Storage::disk('public')->delete($oldCoverPath);
        }

        return $book->fresh();
    }

    /**
     * Abaikan update sumber tetapi jadikan snapshot tersebut baseline baru.
     * Dengan begitu update yang sama tidak muncul lagi pada sync berikutnya,
     * sementara data edit admin tetap utuh.
     */
    public function ignorePendingUpdate(Book $book): Book
    {
        $payload = is_array($book->pending_api_payload)
            ? $book->pending_api_payload
            : [];

        if ($payload === []) {
            throw new RuntimeException('Tidak ada update API yang dapat diabaikan.');
        }

        $book->update([
            'api_payload' => $payload,
            'pending_api_payload' => null,
            'has_pending_sync' => false,
            'external_cover_url' => $payload['cover_url'] ?? $book->external_cover_url,
            'source_updated_at' => $payload['source_updated_at'] ?? $book->source_updated_at,
            'last_synced_at' => now(),
        ]);

        return $book->fresh();
    }

    public function pendingDiff(Book $book): array
    {
        $payload = is_array($book->pending_api_payload)
            ? $book->pending_api_payload
            : [];

        if ($payload === []) {
            return [];
        }

        $pairs = [
            'title' => ['label' => 'Judul', 'current' => $book->title, 'incoming' => $payload['title'] ?? null],
            'author' => ['label' => 'Penulis', 'current' => $book->author, 'incoming' => $payload['author'] ?? null],
            'description' => ['label' => 'Sinopsis', 'current' => $book->description, 'incoming' => $payload['description'] ?? null],
            'publish_year' => ['label' => 'Tahun Terbit', 'current' => $book->publish_year, 'incoming' => $payload['publish_year'] ?? null],
            'isbn' => ['label' => 'ISBN', 'current' => $book->isbn, 'incoming' => $payload['isbn'] ?? null],
            'pages' => ['label' => 'Jumlah Halaman', 'current' => $book->pages, 'incoming' => $payload['pages'] ?? null],
            'cover_url' => ['label' => 'Cover', 'current' => $book->external_cover_url, 'incoming' => $payload['cover_url'] ?? null],
            'version' => ['label' => 'Versi Publisher', 'current' => $book->api_payload['version'] ?? null, 'incoming' => $payload['version'] ?? null],
            'source_url' => ['label' => 'URL Katalog', 'current' => $book->api_payload['source_url'] ?? null, 'incoming' => $payload['source_url'] ?? null],
        ];

        $diff = [];

        foreach ($pairs as $key => $item) {
            if ($this->comparable($item['current']) === $this->comparable($item['incoming'])) {
                continue;
            }

            $diff[$key] = $item;
        }

        return $diff;
    }

    private function createFromPayload(array $payload, array &$result): Book
    {
        $coverPath = null;
        $coverUrl = trim((string) ($payload['cover_url'] ?? ''));

        if ((bool) config('bacapublisher.download_covers', true) && $coverUrl !== '') {
            $coverPath = $this->saveRemoteCover(
                $coverUrl,
                (string) $payload['external_id'],
                (string) ($payload['publication_id'] ?? 'publication')
            );

            if (!$coverPath) {
                $result['warnings'][] = 'Cover submission '
                    . $payload['external_id']
                    . ' tidak dapat didownload. Metadata tetap diimport.';
            }
        }

        $author = trim((string) ($payload['author'] ?? ''));
        if ($author === '') {
            $author = 'Belum tersedia';
        }

        return DB::transaction(function () use ($payload, $coverPath, $coverUrl, $author) {
            return Book::create([
                'title' => trim((string) $payload['title']),
                'slug' => Book::makeSlug((string) $payload['title']),
                'publisher' => trim((string) ($payload['publisher'] ?? config('bacapublisher.publisher_name'))),
                'author' => $author,
                'category' => $payload['category'] ?: 'Umum',
                'pages' => $payload['pages'] ?? null,
                'size' => $payload['size'] ?? null,
                'isbn' => $payload['isbn'] ?? null,
                'publish_year' => $payload['publish_year'] ?? null,
                'description' => $payload['description'] ?? null,
                'cover' => $coverPath,

                // Legacy DB fields.
                'price' => 0,
                'has_print' => false,
                'print_stock' => 0,
                'has_ebook' => false,

                'source' => 'bacapublisher',
                'external_id' => (string) $payload['external_id'],
                'external_cover_url' => $coverUrl !== '' ? $coverUrl : null,

                'publisher_status' => Book::STATUS_PENDING,
                'publisher_review_note' => 'Data baru dari BacaPublisher. Periksa metadata sebelum Approve.',
                'publisher_approved_at' => null,

                'store_status' => Book::STATUS_PENDING,
                'store_review_note' => 'Buku baru dari BacaPublisher. Lengkapi format, harga, dan stok sebelum Approve.',
                'store_approved_at' => null,

                'last_synced_at' => now(),
                'source_updated_at' => $payload['source_updated_at'] ?? null,
                'api_payload' => $payload,
                'pending_api_payload' => null,
                'has_pending_sync' => false,
            ]);
        });
    }

    private function payloadToBookFields(array $payload, bool $preserveEmpty): array
    {
        $updates = [];

        $map = [
            'title' => 'title',
            'author' => 'author',
            'publisher' => 'publisher',
            'description' => 'description',
            'publish_year' => 'publish_year',
            'isbn' => 'isbn',
            'pages' => 'pages',
            'category' => 'category',
            'size' => 'size',
        ];

        foreach ($map as $payloadKey => $bookKey) {
            if (!array_key_exists($payloadKey, $payload)) {
                continue;
            }

            $value = $payload[$payloadKey];

            // Field kosong dari Publisher tidak boleh menghapus data yang sudah
            // dilengkapi admin BacaDulu.
            if ($preserveEmpty && ($value === null || (is_string($value) && trim($value) === ''))) {
                continue;
            }

            $updates[$bookKey] = $value;
        }

        return $updates;
    }

    private function saveRemoteCover(string $url, string $externalId, string $publicationId): ?string
    {
        $image = $this->client->downloadImage($url);

        if (!$image) {
            return null;
        }

        $hash = substr(hash('sha256', $url . '|' . strlen($image['body'])), 0, 12);
        $safeExternal = Str::slug($externalId) ?: 'book';
        $safePublication = Str::slug($publicationId) ?: 'publication';

        $path = 'book-covers/bacapublisher-'
            . $safeExternal
            . '-'
            . $safePublication
            . '-'
            . $hash
            . '.'
            . $image['extension'];

        Storage::disk('public')->put($path, $image['body']);

        return $path;
    }

    private function canReplaceCoverFromApi(Book $book): bool
    {
        if (!$book->cover) {
            return true;
        }

        // Cover yang pernah diupload manual admin tidak ditimpa otomatis.
        return str_starts_with((string) $book->cover, 'book-covers/bacapublisher-');
    }

    private function fingerprint(array $payload): string
    {
        $keys = [
            'external_id',
            'publication_id',
            'title',
            'author',
            'description',
            'publish_year',
            'date_published',
            'isbn',
            'pages',
            'cover_url',
            'source_url',
            'publication_url',
            'version',
            'status',
            'status_label',
            'formats',
        ];

        $stable = [];
        foreach ($keys as $key) {
            $stable[$key] = $payload[$key] ?? null;
        }

        return hash('sha256', json_encode($stable, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    private function comparable(mixed $value): string
    {
        if (is_array($value)) {
            return json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '';
        }

        if (is_string($value)) {
            return trim(preg_replace('/\s+/u', ' ', strip_tags($value)) ?? $value);
        }

        return $value === null ? '' : (string) $value;
    }
}
