<?php

namespace App\Services\BacaPublisher;

use Illuminate\Support\Carbon;

class BacaPublisherMapper
{
    public function map(
        array $submission,
        array $publication,
        array $catalog = [],
        ?string $coverUrl = null
    ): array {
        $locale = (string) ($publication['locale'] ?? $submission['locale'] ?? 'en');

        $title = $this->localized(
            $publication['title']
                ?? $publication['fullTitle']
                ?? null,
            $locale
        );

        if ($title === '') {
            $title = $this->localized($publication['fullTitle'] ?? null, $locale);
        }

        $author = trim((string) (
            $publication['authorsString']
                ?? $publication['authorsStringIncludeInBrowse']
                ?? $publication['authorsStringShort']
                ?? ''
        ));

        $author = trim((string) preg_replace('/\s*\(Author\)\s*$/u', '', $author));

        $description = $this->firstNonEmpty([
            $this->localized($publication['abstract'] ?? null, $locale),
            $this->localized($publication['description'] ?? null, $locale),
            $this->localized($publication['synopsis'] ?? null, $locale),
            (string) ($catalog['description'] ?? ''),
        ]);

        $datePublished = trim((string) ($publication['datePublished'] ?? ''));
        $publishYear = null;

        if ($datePublished !== '') {
            try {
                $publishYear = Carbon::parse($datePublished)->year;
            } catch (\Throwable) {
                if (preg_match('/^(\d{4})/', $datePublished, $match)) {
                    $publishYear = (int) $match[1];
                }
            }
        }

        [$isbn, $pages, $formats] = $this->publicationFormatData(
            $publication['publicationFormats'] ?? []
        );

        $sourceUpdatedAt = $this->latestDate([
            $publication['lastModified'] ?? null,
            $publication['updatedAt'] ?? null,
            $submission['lastModified'] ?? null,
            $submission['dateLastActivity'] ?? null,
        ]);

        $publicationId = $publication['id'] ?? $submission['currentPublicationId'] ?? null;
        $submissionId = $submission['id'] ?? $publication['submissionId'] ?? null;

        $sourceUrl = trim((string) (
            $submission['urlPublished']
                ?? $publication['urlPublished']
                ?? ''
        ));

        $publicationUrl = trim((string) ($publication['urlPublished'] ?? ''));

        return [
            'external_id' => $submissionId !== null ? (string) $submissionId : null,
            'publication_id' => $publicationId !== null ? (string) $publicationId : null,
            'title' => $title,
            'author' => $author,
            'publisher' => (string) config('bacapublisher.publisher_name', 'Baca Dulu Publisher'),
            'description' => $description !== '' ? $description : null,
            'publish_year' => $publishYear,
            'date_published' => $datePublished !== '' ? $datePublished : null,
            'isbn' => $isbn,
            'pages' => $pages,
            'category' => null,
            'size' => null,
            'cover_url' => $coverUrl,
            'source_url' => $sourceUrl !== '' ? $sourceUrl : null,
            'publication_url' => $publicationUrl !== '' ? $publicationUrl : null,
            'version' => $publication['version'] ?? null,
            'status' => $submission['status'] ?? $publication['status'] ?? null,
            'status_label' => $submission['statusLabel'] ?? null,
            'work_type' => $submission['workType'] ?? null,
            'source_updated_at' => $sourceUpdatedAt,
            'formats' => $formats,
            'source_snapshot' => [
                'submission' => [
                    'id' => $submission['id'] ?? null,
                    'contextId' => $submission['contextId'] ?? null,
                    'currentPublicationId' => $submission['currentPublicationId'] ?? null,
                    'dateSubmitted' => $submission['dateSubmitted'] ?? null,
                    'dateLastActivity' => $submission['dateLastActivity'] ?? null,
                    'lastModified' => $submission['lastModified'] ?? null,
                    'locale' => $submission['locale'] ?? null,
                    'status' => $submission['status'] ?? null,
                    'statusLabel' => $submission['statusLabel'] ?? null,
                    'urlPublished' => $submission['urlPublished'] ?? null,
                    'workType' => $submission['workType'] ?? null,
                ],
                'publication' => [
                    'id' => $publication['id'] ?? null,
                    'submissionId' => $publication['submissionId'] ?? null,
                    'authorsString' => $publication['authorsString'] ?? null,
                    'authorsStringShort' => $publication['authorsStringShort'] ?? null,
                    'coverImage' => $publication['coverImage'] ?? null,
                    'datePublished' => $publication['datePublished'] ?? null,
                    'fullTitle' => $publication['fullTitle'] ?? null,
                    'locale' => $publication['locale'] ?? null,
                    'publicationFormats' => $publication['publicationFormats'] ?? [],
                    'status' => $publication['status'] ?? null,
                    'title' => $publication['title'] ?? null,
                    'urlPublished' => $publication['urlPublished'] ?? null,
                    'version' => $publication['version'] ?? null,
                    'abstract' => $publication['abstract'] ?? null,
                    'description' => $publication['description'] ?? null,
                ],
            ],
        ];
    }

    public function chooseCurrentPublication(array $submission): ?array
    {
        $publications = $submission['publications'] ?? [];

        if (!is_array($publications) || $publications === []) {
            return null;
        }

        $currentId = $submission['currentPublicationId'] ?? null;

        if ($currentId !== null) {
            foreach ($publications as $publication) {
                if ((string) ($publication['id'] ?? '') === (string) $currentId) {
                    return is_array($publication) ? $publication : null;
                }
            }
        }

        $published = array_values(array_filter(
            $publications,
            static fn ($publication) => is_array($publication)
                && (int) ($publication['status'] ?? 0) === 3
        ));

        if ($published !== []) {
            usort(
                $published,
                static fn ($a, $b) => (int) ($b['version'] ?? 0) <=> (int) ($a['version'] ?? 0)
            );

            return $published[0];
        }

        $first = $publications[0] ?? null;
        return is_array($first) ? $first : null;
    }

    private function localized(mixed $value, string $locale): string
    {
        if (is_string($value) || is_numeric($value)) {
            return trim((string) $value);
        }

        if (!is_array($value)) {
            return '';
        }

        foreach ([$locale, 'id_ID', 'id', 'en_US', 'en'] as $key) {
            if (isset($value[$key]) && (is_string($value[$key]) || is_numeric($value[$key]))) {
                $candidate = trim((string) $value[$key]);
                if ($candidate !== '') {
                    return $candidate;
                }
            }
        }

        foreach ($value as $candidate) {
            if (is_string($candidate) || is_numeric($candidate)) {
                $candidate = trim((string) $candidate);
                if ($candidate !== '') {
                    return $candidate;
                }
            }
        }

        return '';
    }

    private function firstNonEmpty(array $values): string
    {
        foreach ($values as $value) {
            $value = trim((string) $value);
            if ($value !== '') {
                return $value;
            }
        }

        return '';
    }

    private function publicationFormatData(mixed $formats): array
    {
        if (!is_array($formats)) {
            return [null, null, []];
        }

        $isbn = null;
        $pages = null;
        $summary = [];

        foreach ($formats as $format) {
            if (!is_array($format)) {
                continue;
            }

            $locale = 'en';
            $name = $this->localized($format['name'] ?? null, $locale);

            $summary[] = [
                'id' => $format['id'] ?? null,
                'name' => $name !== '' ? $name : null,
                'physicalFormat' => $format['physicalFormat'] ?? null,
                'isApproved' => $format['isApproved'] ?? null,
                'isAvailable' => $format['isAvailable'] ?? null,
                'fileSize' => $format['fileSize'] ?? null,
                'urlRemote' => $format['urlRemote'] ?? null,
                'urlPath' => $format['urlPath'] ?? null,
            ];

            if ($isbn === null) {
                foreach (
                    [
                        $format['isbn'] ?? null,
                        $format['identificationCode'] ?? null,
                        $format['productIdentifier'] ?? null,
                        $format['pub-id::publisher-id'] ?? null,
                    ] as $candidate
                ) {
                    $candidate = trim((string) $candidate);
                    if ($candidate !== '') {
                        $isbn = $candidate;
                        break;
                    }
                }
            }

            if ($pages === null) {
                foreach (
                    [
                        $format['pages'] ?? null,
                        $format['numberOfPages'] ?? null,
                        $format['pageCount'] ?? null,
                        $format['extent'] ?? null,
                    ] as $candidate
                ) {
                    if (is_numeric($candidate) && (int) $candidate > 0) {
                        $pages = (int) $candidate;
                        break;
                    }
                }
            }
        }

        return [$isbn, $pages, $summary];
    }

    private function latestDate(array $values): ?string
    {
        $dates = [];

        foreach ($values as $value) {
            if (!$value) {
                continue;
            }

            try {
                $dates[] = Carbon::parse($value);
            } catch (\Throwable) {
                // Abaikan tanggal yang tidak valid dari sumber.
            }
        }

        if ($dates === []) {
            return null;
        }

        usort($dates, static fn (Carbon $a, Carbon $b) => $b->getTimestamp() <=> $a->getTimestamp());

        return $dates[0]->format('Y-m-d H:i:s');
    }
}
