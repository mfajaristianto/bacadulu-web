@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen text-slate-700 overflow-x-hidden font-sans">

    <!-- 1. Hero Section -->
    @include('landing-page.sections.hero')

    <!-- 2. Kalkulator Estimasi Harga -->
    @include('landing-page.sections.kalkulator')

    <!-- 3. Alur Penerbitan Buku -->
    @include('landing-page.sections.alur')

    <!-- 4. Buku Terbaru (Katalog Singkat/Preview) -->
    @include('landing-page.sections.katalog')

    <!-- 5. Partner & Afiliasi -->
    @include('landing-page.sections.afiliasi')

</div>
@endsection