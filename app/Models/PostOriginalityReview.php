<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostOriginalityCheck;
use Illuminate\Support\Str;

class PostOriginalityService
{
    /**
     * Pemeriksaan similarity internal BacaDulu.
     *
     * Yang diperiksa:
     * 1. exact copy;
     * 2. kemiripan terhadap satu sumber (pairwise);
     * 3. cakupan gabungan dari banyak sumber (multi-source coverage);
     * 4. maksimal Top-N sumber untuk review admin.
     *
     * PENTING:
     * - Badge Penulis Terverifikasi TIDAK memengaruhi skor.
     * - Sistem membandingkan bukti naskah, bukan status akun.
     * - Ini bukan Turnitin/iThenticate dan bukan penentu plagiarisme otomatis.
     * - Semantic/AI-paraphrase yang mengubah susunan kata secara besar masih
     *   membutuhkan lapisan semantic similarity terpisah.
     */
    public function inspect(
        string $content,
        ?int $ignorePostId = null,
        ?int $subjectUserId = null
    ): array {
        $normalized = $this->normalize($content);

        $limit = $this->limitPercent();
        $warningLimit = $this->warningPercent();

        if ($normalized === '') {
            return $this->emptyResult(
                $limit,
                $warningLimit
            );
        }

        $words = $this->words($normalized);
        $wordCount = count($words);
        $contentHash = hash(
            'sha256',
            $normalized
        );

        /*
        |--------------------------------------------------------------------------
        | Subject / bukti waktu
        |--------------------------------------------------------------------------
        |
        | Jika artikel sudah ada di database, pembanding hanya naskah yang
        | lebih dahulu tersimpan. Ini mencegah karya lama dituduh menyalin
        | artikel yang sebenarnya baru masuk sesudahnya.
        */
        $subjectPost = null;

        if ($ignorePostId) {
            $subjectPost = Post::query()
                ->select([
                    'id',
                    'user_id',
                    'created_at',
                ])
                ->find($ignorePostId);

            if (
                $subjectPost
                && $subjectUserId === null
            ) {
                $subjectUserId =
                    $subjectPost->user_id;
            }
        }

        $query = Post::query()
            ->select([
                'id',
                'user_id',
                'author',
                'title',
                'slug',
                'content',
                'status',
                'created_at',
            ])
            ->with([
                'user.authorVerification',
            ])
            ->whereIn(
                'status',
                [
                    'pending',
                    'approved',
                ]
            );

        if ($ignorePostId) {
            $query->where(
                'id',
                '!=',
                $ignorePostId
            );
        }

        if ($subjectPost) {
            $query->where(function ($priorQuery) use ($subjectPost) {
                $priorQuery
                    ->where(
                        'created_at',
                        '<',
                        $subjectPost->created_at
                    )
                    ->orWhere(function ($sameTimeQuery) use ($subjectPost) {
                        $sameTimeQuery
                            ->where(
                                'created_at',
                                '=',
                                $subjectPost->created_at
                            )
                            ->where(
                                'id',
                                '<',
                                $subjectPost->id
                            );
                    });
            });
        }

        $candidateLimit = max(
            50,
            min(
                5000,
                (int) config(
                    'bacadulu.originality.candidate_limit',
                    500
                )
            )
        );

        $candidates = $query
            ->orderBy('created_at')
            ->orderBy('id')
            ->limit($candidateLimit)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Shingle target
        |--------------------------------------------------------------------------
        */
        $shingleSize =
            $this->chooseShingleSize(
                $wordCount
            );

        $targetShingles =
            $this->shinglesWithPositions(
                $words,
                $shingleSize
            );

        $targetUniqueSet = [];

        foreach ($targetShingles as $row) {
            $targetUniqueSet[
                $row['hash']
            ] = true;
        }

        /*
        |--------------------------------------------------------------------------
        | Hasil per sumber
        |--------------------------------------------------------------------------
        */
        $sources = [];
        $unionCoveredWords = [];
        $exactMatch = false;

        foreach ($candidates as $candidate) {
            $candidateNormalized =
                $this->normalize(
                    (string) $candidate->content
                );

            if ($candidateNormalized === '') {
                continue;
            }

            $candidateHash = hash(
                'sha256',
                $candidateNormalized
            );

            /*
            |--------------------------------------------------------------------------
            | Exact copy
            |--------------------------------------------------------------------------
            */
            if (
                hash_equals(
                    $contentHash,
                    $candidateHash
                )
            ) {
                $allCovered = [];

                for (
                    $i = 0;
                    $i < $wordCount;
                    $i++
                ) {
                    $allCovered[$i] = true;
                    $unionCoveredWords[$i] = true;
                }

                $sources[] = $this->sourceResult(
                    candidate: $candidate,
                    subjectUserId: $subjectUserId,
                    score: 100.0,
                    coverage: 100.0,
                    jaccard: 100.0,
                    matchedShingles: max(
                        1,
                        count($targetShingles)
                    ),
                    exact: true,
                    coveredWordIndexes: array_keys(
                        $allCovered
                    )
                );

                $exactMatch = true;

                /*
                | Tetap lanjutkan pemeriksaan agar admin dapat melihat beberapa
                | sumber terdahulu jika naskah identik pernah muncul lebih dari
                | satu kali.
                */
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Teks sangat pendek
            |--------------------------------------------------------------------------
            |
            | Di bawah 8 kata hanya exact copy yang dianggap cukup stabil.
            */
            if (
                $wordCount < 8
                || $shingleSize <= 0
            ) {
                continue;
            }

            $candidateWords =
                $this->words(
                    $candidateNormalized
                );

            if (
                count($candidateWords)
                < $shingleSize
            ) {
                continue;
            }

            $candidateRows =
                $this->shinglesWithPositions(
                    $candidateWords,
                    $shingleSize
                );

            $candidateSet = [];

            foreach ($candidateRows as $row) {
                $candidateSet[
                    $row['hash']
                ] = true;
            }

            /*
            |--------------------------------------------------------------------------
            | Cari posisi shingle target yang ditemukan di kandidat
            |--------------------------------------------------------------------------
            */
            $matchedPositions = [];
            $coveredWords = [];

            foreach ($targetShingles as $targetRow) {
                if (
                    !isset(
                        $candidateSet[
                            $targetRow['hash']
                        ]
                    )
                ) {
                    continue;
                }

                $matchedPositions[
                    $targetRow['position']
                ] = true;

                for (
                    $wordIndex =
                        $targetRow['position'];
                    $wordIndex <
                        $targetRow['position']
                        + $shingleSize;
                    $wordIndex++
                ) {
                    if ($wordIndex < $wordCount) {
                        $coveredWords[
                            $wordIndex
                        ] = true;
                    }
                }
            }

            $matchedShingles =
                count($matchedPositions);

            /*
            |--------------------------------------------------------------------------
            | Filter noise
            |--------------------------------------------------------------------------
            |
            | Satu frasa umum tidak cukup untuk memasukkan sebuah artikel sebagai
            | sumber multi-source. Minimal dua shingle target harus cocok.
            */
            if ($matchedShingles < 2) {
                continue;
            }

            $coverage = $wordCount > 0
                ? (
                    count($coveredWords)
                    / $wordCount
                ) * 100
                : 0.0;

            $intersection = count(
                array_intersect_key(
                    $targetUniqueSet,
                    $candidateSet
                )
            );

            $union = count(
                $targetUniqueSet
                + $candidateSet
            );

            $jaccard = $union > 0
                ? (
                    $intersection
                    / $union
                ) * 100
                : 0.0;

            /*
            | Pairwise score menggunakan nilai yang lebih kuat antara:
            | - proporsi naskah target yang tercakup oleh sumber; dan
            | - Jaccard shingle.
            */
            $pairwiseScore = max(
                $coverage,
                $jaccard
            );

            /*
            | Abaikan match sangat kecil agar daftar sumber tidak penuh noise.
            */
            if (
                $coverage < 2.0
                && $pairwiseScore < 2.0
            ) {
                continue;
            }

            foreach (
                array_keys($coveredWords)
                as $coveredIndex
            ) {
                $unionCoveredWords[
                    $coveredIndex
                ] = true;
            }

            $sources[] = $this->sourceResult(
                candidate: $candidate,
                subjectUserId: $subjectUserId,
                score: round(
                    $pairwiseScore,
                    1
                ),
                coverage: round(
                    $coverage,
                    1
                ),
                jaccard: round(
                    $jaccard,
                    1
                ),
                matchedShingles:
                    $matchedShingles,
                exact: false,
                coveredWordIndexes:
                    array_keys(
                        $coveredWords
                    )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Urutkan sumber
        |--------------------------------------------------------------------------
        */
        usort(
            $sources,
            function (
                array $left,
                array $right
            ) {
                $scoreCompare =
                    $right['score']
                    <=>
                    $left['score'];

                if ($scoreCompare !== 0) {
                    return $scoreCompare;
                }

                $leftTime =
                    (string) (
                        $left['created_at']
                        ?? ''
                    );

                $rightTime =
                    (string) (
                        $right['created_at']
                        ?? ''
                    );

                $timeCompare =
                    $leftTime
                    <=>
                    $rightTime;

                if ($timeCompare !== 0) {
                    return $timeCompare;
                }

                return
                    (int) (
                        $left['post_id']
                        ?? 0
                    )
                    <=>
                    (int) (
                        $right['post_id']
                        ?? 0
                    );
            }
        );

        $topLimit = max(
            1,
            min(
                10,
                (int) config(
                    'bacadulu.originality.top_sources',
                    5
                )
            )
        );

        $topSources = array_slice(
            $sources,
            0,
            $topLimit
        );

        $maxPairwise = !empty($sources)
            ? (float) $sources[0]['score']
            : 0.0;

        $multiSourceCoverage =
            $wordCount > 0
                ? (
                    count($unionCoveredWords)
                    / $wordCount
                ) * 100
                : 0.0;

        $maxPairwise = round(
            $maxPairwise,
            1
        );

        $multiSourceCoverage = round(
            $multiSourceCoverage,
            1
        );

        $overallScore = max(
            $maxPairwise,
            $multiSourceCoverage
        );

        /*
        |--------------------------------------------------------------------------
        | Blocking
        |--------------------------------------------------------------------------
        |
        | Artikel dikunci bila:
        | - exact copy;
        | - satu sumber > batas;
        | - gabungan banyak sumber > batas.
        |
        | Tepat pada angka batas masih diperbolehkan untuk review biasa.
        */
        $blocked =
            $exactMatch
            || $maxPairwise > $limit
            || $multiSourceCoverage > $limit;

        $risk = match (true) {
            $exactMatch => 'critical',
            $blocked => 'high',
            $overallScore > $warningLimit => 'warning',
            default => 'safe',
        };

        return [
            /*
            | Backward compatibility.
            */
            'blocked' => $blocked,
            'exact' => $exactMatch,
            'score' => $overallScore,
            'matched_post' =>
                $topSources[0]['post']
                ?? null,

            /*
            | Detail baru.
            */
            'max_pairwise_score' =>
                $maxPairwise,

            'multi_source_coverage' =>
                $multiSourceCoverage,

            'overall_score' =>
                round(
                    $overallScore,
                    1
                ),

            'limit' => $limit,
            'warning_limit' =>
                $warningLimit,

            'word_count' =>
                $wordCount,

            'content_hash' =>
                $contentHash,

            'risk' => $risk,

            'manual_review_required' =>
                $blocked,

            'sources' =>
                $topSources,

            'source_count' =>
                count($sources),

            'status' =>
                $blocked
                    ? 'high'
                    : (
                        $risk === 'warning'
                            ? 'warning'
                            : 'safe'
                    ),
        ];
    }

    /**
     * Simpan snapshot audit hasil pemeriksaan.
     */
    public function recordCheck(
        Post $post,
        array $result,
        string $trigger,
        ?int $checkedBy = null
    ): PostOriginalityCheck {
        return PostOriginalityCheck::create([
            'post_id' => $post->id,
            'trigger' => $trigger,
            'checked_by' => $checkedBy,
            'content_hash' =>
                (string) (
                    $result['content_hash']
                    ?? hash(
                        'sha256',
                        $this->normalize(
                            (string) $post->content
                        )
                    )
                ),
            'word_count' =>
                (int) (
                    $result['word_count']
                    ?? 0
                ),
            'max_pairwise_score' =>
                (float) (
                    $result['max_pairwise_score']
                    ?? $result['score']
                    ?? 0
                ),
            'multi_source_coverage' =>
                (float) (
                    $result['multi_source_coverage']
                    ?? 0
                ),
            'overall_score' =>
                (float) (
                    $result['overall_score']
                    ?? $result['score']
                    ?? 0
                ),
            'warning_limit' =>
                (float) (
                    $result['warning_limit']
                    ?? $this->warningPercent()
                ),
            'blocking_limit' =>
                (float) (
                    $result['limit']
                    ?? $this->limitPercent()
                ),
            'exact_match' =>
                (bool) (
                    $result['exact']
                    ?? false
                ),
            'blocked' =>
                (bool) (
                    $result['blocked']
                    ?? false
                ),
            'top_sources' =>
                $this->snapshotSources(
                    $result['sources']
                    ?? []
                ),
        ]);
    }

    public function limitPercent(): float
    {
        return max(
            0,
            min(
                100,
                (float) config(
                    'bacadulu.originality.max_similarity',
                    20
                )
            )
        );
    }

    public function warningPercent(): float
    {
        $warning = max(
            0,
            min(
                100,
                (float) config(
                    'bacadulu.originality.warning_similarity',
                    10
                )
            )
        );

        return min(
            $warning,
            $this->limitPercent()
        );
    }

    private function sourceResult(
        Post $candidate,
        ?int $subjectUserId,
        float $score,
        float $coverage,
        float $jaccard,
        int $matchedShingles,
        bool $exact,
        array $coveredWordIndexes
    ): array {
        $authorName =
            $candidate->author
            ?: $candidate->user?->name
            ?: 'Tidak diketahui';

        return [
            /*
            | Object hanya dipakai selama request berjalan.
            | Tidak disimpan langsung sebagai JSON.
            */
            'post' => $candidate,

            'post_id' =>
                $candidate->id,

            'title' =>
                $candidate->title,

            'slug' =>
                $candidate->slug,

            'author' =>
                $authorName,

            'user_id' =>
                $candidate->user_id,

            'status' =>
                $candidate->status,

            'created_at' =>
                optional(
                    $candidate->created_at
                )->toISOString(),

            'score' =>
                $score,

            'coverage' =>
                $coverage,

            'jaccard' =>
                $jaccard,

            'matched_shingles' =>
                $matchedShingles,

            'exact' =>
                $exact,

            'self_overlap' =>
                $subjectUserId !== null
                && (int) $candidate->user_id
                    === (int) $subjectUserId,

            /*
            | Informasi identitas boleh ditampilkan kepada admin, tetapi
            | TIDAK memengaruhi hasil similarity.
            */
            'verified_author' =>
                (bool) (
                    $candidate
                        ->user
                        ?->isVerifiedAuthor()
                    ?? false
                ),

            /*
            | Digunakan hanya saat menghitung union coverage dalam request.
            | Snapshot audit tidak menyimpan daftar indeks ini.
            */
            'covered_word_indexes' =>
                $coveredWordIndexes,
        ];
    }

    private function snapshotSources(
        array $sources
    ): array {
        return array_map(
            function (array $source) {
                return [
                    'post_id' =>
                        $source['post_id']
                        ?? null,

                    'title' =>
                        $source['title']
                        ?? null,

                    'slug' =>
                        $source['slug']
                        ?? null,

                    'author' =>
                        $source['author']
                        ?? null,

                    'user_id' =>
                        $source['user_id']
                        ?? null,

                    'status' =>
                        $source['status']
                        ?? null,

                    'created_at' =>
                        $source['created_at']
                        ?? null,

                    'score' =>
                        (float) (
                            $source['score']
                            ?? 0
                        ),

                    'coverage' =>
                        (float) (
                            $source['coverage']
                            ?? 0
                        ),

                    'jaccard' =>
                        (float) (
                            $source['jaccard']
                            ?? 0
                        ),

                    'matched_shingles' =>
                        (int) (
                            $source['matched_shingles']
                            ?? 0
                        ),

                    'exact' =>
                        (bool) (
                            $source['exact']
                            ?? false
                        ),

                    'self_overlap' =>
                        (bool) (
                            $source['self_overlap']
                            ?? false
                        ),

                    'verified_author' =>
                        (bool) (
                            $source['verified_author']
                            ?? false
                        ),
                ];
            },
            $sources
        );
    }

    private function chooseShingleSize(
        int $wordCount
    ): int {
        return match (true) {
            $wordCount >= 120 => 6,
            $wordCount >= 60 => 5,
            $wordCount >= 30 => 4,
            $wordCount >= 8 => 3,
            default => 0,
        };
    }

    private function normalize(
        string $html
    ): string {
        $text = html_entity_decode(
            strip_tags($html),
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );

        $text = Str::lower($text);

        $text = preg_replace(
            '/[^\p{L}\p{N}\s]+/u',
            ' ',
            $text
        ) ?? '';

        $text = preg_replace(
            '/\s+/u',
            ' ',
            $text
        ) ?? '';

        return trim($text);
    }

    private function words(
        string $text
    ): array {
        return array_values(
            array_filter(
                preg_split(
                    '/\s+/u',
                    $text
                ) ?: [],
                fn ($word) =>
                    $word !== ''
            )
        );
    }

    private function shinglesWithPositions(
        array $words,
        int $size
    ): array {
        $count = count($words);

        if (
            $size <= 0
            || $count < $size
        ) {
            return [];
        }

        $rows = [];

        for (
            $i = 0;
            $i <= $count - $size;
            $i++
        ) {
            $rows[] = [
                'position' => $i,
                'hash' => sha1(
                    implode(
                        ' ',
                        array_slice(
                            $words,
                            $i,
                            $size
                        )
                    )
                ),
            ];
        }

        return $rows;
    }

    private function emptyResult(
        float $limit,
        float $warningLimit
    ): array {
        return [
            'blocked' => false,
            'exact' => false,
            'score' => 0.0,
            'matched_post' => null,
            'max_pairwise_score' => 0.0,
            'multi_source_coverage' => 0.0,
            'overall_score' => 0.0,
            'limit' => $limit,
            'warning_limit' => $warningLimit,
            'word_count' => 0,
            'content_hash' => hash(
                'sha256',
                ''
            ),
            'risk' => 'safe',
            'manual_review_required' => false,
            'sources' => [],
            'source_count' => 0,
            'status' => 'safe',
        ];
    }
}
