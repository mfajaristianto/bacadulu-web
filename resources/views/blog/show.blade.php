@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto px-6 py-10">

    {{-- ================================================= --}}
    {{-- TOMBOL KEMBALI --}}
    {{-- ================================================= --}}

    <a
        href="{{ url()->previous() !== url()->current() ? url()->previous() : route('blog.index') }}"
        class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 hover:text-slate-800 transition mb-5 group"
    >
        <svg class="w-4 h-4 transition group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali
    </a>


    {{-- ================================================= --}}
    {{-- ARTIKEL --}}
    {{-- ================================================= --}}

    <article class="bg-white p-6 md:p-8 rounded-2xl border border-gray-100 shadow-sm">

        {{-- KATEGORI --}}
        <span class="inline-block text-xs font-semibold text-orange-700 bg-orange-50 px-3 py-1 rounded-full mb-4">
            {{ $post->category }}
        </span>

        {{-- HEADER: JUDUL + AKSI --}}
        <div class="flex justify-between items-start gap-4">

            <h1 class="text-2xl md:text-3xl font-bold text-slate-900 leading-snug break-words min-w-0">
                {{ $post->title }}
            </h1>

            @auth
                @if(auth()->id() === $post->user_id)

                    <div class="flex items-center gap-2 shrink-0">

                        <a
                            href="{{ route('blog.edit', $post->slug) }}"
                            class="p-2 border border-gray-200 rounded-lg text-slate-500 hover:bg-gray-50 hover:text-slate-800 transition"
                            title="Edit artikel"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>

                        <form action="{{ route('blog.destroy', $post->slug) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?');">
                            @csrf
                            @method('DELETE')
                            <button
                                class="p-2 border border-red-100 rounded-lg text-red-500 bg-red-50 hover:bg-red-100 transition"
                                title="Hapus artikel"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9.5 4h5a1 1 0 011 1v2h-7V5a1 1 0 011-1z" />
                                </svg>
                            </button>
                        </form>

                    </div>

                @endif
            @endauth

        </div>

        {{-- META: PENULIS + TANGGAL --}}
        <div class="flex items-center gap-2.5 mt-4">

            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 text-white flex items-center justify-center text-sm font-bold shrink-0">
                {{ strtoupper(substr($post->user->name ?? $post->author ?? 'A', 0, 1)) }}
            </div>

            <div class="leading-tight min-w-0">
                <p class="text-sm font-bold text-slate-800 truncate">
                    {{ $post->user->name ?? $post->author ?? 'Admin Utama' }}
                </p>
                <p class="text-xs text-slate-400">
                    {{ $post->created_at->translatedFormat('d F Y') }}
                </p>
            </div>

        </div>

        {{-- GAMBAR --}}
        @if($post->image)
            <img
                src="{{ asset('storage/' . $post->image) }}"
                alt="{{ $post->title }}"
                class="w-full max-h-[420px] object-cover rounded-xl border border-gray-100 mt-6"
            >
        @endif

        {{-- ISI ARTIKEL --}}
        <div class="prose prose-slate max-w-none mt-6 text-slate-800 break-words [overflow-wrap:anywhere]">
            {!! $post->content !!}
        </div>

    </article>


    {{-- ================================================= --}}
    {{-- KOMENTAR --}}
    {{-- ================================================= --}}

    <section class="mt-8">

        <h3 class="text-lg font-bold text-slate-800 mb-4">
            Komentar
            <span class="text-slate-400 font-medium">({{ $post->comments->count() }})</span>
        </h3>

        @auth

            <form action="{{ route('post.comment.store', $post->id) }}" method="POST" class="bg-white rounded-xl border border-gray-100 p-4">
                @csrf

                <textarea
                    name="content"
                    rows="3"
                    class="w-full rounded-lg border border-gray-200 p-3 text-sm resize-none focus:ring-2 focus:ring-orange-100 focus:border-orange-400 focus:outline-none break-words"
                    placeholder="Tulis komentar..."
                >{{ old('content') }}</textarea>

                @error('content')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div class="mt-3 flex justify-end">
                    <button class="px-5 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold rounded-lg transition">
                        Kirim Komentar
                    </button>
                </div>

            </form>

        @else

            <div class="bg-white rounded-xl border border-gray-100 p-5 text-center">
                <p class="text-sm text-slate-500">
                    Silakan <a href="{{ route('login') }}" class="text-orange-600 underline font-medium">login</a> untuk memberi komentar.
                </p>
            </div>

        @endauth


        <div class="mt-5 space-y-3">

            @forelse($post->comments as $comment)

                <div class="bg-white p-4 rounded-xl border border-gray-100 flex gap-3">

                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-slate-400 to-slate-600 text-white flex items-center justify-center text-xs font-bold shrink-0">
                        {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                    </div>

                    <div class="min-w-0 flex-1">

                        <div class="flex items-center justify-between gap-2">
                            <span class="text-sm font-semibold text-slate-800 truncate">
                                {{ $comment->user->name ?? 'User' }}
                            </span>
                            <span class="text-xs text-slate-400 shrink-0">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <p class="mt-1 text-sm text-slate-700 break-words [overflow-wrap:anywhere]">
                            {{ $comment->content }}
                        </p>

                    </div>

                </div>

            @empty

                <div class="bg-white rounded-xl border border-gray-100 text-center py-10">
                    <p class="text-gray-400 italic text-sm">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                </div>

            @endforelse

        </div>

    </section>

</div>

@endsection