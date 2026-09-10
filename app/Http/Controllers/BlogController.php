<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class BlogController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | SORT
        |--------------------------------------------------------------------------
        |
        | Tidak ada lagi "top".
        |
        | Default:
        | - terbaru
        |
        | Pilihan:
        | - terbaru
        | - terpopuler
        |
        */

        $sort = $request->get('sort', 'terbaru');

        if (!in_array($sort, ['terbaru', 'terpopuler'])) {
            $sort = 'terbaru';
        }


        /*
        |--------------------------------------------------------------------------
        | CATEGORY
        |--------------------------------------------------------------------------
        */

        $category = $request->get('category');


        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */

        $query = Post::query()
            ->with('user')
            ->withCount([
                'likes',
                'comments',
            ])
            ->where('status', 'approved');

        if (auth()->check()) {
            $query->withExists([
                'likes as is_liked_by_user' => function ($likeQuery) {
                    $likeQuery->where('user_id', auth()->id());
                },
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER CATEGORY
        |--------------------------------------------------------------------------
        */

        if ($category) {
            $query->where('category', $category);
        }


        /*
        |--------------------------------------------------------------------------
        | SORTING
        |--------------------------------------------------------------------------
        */

        if ($sort === 'terpopuler') {

            $query
                ->orderByDesc('views')
                ->orderByDesc('likes_count')
                ->orderByDesc('created_at');

        } else {

            /*
            |--------------------------------------------------------------------------
            | TERBARU
            |--------------------------------------------------------------------------
            |
            | Ini sekarang menjadi default.
            |
            */

            $sort = 'terbaru';

            $query->orderByDesc('created_at');
        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $posts = $query
            ->paginate(10)
            ->withQueryString();


        return view(
            'blog.index',
            compact(
                'posts',
                'sort',
                'category'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('blog.create');
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
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

        $imagePath = null;

        try {
            if ($request->hasFile('image')) {
                $imagePath = $request
                    ->file('image')
                    ->store('post-images', 'public');
            }

            $slug = $this->generateUniqueSlug(
                $validated['title']
            );

            Post::create([
                'user_id' => auth()->id(),
                'author' => auth()->user()->name,
                'title' => trim($validated['title']),
                'slug' => $slug,
                'content' => $validated['content'],
                'image' => $imagePath,
                'category' => $validated['category'],
                'status' => 'pending',
                'views' => 0,
            ]);
        } catch (Throwable $e) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            throw $e;
        }

        return redirect()
            ->route('blog.myPosts')
            ->with(
                'success',
                'Artikel berhasil dikirim dan sedang menunggu persetujuan admin.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(Post $post)
    {
        /*
        |--------------------------------------------------------------------------
        | ARTICLE ACCESS
        |--------------------------------------------------------------------------
        */

        if (
            $post->status !== 'approved'
            &&
            auth()->id() !== $post->user_id
        ) {
            abort(404);
        }


        /*
        |--------------------------------------------------------------------------
        | RELATION
        |--------------------------------------------------------------------------
        */

        $post->load([
            'user',
            'comments' => function ($query) {
                $query
                    ->with('user')
                    ->latest();
            },
        ]);

        $post->loadCount([
            'likes',
            'comments',
        ]);

        $post->setAttribute(
            'is_liked_by_user',
            auth()->check()
                ? $post->likes()
                    ->where('user_id', auth()->id())
                    ->exists()
                : false
        );


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        $post->increment('views');


        return view(
            'blog.show',
            compact('post')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MY POSTS
    |--------------------------------------------------------------------------
    */

    public function myPosts()
    {
        $posts = Post::query()
            ->with('user')
            ->where(
                'user_id',
                auth()->id()
            )
            ->orderByDesc('created_at')
            ->paginate(10);


        return view(
            'blog.my-posts',
            compact('posts')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Post $post)
    {
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


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(
        Request $request,
        Post $post
    ) {
        if (auth()->id() !== $post->user_id) {
            abort(403);
        }

        $validated = $request->validate([
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

        $data = [
            'title' => trim($validated['title']),
            'author' => auth()->user()->name,
            'content' => $validated['content'],
            'category' => $validated['category'],

            // Artikel yang diedit user harus dimoderasi ulang.
            // Tanpa ini artikel approved dapat diubah setelah lolos review.
            'status' => 'pending',
        ];

        if ($post->title !== $validated['title']) {
            $data['slug'] = $this->generateUniqueSlug(
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

                $data['image'] = $newImagePath;
            }

            $post->update($data);
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

        $post->refresh();

        return redirect()
            ->route('blog.show', $post->slug)
            ->with(
                'success',
                'Artikel berhasil diperbarui dan sedang menunggu persetujuan admin kembali.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort(403);
        }

        $imagePath = $post->image;

        $post->delete();

        if ($imagePath) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()
            ->route('blog.myPosts')
            ->with(
                'success',
                'Artikel berhasil dihapus.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | LIKE
    |--------------------------------------------------------------------------
    */

    public function toggleLike(Request $request, Post $post)
    {
        if ($post->status !== 'approved') {
            abort(404);
        }

        $userId = (int) auth()->id();

        if (!$userId) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $rateKey = "blog-like:{$userId}";

        if (RateLimiter::tooManyAttempts($rateKey, 20)) {
            $seconds = max(1, RateLimiter::availableIn($rateKey));

            return response()->json([
                'message' => "Terlalu banyak aktivitas like. Coba lagi dalam {$seconds} detik.",
                'retry_after' => $seconds,
            ], 429);
        }

        RateLimiter::hit($rateKey, 60);

        $result = DB::transaction(function () use ($post, $userId) {
            $lockedPost = Post::query()
                ->whereKey($post->id)
                ->lockForUpdate()
                ->firstOrFail();

            $existing = $lockedPost
                ->likes()
                ->where('user_id', $userId)
                ->first();

            if ($existing) {
                $existing->delete();
                $liked = false;
            } else {
                $lockedPost
                    ->likes()
                    ->create([
                        'user_id' => $userId,
                    ]);

                $liked = true;
            }

            return [
                'liked' => $liked,
                'likes_count' => $lockedPost
                    ->likes()
                    ->count(),
            ];
        });

        return response()->json($result);
    }


    /*
    |--------------------------------------------------------------------------
    | UNIQUE SLUG
    |--------------------------------------------------------------------------
    */

    private function generateUniqueSlug(
        string $title,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($title);


        if (!$baseSlug) {
            $baseSlug = 'artikel';
        }


        $slug = $baseSlug;

        $number = 1;


        while (
            Post::query()
                ->where('slug', $slug)
                ->when(
                    $ignoreId,
                    function ($query) use ($ignoreId) {

                        $query->where(
                            'id',
                            '!=',
                            $ignoreId
                        );
                    }
                )
                ->exists()
        ) {

            $slug =
                $baseSlug .
                '-' .
                $number;


            $number++;
        }


        return $slug;
    }
}