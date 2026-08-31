@extends('errors.layout')

@section('title', 'Akses Tidak Diizinkan')
@section('code', '403')
@section('label', 'Akses Dibatasi')
@section('heading', 'Anda tidak memiliki akses ke halaman ini')

@section('description')
    Halaman atau tindakan yang Anda coba akses membutuhkan izin khusus.
    Pastikan Anda masuk menggunakan akun yang memiliki hak akses yang sesuai.
@endsection

@section('actions')

    <a
        href="{{ url('/') }}"
        class="error-button error-button-primary"
    >
        <svg viewBox="0 0 24 24">
            <path d="M3 11l9-8 9 8"/>
            <path d="M5 10v10h14V10"/>
            <path d="M9 20v-6h6v6"/>
        </svg>

        Kembali ke Beranda
    </a>

    <a
        href="{{ url()->previous() }}"
        class="error-button error-button-secondary"
    >
        <svg viewBox="0 0 24 24">
            <path d="M19 12H5"/>
            <path d="M10 7l-5 5 5 5"/>
        </svg>

        Kembali
    </a>

@endsection

@section('note')
    Jika Anda merasa seharusnya memiliki akses, silakan hubungi administrator Baca Dulu.
@endsection