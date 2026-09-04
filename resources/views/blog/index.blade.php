@extends('layouts.blogging')

@section('blogging-main')

@php
    $activeSort = request('sort', $sort ?? 'terbaru');

    $latestPosts = $posts
        ->getCollection()
        ->sortByDesc('created_at')
        ->take(5);
@endphp

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<div class="mb-5">
    <div class="flex items-center gap-2 mb-2">
        <span class="w-7 h-[3px] rounded-full bg-orange-500"></span>

        <span class="text-[11px] uppercase tracking-[0.16em] font-bold text-orange-600">
            Baca Dulu
        </span>
    </div>

    <h1 class="text-2xl font-extrabold text-slate-900">
        Blogging
    </h1>

    <p class="text-sm text-slate-500 mt-1">
        Baca, tulis, dan bagikan pemikiran bersama komunitas Baca Dulu.
    </p>
</div>

{{-- ========================================================= --}}
{{-- SUCCESS --}}
{{-- ========================================================= --}}

@if(session('success'))
    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif

{{-- ========================================================= --}}
{{-- FILTER --}}
{{-- ========================================================= --}}

<div class="flex items-center gap-2 mb-5 overflow-x-auto pb-1">

    {{-- TERBARU --}}
    <a
        href="{{ route('blog.index', array_merge(
            request()->except(['sort','page']),
            ['sort' => 'terbaru']
        )) }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full border text-sm font-semibold whitespace-nowrap transition
        {{ $activeSort === 'terbaru'
            ? 'border-orange-600 bg-orange-600 text-white'
            : 'border-slate-200 bg-white text-slate-600 hover:border-orange-200 hover:bg-orange-50 hover:text-orange-700'
        }}"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>

        Terbaru
    </a>

    {{-- TERPOPULER --}}
    <a
        href="{{ route('blog.index', array_merge(
            request()->except(['sort','page']),
            ['sort' => 'terpopuler']
        )) }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full border text-sm font-semibold whitespace-nowrap transition
        {{ $activeSort === 'terpopuler'
            ? 'border-orange-600 bg-orange-600 text-white'
            : 'border-slate-200 bg-white text-slate-600 hover:border-orange-200 hover:bg-orange-50 hover:text-orange-700'
        }}"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
        </svg>

        Terpopuler
    </a>

    {{-- CATEGORY AKTIF --}}
    @if(!empty($category))
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-orange-100 bg-orange-50 text-orange-700 text-sm font-semibold whitespace-nowrap">
            <span>{{ $category }}</span>

            <a
                href="{{ route('blog.index', request()->except(['category','page'])) }}"
                title="Hapus kategori"
                class="inline-flex items-center justify-center w-4 h-4 text-orange-400 hover:text-orange-700 transition"
            >
                ×
            </a>
        </div>
    @endif

</div>

{{-- ========================================================= --}}
{{-- POST LIST --}}
{{-- ========================================================= --}}

<div class="space-y-4">

    @forelse($posts as $post)

        <article class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 hover:border-orange-200 hover:shadow-md transition">

            {{-- AUTHOR --}}
            <div class="flex items-center gap-3 mb-4">

    <x-user-avatar
        :user="$post->user"
        :size="36"
        class="border border-slate-200"
    />

    <div class="min-w-0">

        <p class="text-sm font-bold text-slate-800 truncate">
            {{ $post->user->name
                ?? $post->author
                ?? 'Penulis'
            }}
        </p>

        <p class="text-xs text-slate-400 mt-0.5">
            {{ $post
                ->created_at
                ->copy()
                ->timezone('Asia/Jakarta')
                ->translatedFormat('d F Y')
            }}
        </p>

    </div>

</div>
            {{-- CATEGORY --}}
            @if($post->category)
                <div class="mb-3">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-orange-50 border border-orange-100 text-orange-700 text-xs font-semibold">
                        {{ $post->category }}
                    </span>
                </div>
            @endif

            {{-- TITLE --}}
            <a href="{{ route('blog.show',$post->slug) }}" class="group block">
                <h2 class="text-lg md:text-xl font-bold text-slate-900 leading-snug break-words group-hover:text-orange-700 transition">
                    {{ $post->title }}
                </h2>
            </a>

            {{-- EXCERPT --}}
            <p class="text-sm text-slate-600 leading-relaxed mt-2 line-clamp-3 break-words">
                {{ \Illuminate\Support\Str::limit(
                    html_entity_decode(
                        strip_tags($post->content)
                    ),
                    220
                ) }}
            </p>

            {{-- IMAGE --}}
            @if($post->image)
                <a
                    href="{{ route('blog.show',$post->slug) }}"
                    class="block mt-4 overflow-hidden rounded-xl bg-slate-100"
                >
                    <img
                        src="{{ asset('storage/'.$post->image) }}"
                        alt="{{ $post->title }}"
                        class="w-full max-h-[360px] object-cover"
                    >
                </a>
            @endif

            {{-- ACTION BAR --}}
            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center gap-5 text-sm text-slate-500">

                {{-- LIKE --}}
                @auth
                    @php
                        $liked = $post->isLikedBy(auth()->id());
                    @endphp

                    <button
                        type="button"
                        id="like-btn-{{ $post->id }}"
                        onclick='toggleLike(@json($post->slug), {{ $post->id }})'
                        class="inline-flex items-center gap-1.5 hover:text-orange-600 transition
                        {{ $liked ? 'text-orange-600' : '' }}"
                    >
                        <svg
                            id="like-icon-{{ $post->id }}"
                            class="w-5 h-5"
                            fill="{{ $liked ? 'currentColor' : 'none' }}"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                            />
                        </svg>

                        <span id="like-count-{{ $post->id }}">
                            {{ $post->likes()->count() }}
                        </span>
                    </button>

                @else

                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center gap-1.5 hover:text-orange-600 transition"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                            />
                        </svg>

                        <span>{{ $post->likes()->count() }}</span>
                    </a>

                @endauth

                {{-- COMMENT --}}
                <a
                    href="{{ route('blog.show',$post->slug) }}#comments"
                    class="inline-flex items-center gap-1.5 hover:text-orange-600 transition"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                        />
                    </svg>

                    <span>{{ $post->comments->count() }}</span>
                </a>

                {{-- SHARE --}}
                <button
                    type="button"
                    onclick='sharePost(
                        @json($post->title),
                        @json(route("blog.show",$post->slug))
                    )'
                    class="inline-flex items-center gap-1.5 hover:text-orange-600 transition"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8.684 13.342a3 3 0 100 2.316m0-2.316l6.632-3.684m-6.632 6l6.632 3.684m0-10.316a3 3 0 106 0 3 3 0 00-6 0zm0 12a3 3 0 106 0 3 3 0 00-6 0z"
                        />
                    </svg>

                    <span class="hidden sm:inline">
                        Bagikan
                    </span>
                </button>

                {{-- VIEWS --}}
                <div class="ml-auto inline-flex items-center gap-1.5 text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
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

                    <span>{{ $post->views ?? 0 }}</span>
                </div>

            </div>

        </article>

    @empty

        <div class="bg-white rounded-xl border border-slate-200 px-6 py-16 text-center">

            <div class="w-12 h-12 rounded-xl bg-orange-50 border border-orange-100 text-orange-600 flex items-center justify-center mx-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M19 14V6a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2h7m5-6l-5 5m0 0v-4m0 4h4"
                    />
                </svg>
            </div>

            <h3 class="mt-4 font-semibold text-slate-800">
                Belum ada artikel
            </h3>

            <p class="text-sm text-slate-400 mt-1">
                Artikel yang tersedia akan tampil di halaman ini.
            </p>

        </div>

    @endforelse

</div>

{{-- ========================================================= --}}
{{-- PAGINATION --}}
{{-- ========================================================= --}}

@if($posts->hasPages())
    <div class="mt-6">
        {{ $posts
            ->appends(request()->query())
            ->links()
        }}
    </div>
@endif

@endsection

{{-- ========================================================= --}}
{{-- SIDEBAR KANAN --}}
{{-- ========================================================= --}}

@section('blogging-right')

{{-- ========================================================= --}}
{{-- ARTIKEL TERBARU --}}
{{-- ========================================================= --}}

<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">

    <div class="flex items-center gap-2 mb-4">
        <span class="w-1 h-5 rounded-full bg-orange-500"></span>

        <h3 class="text-base font-bold text-slate-900">
            Artikel Terbaru
        </h3>
    </div>

    <div class="space-y-4">

        @forelse($latestPosts as $latestPost)

            <a
                href="{{ route('blog.show',$latestPost->slug) }}"
                class="flex gap-3 group min-w-0"
            >
                <span class="w-6 shrink-0 text-lg font-extrabold text-slate-200 group-hover:text-orange-300 transition">
                    {{ $loop->iteration }}
                </span>

                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-800 leading-snug line-clamp-2 group-hover:text-orange-700 transition">
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

            <p class="text-sm text-slate-400">
                Belum ada artikel terbaru.
            </p>

        @endforelse

    </div>

</div>

{{-- ========================================================= --}}
{{-- BACA DULU --}}
{{-- ========================================================= --}}

<div class="bg-[#2b2f3a] rounded-xl p-5">

    <div class="text-[10px] uppercase tracking-[0.18em] font-bold text-orange-400">
        Baca Dulu
    </div>

    <h4 class="text-base font-bold text-white mt-2">
        Baca. Tulis. Bagikan.
    </h4>

    <p class="text-xs text-slate-300 leading-relaxed mt-2">
        Ruang untuk membagikan gagasan, pengalaman, dan informasi yang layak dibaca.
    </p>

</div>

{{-- ========================================================= --}}
{{-- LOGIN / TULIS ARTIKEL --}}
{{-- ========================================================= --}}

@guest

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">

        <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 3a5 5 0 110 10 5 5 0 010-10zm-8 18a8 8 0 0116 0"
                />
            </svg>
        </div>

        <h4 class="text-sm font-bold text-slate-900">
            Punya sesuatu untuk ditulis?
        </h4>

        <p class="text-xs text-slate-500 leading-relaxed mt-2">
            Masuk ke akun Baca Dulu untuk menulis artikel dan bergabung dalam percakapan.
        </p>

        <a
            href="{{ route('login') }}"
            class="mt-4 w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-orange-200 text-orange-700 hover:bg-orange-50 hover:border-orange-300 text-sm font-semibold transition"
        >
            Masuk

            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M5 12h14m-6-6l6 6-6 6"
                />
            </svg>
        </a>

    </div>

@else

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">

        <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 19.5V5a2 2 0 012-2h8.5L20 8.5V19a2 2 0 01-2 2H6a2 2 0 01-2-1.5z"
                />
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M14 3v6h6M8 13h8M8 17h5"
                />
            </svg>
        </div>

        <h4 class="text-sm font-bold text-slate-900">
            Punya ide untuk dibagikan?
        </h4>

        <p class="text-xs text-slate-500 leading-relaxed mt-2">
            Tulis artikel dan bagikan gagasan Anda bersama komunitas Baca Dulu.
        </p>

        <a
            href="{{ route('blog.create') }}"
            class="mt-4 w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold transition"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 4v16m8-8H4"
                />
            </svg>

            Tulis Artikel
        </a>

        <a
            href="{{ route('blog.myPosts') }}"
            class="mt-2 w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:text-slate-900 text-sm font-semibold transition"
        >
            Artikel Saya
        </a>

    </div>

@endguest

@endsection

{{-- ========================================================= --}}
{{-- SCRIPT --}}
{{-- ========================================================= --}}

@push('scripts')

<script>
function toggleLike(slug,postId){
    fetch(`/blog/${slug}/like`,{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}',
            'Accept':'application/json',
            'X-Requested-With':'XMLHttpRequest'
        }
    })
    .then(response=>{
        if(!response.ok){
            throw new Error('Gagal memproses like.');
        }

        return response.json();
    })
    .then(data=>{
        const count=document.getElementById(`like-count-${postId}`);
        const button=document.getElementById(`like-btn-${postId}`);
        const icon=document.getElementById(`like-icon-${postId}`);

        if(count){
            count.textContent=data.likes_count;
        }

        if(button){
            button.classList.toggle('text-orange-600',data.liked);
        }

        if(icon){
            icon.setAttribute(
                'fill',
                data.liked ? 'currentColor' : 'none'
            );
        }
    })
    .catch(error=>{
        console.error(error);
    });
}

function sharePost(title,url){
    if(navigator.share){
        navigator.share({
            title:title,
            url:url
        });

        return;
    }

    if(navigator.clipboard){
        navigator.clipboard.writeText(url).then(()=>{
            alert('Link artikel berhasil disalin.');
        });

        return;
    }

    window.prompt(
        'Salin link artikel:',
        url
    );
}
</script>

@endpush