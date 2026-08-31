@extends('errors.layout')

@section('title', 'Terlalu Banyak Permintaan')
@section('code', '429')
@section('label', 'Permintaan Dibatasi')
@section('heading', 'Terlalu banyak permintaan dalam waktu singkat')

@section('description')
    Sistem mendeteksi terlalu banyak permintaan dari perangkat atau
    koneksi Anda. Tunggu beberapa saat sebelum mencoba kembali.
@endsection

@section('actions')

    <button
        type="button"
        class="error-button error-button-primary"
        onclick="window.location.reload()"
    >
        <svg viewBox="0 0 24 24">
            <path d="M20 6v5h-5"/>
            <path d="M18.5 15a7 7 0 10-1-8.5L20 11"/>
        </svg>

        Coba Lagi
    </button>

    <a
        href="{{ url('/') }}"
        class="error-button error-button-secondary"
    >
        <svg viewBox="0 0 24 24">
            <path d="M3 11l9-8 9 8"/>
            <path d="M5 10v10h14V10"/>
        </svg>

        Beranda
    </a>

@endsection

@section('note')
    Pembatasan ini membantu menjaga keamanan dan kestabilan layanan Baca Dulu.
@endsection