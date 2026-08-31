@extends('errors.layout')

@section('title', 'Sesi Telah Berakhir')
@section('code', '419')
@section('label', 'Sesi Kedaluwarsa')
@section('heading', 'Sesi Anda telah berakhir')

@section('description')
    Halaman ini mungkin terlalu lama terbuka sehingga token keamanan
    formulir telah kedaluwarsa. Muat ulang halaman atau kembali ke halaman
    sebelumnya untuk melanjutkan.
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

        Muat Ulang
    </button>

    <a
        href="{{ url('/') }}"
        class="error-button error-button-secondary"
    >
        <svg viewBox="0 0 24 24">
            <path d="M3 11l9-8 9 8"/>
            <path d="M5 10v10h14V10"/>
        </svg>

        Kembali ke Beranda
    </a>

@endsection

@section('note')
    Demi keamanan, beberapa formulir Baca Dulu memiliki batas waktu sesi.
@endsection