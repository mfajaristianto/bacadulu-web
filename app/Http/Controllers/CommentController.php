<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Simpan komentar artikel.
     */
    public function store(
        Request $request,
        Post $post
    ) {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        |
        | Form tetap menggunakan nama "content".
        |
        */

        $validated = $request->validate([
            'content' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | SIMPAN KOMENTAR
        |--------------------------------------------------------------------------
        |
        | Database Anda menggunakan kolom "body".
        |
        | Jadi:
        |
        | Form     : content
        | Database : body
        |
        |--------------------------------------------------------------------------
        */

        Comment::create([
            'post_id' => $post->id,

            'user_id' => auth()->id(),

            'body' => $validated['content'],
        ]);


        /*
        |--------------------------------------------------------------------------
        | KEMBALI KE ARTIKEL
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'blog.show',
                $post->slug
            )
            ->with(
                'success',
                'Komentar berhasil ditambahkan.'
            );
    }
}