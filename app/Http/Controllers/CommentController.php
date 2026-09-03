<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => ['required','string','max:2000'],
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => trim($validated['content']),
        ]);

        $comment->load('user');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dikirim.',
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'user_id' => $comment->user_id,
                    'user_name' => $comment->user->name ?? 'User',
                    'initial' => strtoupper(
                        mb_substr(
                            $comment->user->name ?? 'U',
                            0,
                            1
                        )
                    ),
                    'time' => 'baru saja',
                    'is_post_author' => $comment->user_id === $post->user_id,
                ],
                'comments_count' => $post->comments()->count(),
            ]);
        }

        return redirect()
            ->route('blog.show', $post->slug)
            ->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function update(Request $request, Comment $comment)
    {
        if (auth()->id() !== $comment->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'content' => ['required','string','max:2000'],
        ]);

        $comment->update([
            'content' => trim($validated['content']),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil diperbarui.',
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                ],
            ]);
        }

        return back()->with('success', 'Komentar berhasil diperbarui.');
    }

    public function destroy(Request $request, Comment $comment)
    {
        if (auth()->id() !== $comment->user_id) {
            abort(403);
        }

        $postId = $comment->post_id;

        $comment->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dihapus.',
                'comments_count' => Comment::where('post_id', $postId)->count(),
            ]);
        }

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}