@extends('layouts.app')

@section('content')
<section class="py-20 w-full bg-slate-50">
    <div class="max-w-6xl mx-auto px-6">

        {{-- HEADER SECTION --}}
        <div class="text-center mb-16">
            <span class="inline-block text-orange-600 text-xs font-bold uppercase tracking-widest mb-3">
                Kenali Kami
            </span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4">
                Team Baca<span class="text-orange-600">Dulu</span>
            </h2>
            <div class="w-16 h-1 bg-orange-500 mx-auto rounded-full mb-4"></div>
            <p class="text-slate-500 max-w-xl mx-auto">
                Kumpulan profesional dan akademisi berpengalaman di balik setiap naskah yang kami terbitkan.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            @php
            $data = [
                [
                    'nama' => 'J. Ferdinand H. Pardede, S.Kom., M.M., Mc.E.Dev., MAPPI (Cert.)',
                    'jabatan' => ['Founder Bacadulu', 'FDI Partners', 'Penilai Independen Pasar Modal (OJK)'],
                    'pendidikan' => ['Magister Ekonomika Pembangunan UGM', 'Magister Manajemen (M.M.)', 'Sarjana Komputer (S.Kom.) – Manajemen Informatika'],
                    'img' => 'img/pak Ferdinand.jpg',
                    'scholar' => null,
                ],
                [
                    'nama' => 'Lie Sia Widjaja, S.E., M.M., MAPPI',
                    'jabatan' => ['Partner / Rekan di Kantor Jasa Penilai Publik (KJPP)','Penilai Publik Berizin (Kemenkeu RI)'],
                    'pendidikan' => ['Magister Manajemen (M.M.), Konsentrasi Keuangan', 'Sarjana Ekonomi (S.E.), Jurusan Akuntansi'],
                    'img' => 'img/lie sia.jpg',
                    'scholar' => null,
                ],
                [
                    'nama' => 'Erik Nugraha',
                    'jabatan' => ['Associate Partner – BacaDulu (PT Bina Cendikia Academy)', 'Editor-in-Chief / Editor – BISMA: Business', 'Principal Contact / Editorial Team'],
                    'pendidikan' => ['Sarjana (S1)', 'Magister (S2) ', 'Kandidat Doktor Ilmu Ekonomi (S3) '],
                    'img' => 'img/pak_erik_Nugraha.jpg',
                    'scholar' => null,
                ],
                [
                    'nama' => 'Dr. Audita Setiawan, S.E., M.M',
                    'jabatan' => [
                        'Kepala Biro SDM di (USB) YPKP Bandung',
                        'Associate Partner (Firma / Konsultan)',
                        'Dosen Tetap Fakultas Ekonomi & Bisnis USB YPKP',
                ],
                    'pendidikan' => ['Sarjana Ekonomi (S.E.)', 'Magister Manajemen (M.M.)', ' Doktor (Dr.) Ilmu Ekonomi'],
                    'img' => 'img/audita.jpg',
                    'scholar' => null,
                ],
            ];
            @endphp

            @foreach($data as $item)
            <div class="fade-in-card bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col md:flex-row group">

                {{-- FOTO + BADGE --}}
                <div class="relative w-full md:w-2/5 aspect-square md:aspect-auto overflow-hidden">
                    <img src="{{ asset($item['img']) }}"
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">

                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>

                    @if($item['scholar'])
                    <a href="{{ $item['scholar'] }}" target="_blank"
                       class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm text-slate-900 text-xs font-bold uppercase px-4 py-2 rounded-full hover:bg-white transition">
                        Google Scholar
                    </a>
                    @endif
                </div>

                {{-- TEKS --}}
                <div class="flex-1 p-6 flex flex-col justify-center">
                    <h3 class="text-xl font-bold text-slate-900 mb-1">{{ $item['nama'] }}</h3>

                    @if(!empty($item['jabatan']))
                    <div class="flex flex-wrap gap-2 mb-3">
                        @foreach($item['jabatan'] as $jab)
                        <span class="text-orange-600 text-xs font-semibold uppercase bg-orange-50 border border-orange-200 px-2.5 py-1 rounded-full">
                            {{ $jab }}
                        </span>
                        @endforeach
                    </div>
                    @endif

                    @if(!empty($item['pendidikan']))
                    <p class="text-slate-600 text-sm">
                        <span class="font-semibold text-slate-800">Pendidikan Terakhir:</span> {{ implode(', ', $item['pendidikan']) }}
                    </p>
                    @endif
                </div>

            </div>
            @endforeach

        </div>
    </div>
</section>

@push('scripts')
<style>
    .fade-in-card {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    .fade-in-card.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.fade-in-card');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 100);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        cards.forEach(card => observer.observe(card));
    });
</script>
@endpush
@endsection