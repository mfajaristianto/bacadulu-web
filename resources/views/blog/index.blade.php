@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">


        {{-- ========================================================= --}}
        {{-- SIDEBAR KIRI --}}
        {{-- ========================================================= --}}

        <aside class="lg:col-span-1 lg:sticky lg:top-24 lg:self-start lg:max-h-[calc(100vh-7rem)] lg:overflow-y-auto">

            <div class="pr-1">

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">

                    <div class="space-y-1">

                        {{-- HOME --}}
                        <a
                            href="{{ route('blog.index') }}"
                            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold transition
                            {{ empty(request('category'))
                                ? 'bg-blue-50 text-blue-700'
                                : 'text-gray-600 hover:bg-gray-50' }}"
                        >
                            <svg
                                class="w-5 h-5 shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                />
                            </svg>

                            <span>
                                Home
                            </span>
                        </a>


                        {{-- EVENT --}}
                        <a
                            href="{{ route('event.index') }}"
                            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50 transition"
                        >
                            <svg
                                class="w-5 h-5 shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v12a2 2 0 002 2z"
                                />
                            </svg>

                            <span>
                                Event
                            </span>
                        </a>


                        {{-- KOMUNITAS --}}
                        <a
                            href="{{ route('community.index') }}"
                            class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold text-gray-600 hover:bg-gray-50 transition"
                        >
                            <svg
                                class="w-5 h-5 shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H2v-2a4 4 0 014-4h3m7-4a4 4 0 11-8 0 4 4 0 018 0z"
                                />
                            </svg>

                            <span>
                                Komunitas
                            </span>
                        </a>

                    </div>


                    <hr class="my-4 border-gray-100">


                    {{-- ================================================= --}}
                    {{-- KATEGORI --}}
                    {{-- ================================================= --}}

                    <div class="px-3 mb-2">

                        <div class="text-xs font-bold uppercase tracking-wider text-gray-400">
                            Kategori
                        </div>

                    </div>


                    <div class="space-y-1">

                        @foreach([
                            'Sosial',
                            'Ekonomi',
                            'Teknik',
                            'Kesehatan'
                        ] as $cat)

                            <a
                                href="{{ route(
                                    'blog.index',
                                    array_merge(
                                        request()->except('page'),
                                        ['category' => $cat]
                                    )
                                ) }}"
                                class="block px-4 py-2.5 rounded-lg text-sm font-medium transition
                                {{ isset($category) && $category === $cat
                                    ? 'bg-blue-50 text-blue-700 font-bold'
                                    : 'text-gray-600 hover:bg-gray-50' }}"
                            >
                                {{ $cat }}
                            </a>

                        @endforeach

                    </div>


                    {{-- HAPUS FILTER --}}
                    @if(!empty($category))

                        <a
                            href="{{ route(
                                'blog.index',
                                request()->except([
                                    'category',
                                    'page'
                                ])
                            ) }}"
                            class="mt-3 flex items-center justify-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-red-600 transition"
                        >
                            <svg
                                class="w-3.5 h-3.5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>

                            Hapus filter kategori
                        </a>

                    @endif


                    {{-- ================================================= --}}
                    {{-- TULIS ARTIKEL --}}
                    {{-- ================================================= --}}

                    @auth

                        <hr class="my-4 border-gray-100">

                        <a
                            href="{{ route('blog.create') }}"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold rounded-lg shadow transition"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 4v16m8-8H4"
                                />
                            </svg>

                            Tulis Artikel
                        </a>

                    @endauth

                </div>

            </div>

        </aside>



        {{-- ========================================================= --}}
        {{-- FEED UTAMA --}}
        {{-- ========================================================= --}}

        <main class="lg:col-span-2 min-w-0">


            {{-- ================================================= --}}
            {{-- SORT --}}
            {{-- ================================================= --}}

            @php

                $activeSort = request(
                    'sort',
                    'top'
                );

            @endphp


            <div class="flex items-center gap-2 mb-5 overflow-x-auto pb-1">


                {{-- TOP --}}
                <a
                    href="{{ route(
                        'blog.index',
                        array_merge(
                            request()->except([
                                'sort',
                                'page'
                            ]),
                            [
                                'sort' => 'top'
                            ]
                        )
                    ) }}"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-full border text-sm font-semibold whitespace-nowrap transition
                    {{ $activeSort === 'top'
                        ? 'border-blue-500 bg-blue-500 text-white'
                        : 'border-gray-200 text-gray-600 hover:bg-gray-50' }}"
                >
                    <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 10l7-7m0 0l7 7m-7-7v18"
                        />
                    </svg>

                    Top
                </a>


                {{-- TERBARU --}}
                <a
                    href="{{ route(
                        'blog.index',
                        array_merge(
                            request()->except([
                                'sort',
                                'page'
                            ]),
                            [
                                'sort' => 'terbaru'
                            ]
                        )
                    ) }}"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-full border text-sm font-semibold whitespace-nowrap transition
                    {{ $activeSort === 'terbaru'
                        ? 'border-blue-500 bg-blue-500 text-white'
                        : 'border-gray-200 text-gray-600 hover:bg-gray-50' }}"
                >
                    <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>

                    Terbaru
                </a>


                {{-- TERPOPULER --}}
                <a
                    href="{{ route(
                        'blog.index',
                        array_merge(
                            request()->except([
                                'sort',
                                'page'
                            ]),
                            [
                                'sort' => 'terpopuler'
                            ]
                        )
                    ) }}"
                    class="flex items-center gap-1.5 px-4 py-2 rounded-full border text-sm font-semibold whitespace-nowrap transition
                    {{ $activeSort === 'terpopuler'
                        ? 'border-blue-500 bg-blue-500 text-white'
                        : 'border-gray-200 text-gray-600 hover:bg-gray-50' }}"
                >
                    <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13 10V3L4 14h7v7l9-11h-7z"
                        />
                    </svg>

                    Terpopuler
                </a>


                {{-- KATEGORI AKTIF --}}
                @if(!empty($category))

                    <span class="px-4 py-2 rounded-full border border-gray-200 bg-gray-50 text-gray-500 text-sm font-medium whitespace-nowrap">

                        Kategori:
                        {{ $category }}

                    </span>

                @endif

            </div>



            {{-- ================================================= --}}
            {{-- ARTICLE LIST --}}
            {{-- ================================================= --}}

            <div class="space-y-4">

                @forelse($posts as $post)


                    @php

                        /*
                        |--------------------------------------------------------------------------
                        | AVATAR
                        |--------------------------------------------------------------------------
                        */

                        $avatarUrl = null;

                        if (
                            $post->user &&
                            $post->user->avatar
                        ) {

                            $avatar = $post
                                ->user
                                ->avatar;

                            $avatarUrl =
                                filter_var(
                                    $avatar,
                                    FILTER_VALIDATE_URL
                                )
                                ? $avatar
                                : asset(
                                    'storage/' . $avatar
                                );
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | LIKE STATUS
                        |--------------------------------------------------------------------------
                        */

                        $isLiked = false;

                        if (
                            auth()->check()
                        ) {

                            $isLiked = $post
                                ->likes
                                ->contains(
                                    'user_id',
                                    auth()->id()
                                );
                        }

                    @endphp


                    <article class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition">


                        {{-- ================================================= --}}
                        {{-- AUTHOR --}}
                        {{-- ================================================= --}}

                        <div class="flex items-center gap-2.5 mb-3 min-w-0">


                            @if($avatarUrl)

                                <img
                                    src="{{ $avatarUrl }}"
                                    alt="{{ $post->user->name }}"
                                    class="w-9 h-9 rounded-full object-cover shrink-0 border border-gray-200"
                                    onerror="
                                        this.style.display='none';
                                        this.nextElementSibling.style.display='flex';
                                    "
                                >


                                <div
                                    class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 text-white items-center justify-center text-sm font-bold shrink-0"
                                    style="display:none;"
                                >
                                    {{ strtoupper(
                                        substr(
                                            $post->user->name
                                                ?? $post->author
                                                ?? 'A',
                                            0,
                                            1
                                        )
                                    ) }}
                                </div>


                            @else

                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 text-white flex items-center justify-center text-sm font-bold shrink-0">

                                    {{ strtoupper(
                                        substr(
                                            $post->user->name
                                                ?? $post->author
                                                ?? 'A',
                                            0,
                                            1
                                        )
                                    ) }}

                                </div>

                            @endif


                            <div class="leading-tight min-w-0">

                                <p class="text-sm font-bold text-slate-900 truncate">

                                    {{ $post->user->name
                                        ?? $post->author
                                        ?? 'Penulis'
                                    }}

                                </p>


                                <p class="text-xs text-slate-400 mt-1">

                                    {{ $post->created_at
                                        ->copy()
                                        ->timezone('Asia/Jakarta')
                                        ->translatedFormat('d F Y')
                                    }}

                                </p>

                            </div>

                        </div>



                        {{-- ================================================= --}}
                        {{-- JUDUL + EXCERPT --}}
                        {{-- ================================================= --}}

                        <a
                            href="{{ route(
                                'blog.show',
                                $post->slug
                            ) }}"
                            class="block group"
                        >

                            <h2 class="text-xl font-bold text-slate-900 group-hover:text-blue-700 transition leading-snug mb-2 break-words">

                                {{ $post->title }}

                            </h2>


                            <p class="text-sm text-slate-600 leading-relaxed line-clamp-3 break-words">

                                {{ \Illuminate\Support\Str::limit(
                                    strip_tags(
                                        $post->content
                                    ),
                                    220
                                ) }}

                            </p>

                        </a>



                        {{-- ================================================= --}}
                        {{-- GAMBAR --}}
                        {{-- ================================================= --}}

                        @if($post->image)

                            <a
                                href="{{ route(
                                    'blog.show',
                                    $post->slug
                                ) }}"
                                class="block mt-4"
                            >

                                <img
                                    src="{{ asset(
                                        'storage/' . $post->image
                                    ) }}"
                                    alt="{{ $post->title }}"
                                    class="w-full h-64 object-cover rounded-xl border border-gray-100"
                                >

                            </a>

                        @endif



                        {{-- ================================================= --}}
                        {{-- KATEGORI --}}
                        {{-- ================================================= --}}

                        <div class="mt-4 flex items-center gap-2">

                            <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full">

                                {{ $post->category }}

                            </span>

                        </div>



                        {{-- ================================================= --}}
                        {{-- ACTION BAR --}}
                        {{-- ================================================= --}}

                        <div class="mt-4 flex items-center gap-6 pt-4 border-t border-slate-100 text-slate-500 text-sm">


                            {{-- ================================================= --}}
                            {{-- LIKE --}}
                            {{-- ================================================= --}}

                            @auth

                                <button
                                    type="button"
                                    id="like-btn-{{ $post->id }}"
                                    onclick="toggleLike(
                                        '{{ route('blog.like', $post->slug) }}',
                                        {{ $post->id }}
                                    )"
                                    class="flex items-center gap-2 hover:text-orange-500 transition
                                    {{ $isLiked
                                        ? 'text-orange-500'
                                        : ''
                                    }}"
                                >

                                    <svg
                                        id="like-icon-{{ $post->id }}"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        fill="{{ $isLiked
                                            ? 'currentColor'
                                            : 'none'
                                        }}"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                        />

                                    </svg>


                                    <span
                                        id="like-count-{{ $post->id }}"
                                    >
                                        {{ $post->likes_count
                                            ?? $post->likes->count()
                                        }}
                                    </span>

                                </button>


                            @else

                                <a
                                    href="{{ route('login') }}"
                                    class="flex items-center gap-2 hover:text-orange-500 transition"
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                        />

                                    </svg>


                                    <span>
                                        {{ $post->likes_count
                                            ?? $post->likes->count()
                                        }}
                                    </span>

                                </a>

                            @endauth



                            {{-- ================================================= --}}
                            {{-- COMMENT --}}
                            {{-- ================================================= --}}

                            <a
                                href="{{ route(
                                    'blog.show',
                                    $post->slug
                                ) }}#comments"
                                class="flex items-center gap-2 hover:text-orange-500 transition"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                    />

                                </svg>


                                <span>
                                    {{ $post->comments_count
                                        ?? $post->comments->count()
                                    }}
                                </span>

                            </a>



                            {{-- ================================================= --}}
                            {{-- SHARE --}}
                            {{-- ================================================= --}}

                            <button
                                type="button"
                                onclick="sharePost(
                                    @js($post->title),
                                    @js(route('blog.show', $post->slug))
                                )"
                                class="flex items-center gap-2 hover:text-orange-500 transition"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M8.684 13.342a3 3 0 100 2.316m0-2.316a3 3 0 100 2.316m9.632-8.658a3 3 0 11-6 0 3 3 0 016 0zm0 12a3 3 0 11-6 0 3 3 0 016 0zm-9.632-6a3 3 0 10-6 0 3 3 0 006 0z"
                                    />

                                </svg>

                                Share

                            </button>



                            {{-- ================================================= --}}
                            {{-- VIEW --}}
                            {{-- ================================================= --}}

                            <div class="flex items-center gap-2 ml-auto">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    />

                                </svg>


                                <span>
                                    {{ $post->views ?? 0 }}
                                    dilihat
                                </span>

                            </div>

                        </div>

                    </article>


                @empty


                    {{-- ================================================= --}}
                    {{-- EMPTY --}}
                    {{-- ================================================= --}}

                    <div class="bg-white rounded-xl border border-gray-100 text-center py-16">

                        <p class="text-gray-400 italic">

                            @if(!empty($category))

                                Belum ada artikel ditemukan untuk kategori {{ $category }}.

                            @else

                                Belum ada artikel yang tersedia.

                            @endif

                        </p>

                    </div>

                @endforelse

            </div>



            {{-- ================================================= --}}
            {{-- PAGINATION --}}
            {{-- ================================================= --}}

            @if($posts->hasPages())

                <div class="mt-6">

                    {{ $posts
                        ->appends(
                            request()->query()
                        )
                        ->links()
                    }}

                </div>

            @endif

        </main>



        {{-- ========================================================= --}}
        {{-- SIDEBAR KANAN --}}
        {{-- ========================================================= --}}

        <aside class="lg:col-span-1 self-start">

            <div class="sticky top-24 max-h-[calc(100vh-7rem)] overflow-y-auto pr-1">

                <div class="bg-white rounded-xl border border-gray-100 p-5">

                    <h3 class="text-base font-bold text-slate-900 mb-4">
                        Artikel Terbaru
                    </h3>


                    <div class="space-y-4">


                        @forelse(
                            $posts
                                ->getCollection()
                                ->take(5)
                            as $latestPost
                        )


                            <a
                                href="{{ route(
                                    'blog.show',
                                    $latestPost->slug
                                ) }}"
                                class="flex gap-3 group min-w-0"
                            >

                                <span class="text-lg font-extrabold text-slate-200 shrink-0 w-6">

                                    {{ $loop->iteration }}

                                </span>


                                <div class="min-w-0">

                                    <p class="text-sm font-semibold text-slate-800 group-hover:text-blue-700 transition leading-snug line-clamp-2 break-words">

                                        {{ $latestPost->title }}

                                    </p>


                                    <p class="text-xs text-slate-400 mt-1 truncate">

                                        {{ $latestPost->user->name
                                            ?? $latestPost->author
                                            ?? 'Penulis'
                                        }}

                                    </p>

                                </div>

                            </a>


                        @empty

                            <p class="text-sm text-gray-400 italic">
                                Belum ada artikel.
                            </p>

                        @endforelse

                    </div>

                </div>

            </div>

        </aside>

    </div>

</div>



{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

    /*
    |--------------------------------------------------------------------------
    | LIKE
    |--------------------------------------------------------------------------
    */

    function toggleLike(url, postId)
    {
        fetch(url, {

            method: 'POST',

            headers: {

                'X-CSRF-TOKEN': '{{ csrf_token() }}',

                'Accept': 'application/json',

                'Content-Type': 'application/json'
            }

        })
        .then(response => {

            if (!response.ok) {

                throw new Error(
                    'Gagal memproses like.'
                );
            }

            return response.json();
        })
        .then(data => {

            /*
            |--------------------------------------------------------------------------
            | COUNT
            |--------------------------------------------------------------------------
            */

            const countElement =
                document.getElementById(
                    `like-count-${postId}`
                );


            if (countElement) {

                countElement.textContent =
                    data.likes_count;
            }


            /*
            |--------------------------------------------------------------------------
            | BUTTON
            |--------------------------------------------------------------------------
            */

            const button =
                document.getElementById(
                    `like-btn-${postId}`
                );


            const icon =
                document.getElementById(
                    `like-icon-${postId}`
                );


            if (button) {

                if (data.liked) {

                    button.classList.add(
                        'text-orange-500'
                    );

                } else {

                    button.classList.remove(
                        'text-orange-500'
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | ICON
            |--------------------------------------------------------------------------
            */

            if (icon) {

                icon.setAttribute(
                    'fill',
                    data.liked
                        ? 'currentColor'
                        : 'none'
                );
            }

        })
        .catch(error => {

            console.error(error);

            alert(
                'Like gagal diproses. Silakan coba kembali.'
            );

        });
    }


    /*
    |--------------------------------------------------------------------------
    | SHARE
    |--------------------------------------------------------------------------
    */

    function sharePost(title, url)
    {
        if (navigator.share) {

            navigator.share({
                title: title,
                url: url
            });

        } else if (
            navigator.clipboard
        ) {

            navigator
                .clipboard
                .writeText(url)
                .then(() => {

                    alert(
                        'Link berhasil disalin ke clipboard!'
                    );

                });

        } else {

            alert(url);
        }
    }

</script>

@endsection