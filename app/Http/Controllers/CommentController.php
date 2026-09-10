<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        if ($post->status !== 'approved') {
            abort(404);
        }

        $userId = (int) auth()->id();
        $rateKey = "blog-comment-store:{$userId}";

        if (RateLimiter::tooManyAttempts($rateKey, 6)) {
            return $this->rateLimitedResponse(
                $request,
                $rateKey,
                'Terlalu banyak komentar dikirim dalam waktu singkat.'
            );
        }

        RateLimiter::hit($rateKey, 60);

        $request->merge([
            'content' => trim((string) $request->input('content', '')),
        ]);

        $validated = $request->validate([
            'content' => [
                'required',
                'string',
                'min:2',
                'max:2000',
            ],
        ], [
            'content.required' => 'Komentar tidak boleh kosong.',
            'content.min' => 'Komentar terlalu pendek.',
            'content.max' => 'Komentar maksimal 2000 karakter.',
        ]);

        $content = trim($validated['content']);

        $duplicate = Comment::query()
            ->where('post_id', $post->id)
            ->where('user_id', $userId)
            ->where('body', $content)
            ->where('created_at', '>=', now()->subMinute())
            ->exists();

        if ($duplicate) {
            $message = 'Komentar yang sama baru saja dikirim.';

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                    'errors' => [
                        'content' => [$message],
                    ],
                ], 422);
            }

            return back()
                ->withErrors([
                    'content' => $message,
                ])
                ->withInput();
        }

        $comment = $post->comments()->create([
            'user_id' => $userId,
            'content' => $content,
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
        if ((int) auth()->id() !== (int) $comment->user_id) {
            abort(403);
        }

        $userId = (int) auth()->id();
        $rateKey = "blog-comment-update:{$userId}";

        if (RateLimiter::tooManyAttempts($rateKey, 12)) {
            return $this->rateLimitedResponse(
                $request,
                $rateKey,
                'Terlalu banyak perubahan komentar dalam waktu singkat.'
            );
        }

        RateLimiter::hit($rateKey, 60);

        $request->merge([
            'content' => trim((string) $request->input('content', '')),
        ]);

        $validated = $request->validate([
            'content' => [
                'required',
                'string',
                'min:2',
                'max:2000',
            ],
        ], [
            'content.required' => 'Komentar tidak boleh kosong.',
            'content.min' => 'Komentar terlalu pendek.',
            'content.max' => 'Komentar maksimal 2000 karakter.',
        ]);

        $content = trim($validated['content']);

        if ($content !== $comment->content) {
            $comment->update([
                'content' => $content,
            ]);
        }

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
        if ((int) auth()->id() !== (int) $comment->user_id) {
            abort(403);
        }

        $postId = $comment->post_id;

        $comment->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dihapus.',
                'comments_count' => Comment::query()
                    ->where('post_id', $postId)
                    ->count(),
            ]);
        }

        return back()->with('success', 'Komentar berhasil dihapus.');
    }

    private function rateLimitedResponse(
        Request $request,
        string $key,
        string $message
    ) {
        $seconds = max(1, RateLimiter::availableIn($key));
        $fullMessage = $message . " Coba lagi dalam {$seconds} detik.";

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $fullMessage,
                'retry_after' => $seconds,
            ], 429);
        }

        return back()
            ->withErrors([
                'content' => $fullMessage,
            ])
            ->withInput();
    }
}
