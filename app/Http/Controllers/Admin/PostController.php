<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
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
    public function update(
        Request $request,
        Post $post
    ) {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'author' => [
                'required',
                'string',
                'max:255',
            ],
            'category' => [
                'required',
                'in:Kesehatan,Sosial,Ekonomi,Teknik',
            ],
            'content' => [
                'required',
                'string',
            ],
            'status' => [
                'required',
                'in:pending,approved,rejected',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $validated['title'] = trim($validated['title']);
        $validated['author'] = trim($validated['author']);

        if ($post->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug(
                $validated['title'],
                $post->id
            );
        }

        $oldImage = $post->image;
        $newImagePath = null;

        try {
            if ($request->hasFile('image')) {
                $newImagePath = $request
                    ->file('image')
                    ->store('post-images', 'public');

                $validated['image'] = $newImagePath;
            }

            $post->update($validated);
        } catch (Throwable $e) {
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
            }

            throw $e;
        }

        if (
            $newImagePath &&
            $oldImage &&
            $oldImage !== $newImagePath
        ) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()
            ->route(
                'admin.posts.index',
                ['status' => $post->status]
            )
            ->with(
                'success',
                'Artikel berhasil diperbarui oleh admin.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    | Menyetujui artikel.
    |--------------------------------------------------------------------------
    */

    public function approve(Post $post)
    {
        /*
        |--------------------------------------------------------------------------
        | Ubah status menjadi approved
        |--------------------------------------------------------------------------
        */

        $post->update([
            'status' => 'approved',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Kembali ke halaman sebelumnya
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->back()
            ->with(
                'success',
                'Artikel berhasil disetujui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    | Menolak artikel.
    |--------------------------------------------------------------------------
    */

    public function reject(Post $post)
    {
        /*
        |--------------------------------------------------------------------------
        | Ubah status menjadi rejected
        |--------------------------------------------------------------------------
        */

        $post->update([
            'status' => 'rejected',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Kembali ke halaman sebelumnya
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->back()
            ->with(
                'success',
                'Artikel berhasil ditolak.'
            );
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