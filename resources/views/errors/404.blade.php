@extends('errors.layout')

@section('title', 'Halaman Tidak Ditemukan')
@section('code', '404')
@section('label', 'Halaman Tidak Ditemukan')
@section('heading', 'Sepertinya halaman ini tidak ada')

@section('description')
    Halaman atau konten yang Anda cari mungkin telah dipindahkan,
    dihapus, atau alamat yang Anda masukkan tidak tersedia.
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
    Periksa kembali alamat halaman yang Anda buka.
@endsection