@extends('layouts.app')

@section('title', 'Kontak - Baca Dulu')

@section('content')
<section class="bg-[#FFFCF8] py-16 sm:py-20">
    <div class="mx-auto max-w-6xl px-5 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <span class="text-xs font-bold uppercase tracking-[0.18em] text-[#C94F35]">
                Hubungi Kami
            </span>

            <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-[#241B52] sm:text-4xl">
                Kontak Baca Dulu
            </h1>

            <p class="mt-4 text-sm leading-7 text-[#6E737A] sm:text-base">
                Hubungi tim Baca Dulu untuk konsultasi penerbitan, informasi layanan,
                maupun kebutuhan kerja sama.
            </p>
        </div>

        <div class="mt-10 grid gap-5 md:grid-cols-3">
            <article class="rounded-2xl border border-[#E8D6C8] bg-white p-6 shadow-sm">
                <h2 class="text-sm font-bold text-[#241B52]">WhatsApp</h2>
                <p class="mt-2 text-sm leading-6 text-[#6E737A]">
                    {{ config('bacadulu.call_center') }}
                </p>
                <a
                    href="https://wa.me/{{ config('bacadulu.call_center_wa') }}?text={{ rawurlencode('Halo BacaDulu, saya ingin menanyakan layanan yang tersedia.') }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="mt-5 inline-flex min-h-12 items-center justify-center rounded-xl bg-[#C94F35] px-5 text-sm font-bold text-white transition hover:bg-[#A94332] focus:outline-none focus:ring-2 focus:ring-[#241B52] focus:ring-offset-2"
                >
                    Hubungi via WhatsApp
                </a>
            </article>

            <article class="rounded-2xl border border-[#E8D6C8] bg-white p-6 shadow-sm">
                <h2 class="text-sm font-bold text-[#241B52]">Email</h2>
                <p class="mt-2 break-all text-sm leading-6 text-[#6E737A]">
                    admnbacadulu.net@gmail.com
                </p>
                <a
                    href="mailto:admnbacadulu.net@gmail.com"
                    class="mt-5 inline-flex min-h-12 items-center justify-center rounded-xl border border-[#C94F35] px-5 text-sm font-bold text-[#A94332] transition hover:bg-[#FFF8F1] focus:outline-none focus:ring-2 focus:ring-[#241B52] focus:ring-offset-2"
                >
                    Kirim Email
                </a>
            </article>

            <article class="rounded-2xl border border-[#E8D6C8] bg-white p-6 shadow-sm">
                <h2 class="text-sm font-bold text-[#241B52]">Lokasi Kantor</h2>
                <p class="mt-2 text-sm leading-6 text-[#6E737A]">
                    The Manhattan Square, Jl. TB Simatupang, Lt 12,
                    Cilandak Timur, Pasar Minggu, Jakarta Selatan.
                </p>
                <a
                    href="#main-footer"
                    class="mt-5 inline-flex min-h-12 items-center justify-center rounded-xl border border-[#241B52] px-5 text-sm font-bold text-[#241B52] transition hover:bg-[#FFF8F1] focus:outline-none focus:ring-2 focus:ring-[#C94F35] focus:ring-offset-2"
                >
                    Lihat Peta di Footer
                </a>
            </article>
        </div>
    </div>
</section>
@endsection
