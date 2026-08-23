<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            ->with([
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


        /*
        |--------------------------------------------------------------------------
        | IMAGE
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
        | SLUG
        |--------------------------------------------------------------------------
        */

        $slug = $this->generateUniqueSlug(
            $validated['title']
        );


        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        Post::create([
            'user_id' => auth()->id(),

            'author' => auth()
                ->user()
                ->name,

            'title' => $validated['title'],

            'slug' => $slug,

            'content' => $validated['content'],

            'image' => $imagePath,

            'category' => $validated['category'],

            'status' => 'pending',

            'views' => 0,
        ]);


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
            'comments.user',
            'likes',
        ]);


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
        if (
            auth()->id() !== $post->user_id
        ) {
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


        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $data = [
            'title' => $validated['title'],

            'author' => auth()
                ->user()
                ->name,

            'content' => $validated['content'],

            'category' => $validated['category'],
        ];


        /*
        |--------------------------------------------------------------------------
        | SLUG
        |--------------------------------------------------------------------------
        */

        if (
            $post->title !==
            $validated['title']
        ) {

            $data['slug'] =
                $this->generateUniqueSlug(
                    $validated['title'],
                    $post->id
                );
        }


        /*
        |--------------------------------------------------------------------------
        | IMAGE
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            if (
                $post->image
                &&
                Storage::disk('public')
                    ->exists($post->image)
            ) {

                Storage::disk('public')
                    ->delete($post->image);
            }


            $data['image'] = $request
                ->file('image')
                ->store(
                    'post-images',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $post->update($data);

        $post->refresh();


        return redirect()
            ->route(
                'blog.show',
                $post->slug
            )
            ->with(
                'success',
                'Artikel berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(Post $post)
    {
        if (
            auth()->id() !== $post->user_id
        ) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | DELETE IMAGE
        |--------------------------------------------------------------------------
        */

        if (
            $post->image
            &&
            Storage::disk('public')
                ->exists($post->image)
        ) {

            Storage::disk('public')
                ->delete($post->image);
        }


        /*
        |--------------------------------------------------------------------------
        | DELETE POST
        |--------------------------------------------------------------------------
        */

        $post->delete();


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

    public function toggleLike($post)
    {
        /*
        |--------------------------------------------------------------------------
        | FIND POST
        |--------------------------------------------------------------------------
        |
        | Bisa menggunakan ID maupun slug.
        |
        */

        $article = Post::query()
            ->where('id', $post)
            ->orWhere('slug', $post)
            ->firstOrFail();


        $userId = auth()->id();


        /*
        |--------------------------------------------------------------------------
        | AUTH
        |--------------------------------------------------------------------------
        */

        if (!$userId) {

            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }


        /*
        |--------------------------------------------------------------------------
        | EXISTING LIKE
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


        return response()->json([
            'liked' => $liked,

            'likes_count' => $article
                ->likes()
                ->count(),
        ]);
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