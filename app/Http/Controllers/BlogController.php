<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Tampilkan daftar artikel yang sudah disetujui
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY ARTIKEL
        |--------------------------------------------------------------------------
        */

        $query = Post::with([
                'user',
                'comments',
                'likes',
            ])
            ->withCount([
                'likes',
                'comments',
            ])
            ->where('status', 'approved');


        /*
        |--------------------------------------------------------------------------
        | FILTER KATEGORI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category')) {
            $query->where(
                'category',
                $request->category
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        |
        | Mendukung tombol:
        |
        | Top
        | Terbaru
        | Terpopuler
        |
        */

        $sort = $request->get('sort', 'top');


        if ($sort === 'terbaru') {

            $query->latest();

        } elseif ($sort === 'terpopuler') {

            $query
                ->orderByDesc('views')
                ->latest();

        } else {

            /*
            |--------------------------------------------------------------------------
            | TOP
            |--------------------------------------------------------------------------
            */

            $query
                ->orderByDesc('likes_count')
                ->orderByDesc('views')
                ->latest();
        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $posts = $query
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | KATEGORI AKTIF
        |--------------------------------------------------------------------------
        */

        $category = $request->category;


        return view(
            'blog.index',
            compact(
                'posts',
                'category'
            )
        );
    }


    /**
     * Tampilkan form buat artikel
     */
    public function create()
    {
        return view('blog.create');
    }


    /**
     * Simpan artikel baru
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'content' => [
                'required',
                'string',
            ],

            'category' => [
                'required',
                'in:Kesehatan,Sosial,Ekonomi,Teknik',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | UPLOAD GAMBAR
        |--------------------------------------------------------------------------
        */

        $imagePath = null;

        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store(
                    'post-images',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN ARTIKEL
        |--------------------------------------------------------------------------
        */

        Post::create([
            'user_id' => auth()->id(),

            'author' => auth()->user()->name,

            'title' => $request->title,

            'slug' => Str::slug($request->title)
                . '-'
                . time(),

            'content' => $request->content,

            'image' => $imagePath,

            'category' => $request->category,

            'status' => 'pending',

            'views' => 0,
        ]);


        return redirect()
            ->route('blog.myPosts')
            ->with(
                'success',
                'Artikel berhasil dikirim! Menunggu persetujuan admin.'
            );
    }


    /**
     * Tampilkan detail artikel
     */
    public function show(Post $post)
    {
        /*
        |--------------------------------------------------------------------------
        | ARTIKEL PENDING / REJECTED
        |--------------------------------------------------------------------------
        |
        | Hanya pemilik artikel yang dapat melihat.
        |
        */

        if (
            $post->status !== 'approved' &&
            auth()->id() !== $post->user_id
        ) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | LOAD RELASI
        |--------------------------------------------------------------------------
        */

        $post->load([
            'user',
            'comments.user',
            'likes',
        ]);


        /*
        |--------------------------------------------------------------------------
        | VIEW COUNT
        |--------------------------------------------------------------------------
        */

        $post->increment('views');


        return view(
            'blog.show',
            compact('post')
        );
    }


    /**
     * Tampilkan artikel milik user yang sedang login
     */
    public function myPosts()
    {
        $posts = Post::with('user')
            ->where(
                'user_id',
                auth()->id()
            )
            ->latest()
            ->paginate(10);


        return view(
            'blog.my-posts',
            compact('posts')
        );
    }


    /**
     * Tampilkan form edit
     */
    public function edit(Post $post)
    {
        /*
        |--------------------------------------------------------------------------
        | CEK KEPEMILIKAN
        |--------------------------------------------------------------------------
        */

        if (
            auth()->id() !== $post->user_id
        ) {
            abort(403);
        }


        return view(
            'blog.edit',
            compact('post')
        );
    }


    /**
     * Update artikel
     */
    public function update(
        Request $request,
        Post $post
    ) {
        /*
        |--------------------------------------------------------------------------
        | CEK KEPEMILIKAN
        |--------------------------------------------------------------------------
        */

        if (
            auth()->id() !== $post->user_id
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'content' => [
                'required',
                'string',
            ],

            'category' => [
                'required',
                'in:Kesehatan,Sosial,Ekonomi,Teknik',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | DATA UPDATE
        |--------------------------------------------------------------------------
        */

        $data = [
            'title' => $request->title,

            'author' => auth()->user()->name,

            'content' => $request->content,

            'category' => $request->category,
        ];


        /*
        |--------------------------------------------------------------------------
        | UPDATE SLUG JIKA JUDUL BERUBAH
        |--------------------------------------------------------------------------
        */

        if (
            $post->title !== $request->title
        ) {

            $data['slug'] =
                Str::slug($request->title)
                . '-'
                . time();
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE GAMBAR
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            /*
            |--------------------------------------------------------------------------
            | Hapus gambar lama
            |--------------------------------------------------------------------------
            */

            if (
                $post->image &&
                Storage::disk('public')
                    ->exists($post->image)
            ) {

                Storage::disk('public')
                    ->delete($post->image);
            }


            /*
            |--------------------------------------------------------------------------
            | Simpan gambar baru
            |--------------------------------------------------------------------------
            */

            $data['image'] = $request
                ->file('image')
                ->store(
                    'post-images',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE ARTIKEL
        |--------------------------------------------------------------------------
        */

        $post->update($data);


        /*
        |--------------------------------------------------------------------------
        | REFRESH POST
        |--------------------------------------------------------------------------
        */

        $post->refresh();


        return redirect()
            ->route(
                'blog.show',
                $post->slug
            )
            ->with(
                'success',
                'Artikel berhasil diperbarui!'
            );
    }


    /**
     * Hapus artikel
     */
    public function destroy(Post $post)
    {
        /*
        |--------------------------------------------------------------------------
        | CEK KEPEMILIKAN
        |--------------------------------------------------------------------------
        */

        if (
            auth()->id() !== $post->user_id
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS GAMBAR
        |--------------------------------------------------------------------------
        */

        if (
            $post->image &&
            Storage::disk('public')
                ->exists($post->image)
        ) {

            Storage::disk('public')
                ->delete($post->image);
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS ARTIKEL
        |--------------------------------------------------------------------------
        */

        $post->delete();


        return redirect()
            ->route('blog.myPosts')
            ->with(
                'success',
                'Artikel berhasil dihapus!'
            );
    }


    /**
     * Toggle Like (AJAX)
     *
     * Parameter bisa berupa:
     * - ID dari blog/index.blade.php
     * - slug dari blog/show.blade.php
     *
     * Dengan demikian dua kode tetap dapat digunakan bersama.
     */
    public function toggleLike($post)
    {
        /*
        |--------------------------------------------------------------------------
        | CARI BERDASARKAN ID ATAU SLUG
        |--------------------------------------------------------------------------
        */

        $article = Post::where(
                'id',
                $post
            )
            ->orWhere(
                'slug',
                $post
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | USER LOGIN
        |--------------------------------------------------------------------------
        */

        $userId = auth()->id();


        /*
        |--------------------------------------------------------------------------
        | CEK LIKE
        |--------------------------------------------------------------------------
        */

        $existing = $article
            ->likes()
            ->where(
                'user_id',
                $userId
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | TOGGLE
        |--------------------------------------------------------------------------
        */

        if ($existing) {

            $existing->delete();

            $liked = false;

        } else {

            $article
                ->likes()
                ->create([
                    'user_id' => $userId,
                ]);

            $liked = true;
        }


        /*
        |--------------------------------------------------------------------------
        | RESPONSE AJAX
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'liked' => $liked,

            'likes_count' => $article
                ->likes()
                ->count(),
        ]);
    }
}