<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
{
    $status = $request->get('status', 'pending');

    $posts = Post::with('user')
        ->when($status !== 'all', fn ($q) => $q->where('status', $status))
        ->latest()
        ->paginate(15);

    return view('admin.posts.index', compact('posts', 'status'));
}

public function approve(Post $post)
{
    $post->update(['status' => 'approved']);
    return back()->with('success', 'Artikel disetujui dan sudah tayang.');
}

public function reject(Post $post)
{
    $post->update(['status' => 'rejected']);
    return back()->with('success', 'Artikel ditolak.');
}

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:Kesehatan,Sosial,Ekonomi,Teknik',
        ]);

        $validated['slug'] = Str::slug($request->title) . '-' . uniqid();
        $validated['user_id'] = auth()->id();

        Post::create($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Artikel berhasil dibuat.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|in:Kesehatan,Sosial,Ekonomi,Teknik',
        ]);

        $post->update($validated);

        return redirect()->route('admin.posts.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Artikel berhasil dihapus.');
    }
}