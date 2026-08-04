@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Dashboard Admin</h1>
            <p class="text-slate-600">Kelola konten website Anda dari sini.</p>
        </div>
        <a href="{{ route('admin.logout') }}" class="rounded bg-slate-800 px-4 py-2 text-white">Logout</a>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold">Informasi</h2>
            <p class="text-sm text-slate-600">Jumlah data informasi: {{ $stats['informations'] }}</p>
            <a href="{{ route('admin.informations.index') }}" class="mt-4 inline-block text-orange-600 font-semibold">Kelola Informasi</a>
        </div>
        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold">Jurnal</h2>
            <p class="text-sm text-slate-600">Jumlah data jurnal: {{ $stats['journals'] }}</p>
            <a href="{{ route('admin.journals.index') }}" class="mt-4 inline-block text-orange-600 font-semibold">Kelola Jurnal</a>
        </div>
        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold">Konten Lain</h2>
            <p class="text-sm text-slate-600">Konferensi, publisher, dan data artikel.</p>
            <div class="mt-3 flex flex-wrap gap-2 text-sm">
                <a href="{{ route('admin.conferences.index') }}" class="text-orange-600 font-semibold">Konferensi</a>
                <a href="{{ route('admin.publishers.index') }}" class="text-orange-600 font-semibold">Publisher</a>
                <a href="{{ route('admin.data-articles.index') }}" class="text-orange-600 font-semibold">Artikel Data</a>
            </div>
        </div>
    </div>
</div>
@endsection
