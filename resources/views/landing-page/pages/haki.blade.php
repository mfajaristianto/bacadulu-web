@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-24">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h1 class="text-4xl font-extrabold text-slate-900 capitalize">Daftar {{ str_replace('-', ' ', $jenis) }}</h1>
        <p class="text-slate-500 mt-2">Menampilkan database kepemilikan sertifikat HAKI resmi kategori {{ $jenis }}.</p>
        <div class="mt-8 bg-white p-8 rounded-3xl border border-slate-200 shadow-sm text-slate-400">
            Belum ada data HAKI terdaftar untuk kategori ini.
        </div>
    </div>
</div>
@endsection