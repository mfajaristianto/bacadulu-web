@extends('layouts.app')

@section('content')

<div class="bg-slate-50 min-h-screen">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- ========================================================= --}}
        {{-- SUCCESS MESSAGE --}}
        {{-- ========================================================= --}}

        @if(session('success'))

            <div
                class="mb-6
                       bg-green-50
                       border border-green-200
                       text-green-700
                       px-4 py-3
                       rounded-xl"
            >
                {{ session('success') }}
            </div>

        @endif


        {{-- ========================================================= --}}
        {{-- MAIN GRID --}}
        {{-- ========================================================= --}}

        <div
            class="grid
                   grid-cols-1
                   lg:grid-cols-[240px_minmax(0,1fr)_280px]
                   gap-6"
        >


            {{-- ===================================================== --}}
            {{-- SIDEBAR KIRI --}}
            {{-- ===================================================== --}}

            <aside class="space-y-5">

                <div
                    class="bg-white
                           rounded-xl
                           border border-slate-200
                           shadow-sm
                           p-4"
                >

                    {{-- HOME --}}

                    <a
                        href="{{ route('blog.index') }}"
                        class="flex items-center gap-3
                               px-3 py-3
                               rounded-lg
                               bg-blue-50
                               text-blue-600
                               font-semibold
                               text-sm"
                    >

                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 12l9-9 9 9M5 10v10h5v-6h4v6h5V10"
                            />
                        </svg>

                        Home

                    </a>


                    {{-- EVENT --}}

                    <a
                        href="{{ route('event.index') }}"
                        class="flex items-center gap-3
                               px-3 py-3
                               rounded-lg
                               text-slate-600
                               hover:bg-slate-50
                               font-medium
                               text-sm
                               transition"
                    >

                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"
                            />
                        </svg>

                        Event

                    </a>


                    {{-- KOMUNITAS --}}

                    <a
                        href="{{ route('community.index') }}"
                        class="flex items-center gap-3
                               px-3 py-3
                               rounded-lg
                               text-slate-600
                               hover:bg-slate-50
                               font-medium
                               text-sm
                               transition"
                    >

                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H2v-2a4 4 0 014-4h3m7-4a4 4 0 11-8 0 4 4 0 018 0z"
                            />
                        </svg>

                        Komunitas

                    </a>


                    {{-- USER MENU --}}

                    @auth

                        <div class="border-t border-slate-100 mt-3 pt-3">

                            <a
                                href="{{ route('blog.myPosts') }}"
                                class="flex items-center gap-3
                                       px-3 py-3
                                       rounded-lg
                                       text-slate-600
                                       hover:bg-slate-50
                                       font-medium
                                       text-sm
                                       transition"
                            >

                                <svg
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6M7 4h7l3 3v13H7V4z"
                                    />
                                </svg>

                                Artikel Saya

                            </a>


                            <a
                                href="{{ route('blog.create') }}"
                                class="flex items-center gap-3
                                       px-3 py-3
                                       rounded-lg
                                       text-orange-600
                                       hover:bg-orange-50
                                       font-semibold
                                       text-sm
                                       transition"
                            >

                                <svg
                                    class="w-5 h-5"
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

                                Buat Artikel

                            </a>

                        </div>

                    @endauth


                    {{-- ================================================= --}}
                    {{-- CATEGORY --}}
                    {{-- ================================================= --}}

                    <div class="border-t border-slate-100 mt-4 pt-5">

                        <p
                            class="text-xs
                                   font-bold
                                   text-slate-400
                                   uppercase
                                   tracking-wider
                                   px-3
                                   mb-2"
                        >
                            Kategori
                        </p>


                        @foreach([
                            'Sosial',
                            'Ekonomi',
                            'Teknik',
                            'Kesehatan'
                        ] as $item)

                            <a
                                href="{{ route('blog.index', ['category' => $item]) }}"
                                class="
                                    block
                                    px-3 py-2.5
                                    rounded-lg
                                    text-sm
                                    font-medium
                                    transition

                                    {{ $category === $item
                                        ? 'bg-orange-50 text-orange-600'
                                        : 'text-slate-600 hover:bg-slate-50'
                                    }}
                                "
                            >
                                {{ $item }}
                            </a>

                        @endforeach


                        @if($category)

                            <a
                                href="{{ route('blog.index') }}"
                                class="block
                                       px-3 py-2.5
                                       mt-1
                                       text-xs
                                       font-semibold
                                       text-slate-400
                                       hover:text-orange-600
                                       transition"
                            >
                                × Hapus Filter
                            </a>

                        @endif

                    </div>

                </div>

            </aside>



            {{-- ===================================================== --}}
            {{-- KONTEN UTAMA --}}
            {{-- ===================================================== --}}

            <main class="min-w-0">


                {{-- HEADER / FILTER --}}

                <div
                    class="flex flex-col
                           sm:flex-row
                           sm:items-center
                           sm:justify-between
                           gap-3
                           mb-5"
                >

                    <div>

                        <h1 class="text-2xl font-bold text-slate-900">

                            @if($category)

                                Artikel {{ $category }}

                            @else

                                Blogging

                            @endif

                        </h1>

                        <p class="text-sm text-slate-500 mt-1">
                            Temukan artikel terbaru dari para penulis Baca Dulu.
                        </p>

                    </div>


                    @auth

                        <a
                            href="{{ route('blog.create') }}"
                            class="inline-flex
                                   items-center
                                   justify-center
                                   gap-2
                                   px-4 py-2.5
                                   bg-orange-500
                                   hover:bg-orange-600
                                   text-white
                                   rounded-lg
                                   text-sm
                                   font-semibold
                                   transition
                                   shadow-sm"
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



                {{-- ================================================= --}}
                {{-- ARTICLES --}}
                {{-- ================================================= --}}

                <div class="space-y-4">

                    @forelse($posts as $post)

                        <article
                            class="bg-white
                                   rounded-xl
                                   border border-slate-200
                                   shadow-sm
                                   p-5
                                   hover:shadow-md
                                   transition"
                        >


                            {{-- AUTHOR --}}

                            <div class="flex items-center gap-3 mb-4">

                                @if($post->user?->avatar)

                                    <img
                                        src="{{ $post->user->avatar }}"
                                        alt="{{ $post->user->name }}"
                                        class="w-10 h-10
                                               rounded-full
                                               object-cover
                                               border border-slate-200"
                                    >

                                @else

                                    <div
                                        class="w-10 h-10
                                               rounded-full
                                               bg-gradient-to-br
                                               from-blue-500
                                               to-blue-700
                                               text-white
                                               flex items-center
                                               justify-center
                                               text-sm
                                               font-bold"
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

                                @endif


                                <div>

                                    <p
                                        class="text-sm
                                               font-bold
                                               text-slate-900"
                                    >
                                        {{ $post->user->name
                                            ?? $post->author
                                            ?? 'Admin Utama'
                                        }}
                                    </p>


                                    <p class="text-xs text-slate-400">

                                        {{ $post->created_at
                                            ->copy()
                                            ->timezone('Asia/Jakarta')
                                            ->translatedFormat('d F Y')
                                        }}

                                    </p>

                                </div>

                            </div>



                            {{-- IMAGE --}}

                            @if($post->image)

                                <a
                                    href="{{ route('blog.show', $post->slug) }}"
                                    class="block mb-4"
                                >

                                    <img
                                        src="{{ asset('storage/' . $post->image) }}"
                                        alt="{{ $post->title }}"
                                        class="w-full
                                               max-h-80
                                               object-cover
                                               rounded-xl
                                               border border-slate-100"
                                    >

                                </a>

                            @endif



                            {{-- TITLE --}}

                            <a
                                href="{{ route('blog.show', $post->slug) }}"
                                class="block"
                            >

                                <h2
                                    class="text-xl
                                           font-bold
                                           text-slate-900
                                           hover:text-orange-600
                                           leading-snug
                                           break-words
                                           transition"
                                >
                                    {{ $post->title }}
                                </h2>

                            </a>



                            {{-- EXCERPT --}}

                            <div
                                class="mt-2
                                       text-sm
                                       leading-relaxed
                                       text-slate-600
                                       break-words
                                       [overflow-wrap:anywhere]"
                            >
                                {{ \Illuminate\Support\Str::limit(
                                    strip_tags($post->content),
                                    180
                                ) }}
                            </div>



                            {{-- BOTTOM --}}

                            <div
                                class="flex items-center
                                       justify-between
                                       gap-3
                                       mt-4"
                            >

                                <span
                                    class="inline-flex
                                           px-3 py-1
                                           bg-blue-50
                                           text-blue-600
                                           text-xs
                                           font-semibold
                                           rounded-full"
                                >
                                    {{ $post->category }}
                                </span>


                                <a
                                    href="{{ route('blog.show', $post->slug) }}"
                                    class="text-sm
                                           font-semibold
                                           text-orange-600
                                           hover:text-orange-700
                                           transition"
                                >
                                    Baca Selengkapnya →
                                </a>

                            </div>

                        </article>


                    @empty

                        <div
                            class="bg-white
                                   rounded-xl
                                   border border-slate-200
                                   py-16
                                   px-6
                                   text-center"
                        >

                            <div
                                class="w-14 h-14
                                       rounded-full
                                       bg-slate-100
                                       text-slate-400
                                       flex items-center
                                       justify-center
                                       mx-auto
                                       mb-4"
                            >

                                <svg
                                    class="w-7 h-7"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.7"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12h6m-6 4h6M7 4h7l3 3v13H7V4z"
                                    />
                                </svg>

                            </div>


                            <h3
                                class="font-semibold
                                       text-slate-700"
                            >
                                Belum ada artikel
                            </h3>


                            <p
                                class="text-sm
                                       text-slate-400
                                       mt-1"
                            >

                                @if($category)

                                    Belum ada artikel pada kategori {{ $category }}.

                                @else

                                    Artikel yang telah disetujui admin akan tampil di sini.

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

                        {{ $posts->withQueryString()->links() }}

                    </div>

                @endif

            </main>



            {{-- ===================================================== --}}
            {{-- SIDEBAR KANAN --}}
            {{-- ===================================================== --}}

            <aside>

                <div
                    class="bg-white
                           rounded-xl
                           border border-slate-200
                           shadow-sm
                           p-5
                           lg:sticky
                           lg:top-24"
                >

                    <h2
                        class="text-lg
                               font-bold
                               text-slate-900
                               mb-5"
                    >
                        Artikel Terbaru
                    </h2>


                    <div class="space-y-4">

                        @forelse($latestPosts as $latestPost)

                            <a
                                href="{{ route('blog.show', $latestPost->slug) }}"
                                class="flex gap-3 group"
                            >

                                <div
                                    class="text-2xl
                                           font-bold
                                           text-slate-200
                                           leading-none
                                           w-6
                                           flex-shrink-0"
                                >
                                    {{ $loop->iteration }}
                                </div>


                                <div class="min-w-0">

                                    <h3
                                        class="text-sm
                                               font-semibold
                                               leading-snug
                                               text-slate-800
                                               group-hover:text-orange-600
                                               transition
                                               break-words"
                                    >
                                        {{ \Illuminate\Support\Str::limit(
                                            $latestPost->title,
                                            55
                                        ) }}
                                    </h3>


                                    <p
                                        class="text-xs
                                               text-slate-400
                                               mt-1
                                               truncate"
                                    >
                                        {{ $latestPost->user->name
                                            ?? $latestPost->author
                                            ?? 'Admin Utama'
                                        }}
                                    </p>

                                </div>

                            </a>

                        @empty

                            <p class="text-sm text-slate-400">
                                Belum ada artikel terbaru.
                            </p>

                        @endforelse

                    </div>

                </div>

            </aside>

        </div>

    </div>

</div>

@endsection