<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Tampilkan daftar artikel yang sudah disetujui
     */
    public function index(Request $request)
    {
        $query = Post::where('status', 'approved');

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $posts = $query->latest()->paginate(10);
        $category = $request->category;

        return view('blog.index', compact('posts', 'category'));
    }

    /**
     * Tampilkan form buat artikel
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Simpan artikel baru (Penulis otomatis dari user login)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:Kesehatan,Sosial,Ekonomi,Teknik',
        ]);

        Post::create([
            'user_id'  => auth()->id(),
            'author'   => auth()->user()->name, // Otomatis diambil dari akun
            'title'    => $request->title,
            'slug'     => Str::slug($request->title) . '-' . time(),
            'content'  => $request->content,
            'category' => $request->category,
            'status'   => 'pending',
        ]);

        return redirect()->route('blog.myPosts')->with('success', 'Artikel berhasil dikirim! Menunggu persetujuan admin.');
    }

    /**
     * Tampilkan detail artikel
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        // Hanya penulis atau admin yang bisa melihat artikel 'pending'
        if ($post->status !== 'approved' && auth()->id() !== $post->user_id) {
            abort(404);
        }

        return view('blog.show', compact('post'));
    }

    /**
     * Tampilkan artikel milik user yang sedang login
     */
    public function myPosts()
    {
        $posts = Post::where('user_id', auth()->id())->latest()->paginate(10);
        return view('blog.my-posts', compact('posts'));
    }

    /**
     * Tampilkan form edit
     */
    public function edit($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        
        if (auth()->id() !== $post->user_id) {
            abort(403);
        }

        return view('blog.edit', compact('post'));
    }

    /**
     * Update artikel (Nama penulis tetap disinkronkan dengan user login)
     */
    public function update(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        
        if (auth()->id() !== $post->user_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:Kesehatan,Sosial,Ekonomi,Teknik',
        ]);

        $post->update([
            'title'    => $request->title,
            'author'   => auth()->user()->name, // Tetap update sesuai akun login
            'content'  => $request->content,
            'category' => $request->category,
        ]);

        return redirect()->route('blog.show', $post->slug)->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Hapus artikel
     */
    public function destroy($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        
        if (auth()->id() !== $post->user_id) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('blog.myPosts')->with('success', 'Artikel berhasil dihapus!');
    }
}