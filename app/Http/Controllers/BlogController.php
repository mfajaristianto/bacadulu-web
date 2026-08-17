<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // (Jangan gunakan $this->middleware('auth') di sini pada Laravel versi baru)

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

    public function create()
    {
        return view('blog.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'content' => 'required|string',
        'category' => 'required|in:Kesehatan,Sosial,Ekonomi,Teknik',
    ]);

    Post::create([
        'user_id' => auth()->id(),
        'title' => $request->title,
        'author' => $request->author,
        'slug' => \Str::slug($request->title) . '-' . time(),
        'content' => $request->content,
        'category' => $request->category,
        'status' => 'pending',
    ]);

    return redirect()->route('blog.myPosts')->with('success', 'Artikel berhasil dikirim! Menunggu persetujuan admin.');
}

    public function show($slug)
{
    $post = Post::where('slug', $slug)->firstOrFail();

    // Kalau belum di-approve, hanya penulis sendiri yang boleh lihat
    if ($post->status !== 'approved' && auth()->id() !== $post->user_id) {
        abort(404);
    }

    return view('blog.show', compact('post'));
}

public function myPosts()
{
    $posts = Post::where('user_id', auth()->id())->latest()->paginate(10);
    return view('blog.my-posts', compact('posts'));
}

    public function edit($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        
        if (auth()->id() !== $post->user_id) {
            abort(403);
        }

        return view('blog.edit', compact('post'));
    }

    public function update(Request $request, $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        
        if (auth()->id() !== $post->user_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:Kesehatan,Sosial,Ekonomi,Teknik',
        ]);

        $post->update([
            'title' => $request->title,
            'author' => $request->author,
            'content' => $request->content,
            'category' => $request->category,
        ]);

        return redirect()->route('blog.show', $post->slug)->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        
        if (auth()->id() !== $post->user_id) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('blog.index')->with('success', 'Artikel berhasil dihapus!');
    }
}