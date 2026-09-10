@extends('layouts.app')

@section('title', 'Katalog Baca - Baca Dulu')

@section('content')
<section class="bg-[#FFFCF8] py-16 sm:py-20">
    <div class="mx-auto max-w-6xl px-5 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <span class="text-xs font-bold uppercase tracking-[0.18em] text-[#C94F35]">
                Katalog Baca
            </span>

            <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-[#241B52] sm:text-4xl">
                Jelajahi layanan dan publikasi Baca Dulu
            </h1>

            <p class="mt-4 text-sm leading-7 text-[#6E737A] sm:text-base">
                Pilih kategori yang ingin Anda buka. Setiap kategori memiliki halaman
                publik tersendiri agar informasi lebih mudah ditemukan.
            </p>
        </div>

        @php
            $catalogItems = [
                [
                    'title' => 'Baca Informasi',
                    'description' => 'Informasi, agenda, dan pembaruan terbaru dari Baca Dulu.',
                    'route' => route('informasi'),
                ],
                [
                    'title' => 'Baca Jurnal',
                    'description' => 'Daftar jurnal, ISSN, tautan jurnal, dan edisi terkini.',
                    'route' => route('jurnal'),
                ],
                [
                    'title' => 'Baca Conference',
                    'description' => 'Conference dan proceeding yang tersedia dalam katalog.',
                    'route' => route('conference'),
                ],
                [
                    'title' => 'Baca Publisher',
                    'description' => 'Portofolio buku yang telah diterbitkan.',
                    'route' => route('publisher'),
                ],
                [
                    'title' => 'Baca Konsultasi',
                    'description' => 'Mitra konsultasi profesional sesuai kebutuhan layanan.',
                    'route' => route('konsultasi'),
                ],
            ];
        @endphp

        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($catalogItems as $item)
                <a
                    href="{{ $item['route'] }}"
                    class="group flex min-h-48 flex-col justify-between rounded-2xl border border-[#E8D6C8] bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-[#C94F35] focus:ring-offset-2"
                >
                    <div>
                        <h2 class="text-lg font-extrabold text-[#241B52]">
                            {{ $item['title'] }}
                        </h2>
                        <p class="mt-3 text-sm leading-6 text-[#6E737A]">
                            {{ $item['description'] }}
                        </p>
                    </div>

                    <span class="mt-6 text-sm font-bold text-[#A94332]">
                        Buka katalog →
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
