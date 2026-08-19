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
        $query = Post::with('user')
            ->where('status', 'approved');

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $posts = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $category = $request->category;

        return view('blog.index', compact(
            'posts',
            'category'
        ));
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
                ->store('post-images', 'public');
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
                . '-' . time(),

            'content' => $request->content,

            'image' => $imagePath,

            'category' => $request->category,

            'status' => 'pending',
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
    public function show($slug)
    {
        $post = Post::with('user')
            ->where('slug', $slug)
            ->firstOrFail();

        // Artikel pending hanya bisa dilihat penulisnya
        if (
            $post->status !== 'approved' &&
            auth()->id() !== $post->user_id
        ) {
            abort(404);
        }

        return view('blog.show', compact('post'));
    }

    /**
     * Tampilkan artikel milik user yang sedang login
     */
    public function myPosts()
    {
        $posts = Post::with('user')
            ->where('user_id', auth()->id())
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
    public function edit($slug)
    {
        $post = Post::with('user')
            ->where('slug', $slug)
            ->firstOrFail();

        if (auth()->id() !== $post->user_id) {
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
        $slug
    ) {
        $post = Post::where(
            'slug',
            $slug
        )->firstOrFail();

        if (auth()->id() !== $post->user_id) {
            abort(403);
        }

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
        | UPDATE GAMBAR JIKA ADA GAMBAR BARU
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            // Hapus gambar lama
            if (
                $post->image &&
                Storage::disk('public')->exists(
                    $post->image
                )
            ) {
                Storage::disk('public')->delete(
                    $post->image
                );
            }

            // Simpan gambar baru
            $data['image'] = $request
                ->file('image')
                ->store(
                    'post-images',
                    'public'
                );
        }

        $post->update($data);

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
    public function destroy($slug)
    {
        $post = Post::where(
            'slug',
            $slug
        )->firstOrFail();

        if (auth()->id() !== $post->user_id) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS GAMBAR
        |--------------------------------------------------------------------------
        */

        if (
            $post->image &&
            Storage::disk('public')->exists(
                $post->image
            )
        ) {
            Storage::disk('public')->delete(
                $post->image
            );
        }

        $post->delete();

        return redirect()
            ->route('blog.myPosts')
            ->with(
                'success',
                'Artikel berhasil dihapus!'
            );
    }
}