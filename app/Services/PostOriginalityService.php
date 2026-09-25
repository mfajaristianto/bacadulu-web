<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Str;

class PostOriginalityService
{
    /**
     * Similarity internal BacaDulu.
     *
     * Prinsip:
     * - Semua penulis diperlakukan sama, termasuk Penulis Terverifikasi.
     * - Skor utama = multi-source unique coverage, bukan skor sumber tertinggi.
     * - Top sources tetap ditampilkan agar admin dapat menelusuri asal overlap.
     * - Nilai similarity bukan vonis plagiarisme; keputusan akhir tetap manual.
     */
    public function inspect(string $content, ?int $ignorePostId = null): array
    {
        $normalized = $this->normalize($content);
        $limit = $this->limitPercent();
        $warningLimit = $this->warningPercent();

        if ($normalized === '') {
            return $this->emptyResult($limit, $warningLimit);
        }

        $words = $this->words($normalized);
        $wordCount = count($words);
        $manuscriptHash = hash('sha256', $normalized);

        $subjectPost = $ignorePostId
            ? Post::query()->select(['id', 'created_at'])->find($ignorePostId)
            : null;

        if ($wordCount < 8) {
            return $this->inspectShortText(
                $normalized,
                $manuscriptHash,
                $wordCount,
                $limit,
                $warningLimit,
                $ignorePostId
            );
        }

        $shingleSize = match (true) {
            $wordCount >= 120 => 6,
            $wordCount >= 60 => 5,
            $wordCount >= 30 => 4,
            default => 3,
        };

        // Posisi shingle pada naskah yang diperiksa. Posisi inilah yang dipakai
        // untuk unique coverage sehingga overlap dari beberapa sumber tidak
        // dihitung dua kali.
        $subjectSequence = $this->shingleSequence($words, $shingleSize);
        $subjectCount = count($subjectSequence);
        $subjectHashToPositions = [];

        foreach ($subjectSequence as $position => $hash) {
            $subjectHashToPositions[$hash][] = $position;
        }

        $coveredPositions = [];
        $sources = [];
        $exact = false;

        foreach ($this->candidateQuery($ignorePostId, $subjectPost)->limit($this->candidateLimit())->get() as $candidate) {
            $candidateNormalized = $this->normalize((string) $candidate->content);

            if ($candidateNormalized === '') {
                continue;
            }

            $candidateHash = hash('sha256', $candidateNormalized);
            $isExact = hash_equals($manuscriptHash, $candidateHash);
            $matchedPositions = [];

            if ($isExact) {
                $matchedPositions = array_keys($subjectSequence);
                $exact = true;
            } else {
                $candidateWords = $this->words($candidateNormalized);

                if (count($candidateWords) < $shingleSize) {
                    continue;
                }

                $candidateShingles = $this->shingles($candidateWords, $shingleSize);

                foreach ($candidateShingles as $hash => $_true) {
                    foreach ($subjectHashToPositions[$hash] ?? [] as $position) {
                        $matchedPositions[$position] = true;
                    }
                }

                $matchedPositions = array_keys($matchedPositions);
            }

            if (!$matchedPositions) {
                continue;
            }

            $coverage = $subjectCount > 0
                ? (count($matchedPositions) / $subjectCount) * 100
                : 0.0;

            // Abaikan noise sangat kecil kecuali exact copy. Posisi dari sumber
            // noise juga tidak dimasukkan ke unique coverage.
            if (!$isExact && $coverage < 1.0) {
                continue;
            }

            foreach ($matchedPositions as $position) {
                $coveredPositions[$position] = true;
            }

            $sources[] = [
                'post' => $candidate,
                'post_id' => $candidate->id,
                'title' => $candidate->title,
                'author' => $candidate->author ?: ($candidate->user?->name ?? '-'),
                'status' => $candidate->status,
                'created_at' => $candidate->created_at,
                'coverage' => round($coverage, 1),
                'exact' => $isExact,
                'matched_shingles' => count($matchedPositions),
            ];
        }

        usort($sources, fn (array $a, array $b) => $b['coverage'] <=> $a['coverage']);
        $topSources = array_slice($sources, 0, $this->topSourcesLimit());

        $coveragePercent = $subjectCount > 0
            ? round((count($coveredPositions) / $subjectCount) * 100, 1)
            : 0.0;

        $blocked = $exact || $coveragePercent > $limit;
        $status = $exact || $coveragePercent > $limit
            ? 'high'
            : ($coveragePercent > $warningLimit ? 'warning' : 'safe');

        return [
            'blocked' => $blocked,
            'requires_manual_review' => $blocked,
            'exact' => $exact,
            'score' => $coveragePercent,
            'coverage' => $coveragePercent,
            'limit' => $limit,
            'warning_limit' => $warningLimit,
            'word_count' => $wordCount,
            'shingle_size' => $shingleSize,
            'manuscript_hash' => $manuscriptHash,
            'matched_post' => $topSources[0]['post'] ?? null,
            'sources' => $topSources,
            'source_count' => count($sources),
            'status' => $status,
        ];
    }

    public function manuscriptHash(string $content): string
    {
        return hash('sha256', $this->normalize($content));
    }

    public function limitPercent(): float
    {
        return max(0, min(100, (float) config('bacadulu.originality.max_similarity', 20)));
    }

    public function warningPercent(): float
    {
        return max(0, min($this->limitPercent(), (float) config('bacadulu.originality.warning_similarity', 10)));
    }

    public function topSourcesLimit(): int
    {
        return max(1, min(10, (int) config('bacadulu.originality.top_sources', 5)));
    }

    public function candidateLimit(): int
    {
        return max(50, min(5000, (int) config('bacadulu.originality.candidate_limit', 1000)));
    }

    private function candidateQuery(?int $ignorePostId, ?Post $subjectPost = null)
    {
        $query = Post::query()
            ->with('user')
            ->select(['id', 'title', 'slug', 'author', 'content', 'status', 'user_id', 'created_at'])
            ->whereIn('status', ['pending', 'approved', 'rejected'])
            ->oldest('created_at');

        if ($ignorePostId) {
            $query->where('id', '!=', $ignorePostId);
        }

        /*
         * Hanya bandingkan dengan naskah yang sudah ada lebih dahulu.
         * Ini mencegah artikel lama dianggap menyalin artikel yang baru masuk.
         */
        if ($subjectPost) {
            $query->where(function ($prior) use ($subjectPost) {
                $prior->where('created_at', '<', $subjectPost->created_at)
                    ->orWhere(function ($sameTime) use ($subjectPost) {
                        $sameTime->where('created_at', '=', $subjectPost->created_at)
                            ->where('id', '<', $subjectPost->id);
                    });
            });
        }

        return $query;
    }

    private function inspectShortText(
        string $normalized,
        string $manuscriptHash,
        int $wordCount,
        float $limit,
        float $warningLimit,
        ?int $ignorePostId
    ): array {
        $subjectPost = $ignorePostId
            ? Post::query()->select(['id', 'created_at'])->find($ignorePostId)
            : null;

        foreach ($this->candidateQuery($ignorePostId, $subjectPost)->limit($this->candidateLimit())->get() as $candidate) {
            $candidateNormalized = $this->normalize((string) $candidate->content);

            if ($candidateNormalized !== '' && hash_equals($manuscriptHash, hash('sha256', $candidateNormalized))) {
                return [
                    'blocked' => true,
                    'requires_manual_review' => true,
                    'exact' => true,
                    'score' => 100.0,
                    'coverage' => 100.0,
                    'limit' => $limit,
                    'warning_limit' => $warningLimit,
                    'word_count' => $wordCount,
                    'shingle_size' => null,
                    'manuscript_hash' => $manuscriptHash,
                    'matched_post' => $candidate,
                    'sources' => [[
                        'post' => $candidate,
                        'post_id' => $candidate->id,
                        'title' => $candidate->title,
                        'author' => $candidate->author ?: ($candidate->user?->name ?? '-'),
                        'status' => $candidate->status,
                        'created_at' => $candidate->created_at,
                        'coverage' => 100.0,
                        'exact' => true,
                        'matched_shingles' => null,
                    ]],
                    'source_count' => 1,
                    'status' => 'high',
                ];
            }
        }

        return array_merge($this->emptyResult($limit, $warningLimit), [
            'word_count' => $wordCount,
            'manuscript_hash' => $manuscriptHash,
        ]);
    }

    private function normalize(string $html): string
    {
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = Str::lower($text);
        $text = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', $text) ?? '';
        $text = preg_replace('/\s+/u', ' ', $text) ?? '';

        return trim($text);
    }

    private function words(string $text): array
    {
        return array_values(array_filter(
            preg_split('/\s+/u', $text) ?: [],
            fn ($word) => $word !== ''
        ));
    }

    private function shingles(array $words, int $size): array
    {
        $set = [];
        foreach ($this->shingleSequence($words, $size) as $hash) {
            $set[$hash] = true;
        }
        return $set;
    }

    private function shingleSequence(array $words, int $size): array
    {
        $count = count($words);
        if ($count < $size) {
            return [];
        }

        $sequence = [];
        for ($i = 0; $i <= $count - $size; $i++) {
            $sequence[$i] = sha1(implode(' ', array_slice($words, $i, $size)));
        }
        return $sequence;
    }

    private function emptyResult(float $limit, float $warningLimit): array
    {
        return [
            'blocked' => false,
            'requires_manual_review' => false,
            'exact' => false,
            'score' => 0.0,
            'coverage' => 0.0,
            'limit' => $limit,
            'warning_limit' => $warningLimit,
            'word_count' => 0,
            'shingle_size' => null,
            'manuscript_hash' => hash('sha256', ''),
            'matched_post' => null,
            'sources' => [],
            'source_count' => 0,
            'status' => 'safe',
        ];
    }
}
