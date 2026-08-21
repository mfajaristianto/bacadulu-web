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

        <aside class="lg:col-span-1 lg:sticky lg:top-24 lg:self-start lg:max-h-[calc(100vh-7rem)] lg:overflow-y-auto">

            <div class="pr-1">

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">

                    {{-- ================================================= --}}
                    {{-- MENU UTAMA --}}
                    {{-- ================================================= --}}

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

                            <span>Home</span>

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

                            <span>Event</span>

                        </a>


                        {{-- Komunitas --}}
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
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2v12a2 2 0 002 2z"
                                />
                            </svg>

                            <span>Komunitas</span>

                        </a>

                        </div>


                    {{-- GARIS --}}
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

                        @foreach(['Sosial', 'Ekonomi', 'Teknik', 'Kesehatan'] as $cat)

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

                    </div>

                    @if(!empty($category))

                        <a
                            href="{{ route('blog.index', request()->except(['category', 'page'])) }}"
                            class="mt-3 flex items-center justify-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-red-600 transition"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Hapus filter kategori
                        </a>

                    @endif

                </div>

                </div>

            </aside>


            {{-- ===================================================== --}}
            {{-- KONTEN UTAMA --}}
            {{-- ===================================================== --}}

        <main class="lg:col-span-2 min-w-0">


            {{-- ================================================= --}}
            {{-- TABS FILTER (Top / Terbaru / Terpopuler) --}}
            {{-- ================================================= --}}

            @php
                $activeSort = request('sort', 'top');
            @endphp

            <div class="flex items-center gap-2 mb-5 overflow-x-auto pb-1">

                {{-- TOP --}}
                <a
                    href="{{ route('blog.index', array_merge(request()->except(['sort', 'page']), ['sort' => 'top'])) }}"
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
                    href="{{ route('blog.index', array_merge(request()->except(['sort', 'page']), ['sort' => 'terbaru'])) }}"
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
                    href="{{ route('blog.index', array_merge(request()->except(['sort', 'page']), ['sort' => 'terpopuler'])) }}"
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

                    <span
                        class="px-4 py-2 rounded-full border border-gray-200 bg-gray-50 text-gray-500 text-sm font-medium whitespace-nowrap"
                    >
                        Kategori: {{ $category }}
                    </span>

                @endif

                        </h1>

                        <p class="text-sm text-slate-500 mt-1">
                            Temukan artikel terbaru dari para penulis Baca Dulu.
                        </p>

                    </div>



            {{-- ================================================= --}}
            {{-- TULIS ARTIKEL --}}
            {{-- ================================================= --}}

            @auth

                <div class="mb-5 flex justify-end">

                    <a
                        href="{{ route('blog.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold rounded-lg shadow transition"
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

                </div>

            @endauth



            {{-- ================================================= --}}
            {{-- LIST ARTIKEL --}}
            {{-- ================================================= --}}

                <div class="space-y-4">

                    @forelse($posts as $post)

                    <article
                        class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition"
                    >


                        {{-- ========================================= --}}
                        {{-- AUTHOR --}}
                        {{-- ========================================= --}}

                        <div class="flex items-center gap-2.5 mb-3 min-w-0">


                            {{-- ================================= --}}
                            {{-- AVATAR USER --}}
                            {{-- ================================= --}}

                            @if($post->user && $post->user->avatar)

                                @php
                                    $avatar = $post->user->avatar;

                                    // Kalau avatar adalah URL lengkap
                                    $avatarUrl = filter_var($avatar, FILTER_VALIDATE_URL)
                                        ? $avatar
                                        : asset('storage/' . $avatar);
                                @endphp

                                <img
                                    src="{{ $avatarUrl }}"
                                    alt="{{ $post->user->name }}"
                                    class="w-9 h-9 rounded-full object-cover shrink-0 border border-gray-200"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                >

                                {{-- FALLBACK JIKA GAMBAR GAGAL --}}
                                <div
                                    class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 text-white items-center justify-center text-sm font-bold shrink-0"
                                    style="display:none;"
                                >
                                    {{ strtoupper(substr($post->user->name ?? 'A', 0, 1)) }}
                                </div>

                            @else

                                {{-- FALLBACK JIKA USER TIDAK PUNYA AVATAR --}}
                                <div
                                    class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 text-white flex items-center justify-center text-sm font-bold shrink-0"
                                >
                                    {{ strtoupper(substr($post->user->name ?? 'A', 0, 1)) }}
                                </div>

                            @endif


                            {{-- ================================= --}}
                            {{-- NAMA PENULIS --}}
                            {{-- ================================= --}}

                            <div class="leading-tight min-w-0">

                                <p class="text-sm font-bold text-slate-900 truncate">

                                    {{ $post->user->name ?? $post->author ?? 'Penulis' }}

                                </p>

                                <p class="text-xs text-slate-400 mt-1">

                                    {{ $post->created_at->translatedFormat('d F Y') }}

                                </p>

                            </div>

                            </div>



                        {{-- ========================================= --}}
                        {{-- JUDUL + EXCERPT --}}
                        {{-- ========================================= --}}

                        <a
                            href="{{ route('blog.show', $post->slug) }}"
                            class="block group"
                        >

                            <h2
                                class="text-xl font-bold text-slate-900 group-hover:text-blue-700 transition leading-snug mb-2 break-words"
                            >
                                {{ $post->title }}
                            </h2>


                            <p
                                class="text-sm text-slate-600 leading-relaxed line-clamp-3 break-words"
                            >
                                {{ Str::limit(strip_tags($post->content), 220) }}
                            </p>

                        </a>



                        {{-- ========================================= --}}
                        {{-- GAMBAR ARTIKEL --}}
                        {{-- ========================================= --}}

                        @if($post->image)

                            <a
                                href="{{ route('blog.show', $post->slug) }}"
                                class="block mt-4"
                            >

                                <img
                                    src="{{ asset('storage/' . $post->image) }}"
                                    alt="{{ $post->title }}"
                                    class="w-full h-64 object-cover rounded-xl border border-gray-100"
                                >

                            </a>

                        @endif



                        {{-- ========================================= --}}
                        {{-- KATEGORI --}}
                        {{-- ========================================= --}}

                        <div class="mt-4 flex items-center gap-2">

                            <span
                                class="text-xs font-semibold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full"
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
                        class="bg-white rounded-xl border border-gray-100 text-center py-16"
                    >

                        <p class="text-gray-400 italic">
                            Belum ada artikel ditemukan untuk kategori ini.
                        </p>

                    </div>

                    @endforelse

                </div>



            {{-- ================================================= --}}
            {{-- PAGINATION --}}
            {{-- ================================================= --}}

            <div class="mt-6">
                {{ $posts->appends(request()->query())->links() }}
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
                    </h3>


                    <div class="space-y-4">

                        @forelse($latestPosts as $latestPost)

                            <a
                                href="{{ route('blog.show', $post->slug) }}"
                                class="flex gap-3 group min-w-0"
                            >

                                <span
                                    class="text-lg font-extrabold text-slate-200 shrink-0 w-6"
                                >
                                    {{ $index + 1 }}
                                </span>


                                <div class="min-w-0">

                                    <p
                                        class="text-sm font-semibold text-slate-800 group-hover:text-blue-700 transition leading-snug line-clamp-2 break-words"
                                    >
                                        {{ $post->title }}
                                    </p>


                                    <p class="text-xs text-slate-400 mt-1 truncate">
                                        {{ $post->user->name ?? $post->author ?? 'Penulis' }}
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

<script>
function toggleLike(postId) {
    fetch(`/blog/${postId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById(`like-count-${postId}`).textContent = data.likes_count;
        const btn = document.getElementById(`like-btn-${postId}`);
        btn.classList.toggle('text-orange-500', data.liked);
    });
}

function sharePost(title, url) {
    if (navigator.share) {
        navigator.share({ title: title, url: url });
    } else {
        navigator.clipboard.writeText(url);
        alert('Link disalin ke clipboard!');
    }
}
</script>

@endsection