@extends('errors.layout')

@section('title', 'Sedang Dalam Pemeliharaan')
@section('code', '503')
@section('label', 'Maintenance')
@section('heading', 'Baca Dulu sedang dalam pemeliharaan')

@section('description')
    Kami sedang melakukan pemeliharaan atau peningkatan sistem
    agar layanan Baca Dulu tetap aman, stabil, dan nyaman digunakan.
    Silakan kembali beberapa saat lagi.
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

        Periksa Kembali
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
    Terima kasih atas kesabaran Anda selama proses pemeliharaan berlangsung.
@endsection