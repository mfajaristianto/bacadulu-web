@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Dashboard -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Dashboard Admin</h1>
            <p class="text-slate-600">Kelola konten website Anda dari sini.</p>
        </div>
    </div>

    <!-- Grid Menu Admin -->
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <!-- Menu Bookstore -->
        <div class="rounded-xl border bg-white p-6 shadow-sm hover:shadow-md transition">
            <h2 class="text-lg font-semibold text-slate-900">Bookstore</h2>
            <p class="text-sm text-slate-600 mt-1">Kelola katalog dan buku.</p>
            <a href="{{ route('admin.books.index') }}" class="mt-4 inline-block text-orange-600 font-semibold hover:text-orange-700">Kelola Buku &rarr;</a>
        </div>

        <!-- Menu Informasi -->
        <div class="rounded-xl border bg-white p-6 shadow-sm hover:shadow-md transition">
            <h2 class="text-lg font-semibold text-slate-900">Informasi</h2>
            <p class="text-sm text-slate-600 mt-1">Jumlah data: {{ $stats['informations'] }}</p>
            <a href="{{ route('admin.informations.index') }}" class="mt-4 inline-block text-orange-600 font-semibold hover:text-orange-700">Kelola Informasi &rarr;</a>
        </div>

        <!-- Menu Jurnal -->
        <div class="rounded-xl border bg-white p-6 shadow-sm hover:shadow-md transition">
            <h2 class="text-lg font-semibold text-slate-900">Jurnal</h2>
            <p class="text-sm text-slate-600 mt-1">Jumlah data: {{ $stats['journals'] }}</p>
            <a href="{{ route('admin.journals.index') }}" class="mt-4 inline-block text-orange-600 font-semibold hover:text-orange-700">Kelola Jurnal &rarr;</a>
        </div>

        <!-- Menu Event -->
        <div class="rounded-xl border bg-white p-6 shadow-sm hover:shadow-md transition">
            <h2 class="text-lg font-semibold text-slate-900">Event</h2>
            <p class="text-sm text-slate-600 mt-1">Kelola event yang tampil di halaman publik.</p>
            <a href="{{ route('admin.events.index') }}" class="mt-4 inline-block text-orange-600 font-semibold hover:text-orange-700">Kelola Event &rarr;</a>
        </div>

        <!-- Menu Artikel/Posts -->
        <div class="rounded-xl border bg-white p-6 shadow-sm hover:shadow-md transition">
            <h2 class="text-lg font-semibold text-slate-900">Artikel</h2>
            <p class="text-sm text-slate-600 mt-1">Kelola artikel blog dari semua user.</p>
            <a href="{{ route('admin.posts.index') }}" class="mt-4 inline-block text-orange-600 font-semibold hover:text-orange-700">Kelola Artikel &rarr;</a>
        </div>

        <!-- Menu Konten Lain -->
        <div class="rounded-xl border bg-white p-6 shadow-sm hover:shadow-md transition">
            <h2 class="text-lg font-semibold text-slate-900">Konten Lain</h2>
            <p class="text-sm text-slate-600 mt-1">Konferensi, publisher.</p>
            <div class="mt-3 flex flex-wrap gap-3 text-sm">
                <a href="{{ route('admin.conferences.index') }}" class="text-orange-600 font-semibold hover:text-orange-700">Konferensi</a>
                <span class="text-slate-300">|</span>
                <a href="{{ route('admin.publishers.index') }}" class="text-orange-600 font-semibold hover:text-orange-700">Publisher</a>
            </div>
        </div>
    </div>
</div>
@endsection