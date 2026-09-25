<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostAuditEvent;
use App\Models\PostOriginalityReview;
use App\Services\PostOriginalityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class PostController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    | Menampilkan daftar artikel di dashboard admin.
    |
    | Status yang tersedia:
    | - pending
    | - approved
    | - rejected
    | - all
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil status dari URL
        |--------------------------------------------------------------------------
        |
        | Contoh:
        | /admin/posts?status=pending
        | /admin/posts?status=approved
        | /admin/posts?status=rejected
        | /admin/posts?status=all
        |
        | Jika tidak ada status, default = pending.
        |--------------------------------------------------------------------------
        */

        $status = $request->get('status', 'pending');


        /*
        |--------------------------------------------------------------------------
        | Validasi status
        |--------------------------------------------------------------------------
        */

        $allowedStatuses = [
            'pending',
            'approved',
            'rejected',
            'all',
        ];


        /*
        |--------------------------------------------------------------------------
        | Jika status tidak valid, kembalikan ke pending
        |--------------------------------------------------------------------------
        */

        if (!in_array($status, $allowedStatuses, true)) {
            $status = 'pending';
        }


        /*
        |--------------------------------------------------------------------------
        | Query artikel
        |--------------------------------------------------------------------------
        */

        $query = Post::query()
            ->with(['user.authorVerification'])
            ->latest();


        /*
        |--------------------------------------------------------------------------
        | Filter status
        |--------------------------------------------------------------------------
        |
        | Jika "all", jangan tambahkan kondisi where.
        |--------------------------------------------------------------------------
        */

        if ($status !== 'all') {
            $query->where(
                'status',
                $status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $posts = $query
            ->paginate(15)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Similarity internal untuk tampilan CMS
        |--------------------------------------------------------------------------
        |
        | Hasil ini tidak disimpan ke database. Setiap halaman admin dibuka,
        | artikel pada halaman tersebut dihitung ulang agar mengikuti isi naskah
        | terbaru dan batas similarity terbaru.
        */
        $originalityService = app(
            PostOriginalityService::class
        );

        foreach ($posts as $post) {
            $result = $originalityService->inspect(
                $post->content,
                $post->id
            );

            if ($result['matched_post']) {
                $result['matched_post']->loadMissing(
                    'user'
                );
            }

            $post->setAttribute(
                'originality_result',
                $result
            );

            $post->setAttribute(
                'originality_review',
                PostOriginalityReview::query()
                    ->where('post_id', $post->id)
                    ->where('manuscript_hash', $result['manuscript_hash'])
                    ->first()
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Kirim posts DAN status ke view
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.posts.index',
            compact(
                'posts',
                'status'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    | Menampilkan halaman edit artikel untuk admin.
    |--------------------------------------------------------------------------
    */

    public function edit(Post $post)
    {
        return view(
            'admin.posts.edit',
            compact('post')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    | Admin dapat memperbarui artikel milik user/penulis.
    |
    | Yang dapat diubah:
    | - Judul
    | - Penulis
    | - Kategori
    | - Isi
    | - Status
    | - Gambar
    |
    | user_id tidak diubah.
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:Kesehatan,Sosial,Ekonomi,Teknik'],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:pending,approved,rejected'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $validated['title'] = trim($validated['title']);
        $validated['author'] = trim($validated['author']);

        $service = app(PostOriginalityService::class);
        $originality = $service->inspect($validated['content'], $post->id);
        $incomingHash = $originality['manuscript_hash'];
        $currentHash = $service->manuscriptHash($post->content);
        $contentChanged = !hash_equals($currentHash, $incomingHash);

        if ($validated['status'] === 'approved' && $originality['blocked']) {
            $review = PostOriginalityReview::query()
                ->where('post_id', $post->id)
                ->where('manuscript_hash', $incomingHash)
                ->first();

            if (!$review || $review->decision !== 'legitimate_overlap') {
                return redirect()->back()->withInput()->with(
                    'error',
                    'Artikel ini wajib melewati Originality Review manual sebelum dapat disetujui. Pilih keputusan "Overlap sah karena kutipan/atribusi" hanya jika bukti memang mendukung.'
                );
            }
        }

        if ($contentChanged && $validated['status'] === 'approved') {
            $validated['status'] = 'pending';
        }

        if ($post->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $post->id);
        }

        $oldImage = $post->image;
        $newImagePath = null;

        try {
            if ($request->hasFile('image')) {
                $newImagePath = $request->file('image')->store('post-images', 'public');
                $validated['image'] = $newImagePath;
            }

            $post->update($validated);
        } catch (Throwable $e) {
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }
            throw $e;
        }

        if ($newImagePath && $oldImage && $oldImage !== $newImagePath) {
            Storage::disk('public')->delete($oldImage);
        }

        $post->refresh();
        $this->storeScan($post, $originality);

        if ($contentChanged) {
            $this->audit($post, 'content_revised_by_admin', $incomingHash, [
                'originality_coverage' => $originality['coverage'],
                'status_after_edit' => $post->status,
            ]);
        }

        return redirect()
            ->route('admin.posts.index', ['status' => $post->status])
            ->with('success', $contentChanged
                ? 'Artikel diperbarui. Karena isi naskah berubah, keputusan originality sebelumnya tidak berlaku untuk versi baru.'
                : 'Artikel berhasil diperbarui oleh admin.');
    }

    public function originality(Post $post)
    {
        $post->load(['user.authorVerification']);
        $result = app(PostOriginalityService::class)->inspect($post->content, $post->id);
        $review = $this->storeScan($post, $result);
        $auditEvents = $post->auditEvents()->with('actor')->latest('created_at')->limit(50)->get();

        return view('admin.posts.originality', compact('post', 'result', 'review', 'auditEvents'));
    }

    public function reviewOriginality(Request $request, Post $post)
    {
        $validated = $request->validate([
            'decision' => ['required', 'in:legitimate_overlap,revision_required,reject_substantial_copy'],
            'decision_note' => ['required', 'string', 'max:2000'],
        ]);

        $result = app(PostOriginalityService::class)->inspect($post->content, $post->id);
        $review = $this->storeScan($post, $result);

        $review->update([
            'decision' => $validated['decision'],
            'decision_note' => trim($validated['decision_note']),
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        $this->audit($post, 'originality_manual_decision', $result['manuscript_hash'], [
            'decision' => $validated['decision'],
            'note' => trim($validated['decision_note']),
            'coverage' => $result['coverage'],
            'source_count' => $result['source_count'],
        ]);

        if ($validated['decision'] === 'reject_substantial_copy') {
            return $this->rejectWithOriginality($post, $result, trim($validated['decision_note']));
        }

        return redirect()->route('admin.posts.originality', $post)->with(
            'success',
            $validated['decision'] === 'legitimate_overlap'
                ? 'Keputusan tersimpan. Tombol approve untuk versi naskah ini sekarang dapat dibuka.'
                : 'Keputusan revisi tersimpan. Artikel tetap belum dapat disetujui sampai naskah diperbaiki.'
        );
    }

    public function approve(Post $post)
    {
        $service = app(PostOriginalityService::class);
        $result = $service->inspect($post->content, $post->id);
        $review = $this->storeScan($post, $result);

        if ($result['blocked'] && $review->decision !== 'legitimate_overlap') {
            return redirect()->back()->with(
                'error',
                'Approve dikunci. Multi-source coverage melewati batas dan belum ada keputusan manual yang menyatakan overlap sah untuk versi naskah ini.'
            );
        }

        if ($review->decision === 'revision_required' || $review->decision === 'reject_substantial_copy') {
            return redirect()->back()->with('error', 'Approve dikunci oleh keputusan Originality Review terbaru.');
        }

        $post->update([
            'status' => 'approved',
            'rejection_reason' => null,
            'similarity_score' => null,
            'similarity_source_post_id' => null,
            'similarity_source_title' => null,
            'similarity_source_author' => null,
            'rejected_at' => null,
        ]);

        $this->audit($post, 'approved', $result['manuscript_hash'], [
            'coverage' => $result['coverage'],
            'manual_decision' => $review->decision,
        ]);

        return redirect()->back()->with('success', 'Artikel berhasil disetujui.');
    }

    public function reject(Post $post)
    {
        $result = app(PostOriginalityService::class)->inspect($post->content, $post->id);
        $this->storeScan($post, $result);
        return $this->rejectWithOriginality($post, $result);
    }

    private function rejectWithOriginality(Post $post, array $result, ?string $adminNote = null)
    {
        $matchedPost = $result['matched_post'];
        $score = (float) $result['coverage'];
        $limit = (float) $result['limit'];

        if ($result['blocked']) {
            $scoreText = number_format($score, 1, ',', '.');
            $limitText = number_format($limit, 1, ',', '.');
            $reason = "Artikel ditolak setelah Originality Review. Multi-source coverage {$scoreText}% melebihi batas review {$limitText}%. ";

            if ($matchedPost && $matchedPost->status === 'approved') {
                $reason .= 'Salah satu sumber kecocokan utama adalah "'.$matchedPost->title.'". ';
            } else {
                $reason .= 'Sistem menemukan kecocokan dengan satu atau lebih naskah yang lebih dahulu tersimpan di BacaDulu. ';
            }

            $reason .= 'Silakan perbaiki sintesis, parafrasa, kutipan, dan atribusi sumber sebelum mengirim ulang.';
        } else {
            $reason = 'Artikel belum dapat diterbitkan berdasarkan hasil review admin. Silakan perbaiki naskah dan kirim ulang.';
        }

        if ($adminNote) {
            $reason .= ' Catatan admin: '.$adminNote;
        }

        $post->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'similarity_score' => $result['blocked'] ? $score : null,
            'similarity_source_post_id' => $result['blocked'] && $matchedPost ? $matchedPost->id : null,
            'similarity_source_title' => $result['blocked'] && $matchedPost ? $matchedPost->title : null,
            'similarity_source_author' => $result['blocked'] && $matchedPost
                ? ($matchedPost->author ?: $matchedPost->user?->name)
                : null,
            'rejected_at' => now(),
        ]);

        $this->audit($post, 'rejected', $result['manuscript_hash'], [
            'coverage' => $result['coverage'],
            'source_count' => $result['source_count'],
            'admin_note' => $adminNote,
        ]);

        return redirect()->back()->with('success', 'Artikel berhasil ditolak dan alasan review disimpan pada audit trail.');
    }

    private function storeScan(Post $post, array $result): PostOriginalityReview
    {
        $sources = collect($result['sources'] ?? [])->map(function (array $source) {
            return [
                'post_id' => $source['post_id'],
                'title' => $source['title'],
                'author' => $source['author'],
                'status' => $source['status'],
                'created_at' => optional($source['created_at'])->toIso8601String(),
                'coverage' => $source['coverage'],
                'exact' => $source['exact'],
            ];
        })->values()->all();

        return PostOriginalityReview::updateOrCreate(
            ['post_id' => $post->id, 'manuscript_hash' => $result['manuscript_hash']],
            [
                'coverage' => $result['coverage'],
                'review_limit' => $result['limit'],
                'scan_status' => $result['status'],
                'exact_copy' => $result['exact'],
                'source_count' => $result['source_count'],
                'top_sources' => $sources,
            ]
        );
    }

    private function audit(Post $post, string $event, ?string $hash = null, array $metadata = []): void
    {
        PostAuditEvent::create([
            'post_id' => $post->id,
            'actor_user_id' => auth()->id(),
            'event' => $event,
            'manuscript_hash' => $hash,
            'metadata' => $metadata,
            'created_at' => now(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    | Menghapus artikel dari dashboard admin.
    |--------------------------------------------------------------------------
    */
    public function destroy(Post $post)
    {
        $imagePath = $post->image;

        $post->delete();

        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()
            ->route(
                'admin.posts.index',
                ['status' => 'all']
            )
            ->with(
                'success',
                'Artikel berhasil dihapus.'
            );
    }


    private function generateUniqueSlug(
        string $title,
        ?int $ignoreId = null
    ): string {
        $base = Str::slug($title);

        if ($base === '') {
            $base = 'artikel';
        }

        $slug = $base;
        $counter = 1;

        while (
            Post::query()
                ->where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) => $query->where('id', '!=', $ignoreId)
                )
                ->exists()
        ) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}