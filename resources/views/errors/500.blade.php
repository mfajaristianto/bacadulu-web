@extends('errors.layout')

@section('title', 'Terjadi Kendala Sistem')
@section('code', '500')
@section('label', 'Kendala Sistem')
@section('heading', 'Ada kendala pada sistem Baca Dulu')

@section('description')
    Permintaan Anda belum dapat diproses karena terjadi kendala internal.
    Tim Baca Dulu dapat melakukan pemeriksaan tanpa menampilkan informasi
    teknis kepada pengunjung.
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

        Kembali ke Beranda
    </a>

@endsection

@section('note')
    Jangan mengirim formulir atau pembayaran berulang kali jika proses sebelumnya belum terkonfirmasi.
@endsection