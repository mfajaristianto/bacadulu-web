@extends('layouts.app')

@section('content')

{{-- ================= TEAM BACADULU ================= --}}
<section id="team-bacadulu" class="scroll-mt-20 relative py-24 w-full overflow-hidden bg-gradient-to-b from-white to-orange-50/40">

    <div class="absolute top-0 -left-20 w-72 h-72 bg-orange-300/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 -right-20 w-96 h-96 bg-orange-200/20 rounded-full blur-3xl"></div>

    <div class="relative max-w-6xl mx-auto px-6">

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
            $data = config('team.members');
            @endphp

            @foreach($data as $item)
            <div class="fade-in-card bg-white/70 backdrop-blur-xl rounded-2xl shadow-lg shadow-orange-900/5 border border-white/60 overflow-hidden hover:shadow-2xl hover:shadow-orange-900/10 hover:-translate-y-1 transition-all duration-300 flex flex-col md:flex-row md:h-[210px] group">

                <a href="{{ route('team.show', $item['slug']) }}" class="relative w-full md:w-2/5 aspect-square md:aspect-auto overflow-hidden block bg-orange-100">
                    <img src="{{ asset($item['img']) }}"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div style="display:none" class="absolute inset-0 items-center justify-center bg-orange-100 text-orange-500 text-4xl font-extrabold">
                        {{ collect(explode(' ', $item['nama']))->map(fn($w) => mb_substr($w, 0, 1))->take(2)->implode('') }}
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>

                    @if($item['scholar'])
                    <a href="{{ $item['scholar'] }}" target="_blank" onclick="event.stopPropagation()"
                       class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm text-slate-900 text-xs font-bold uppercase px-4 py-2 rounded-full hover:bg-white transition">
                        Google Scholar
                    </a>
                    @endif
                </a>

                <div class="flex-1 p-6 flex flex-col justify-center overflow-hidden">
                    <a href="{{ route('team.show', $item['slug']) }}">
                        <h3 class="text-xl font-bold text-slate-900 mb-1 hover:text-orange-600 transition-colors line-clamp-3">
                            {{ $item['nama'] }}
                        </h3>
                    </a>

                    @if(!empty($item['pendidikan']))
                    <p class="text-slate-600 text-sm line-clamp-2">
                        <span class="font-semibold text-slate-800">Pendidikan Terakhir:</span> {{ implode(', ', $item['pendidikan']) }}
                    </p>
                    @endif
                </div>

            </div>
            @endforeach

        </div>
    </div>
</section>


{{-- ================= NILAI-NILAI PERUSAHAAN ================= --}}
<section id="nilai-perusahaan" class="scroll-mt-20 relative py-24 w-full bg-slate-50 overflow-hidden">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-orange-100/40 rounded-full blur-3xl -z-10"></div>

    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16">
            <span class="inline-block text-orange-600 text-xs font-bold uppercase tracking-widest mb-3">
                Yang Kami Pegang Teguh
            </span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-3">
                Nilai-Nilai <span class="text-orange-600">Bacadulu</span>
            </h2>
            <div class="w-16 h-1 bg-orange-500 mx-auto rounded-full"></div>
        </div>
        
        @php
        $nilai = [
            ['judul' => 'Objektif Dan Netral', 'desc' => 'Kami menyajikan informasi tanpa bias untuk mendukung keputusan yang lebih baik.', 'icon' => 'M5 13l4 4L19 7'],
            ['judul' => 'Up To Date', 'desc' => 'Informasi dan data yang kami sajikan selalu terkini dan relevan dengan perkembangan terbaru.', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
            ['judul' => 'Valid Dan Akurat', 'desc' => 'Setiap konten melalui proses verifikasi untuk memastikan validitas dan akurasi data.', 'icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 3a4 4 0 10-8 0'],
        ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($nilai as $n)
            <div class="fade-in-card bg-white/60 backdrop-blur-lg rounded-2xl border border-orange-100 p-8 text-center shadow-md shadow-orange-900/5 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="w-14 h-14 mx-auto mb-5 rounded-2xl bg-orange-500/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $n['icon'] }}" />
                    </svg>
                </div>
                <h3 class="font-bold text-slate-900 mb-2">{{ $n['judul'] }}</h3>
                <p class="text-slate-500 text-sm">{{ $n['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ================= VISI & MISI ================= --}}
<section id="visi-misi" class="scroll-mt-20 py-24 bg-white relative overflow-hidden">
    <div class="absolute top-0 -right-32 w-96 h-96 bg-orange-100/50 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-0 -left-32 w-80 h-80 bg-orange-50 rounded-full blur-3xl -z-10"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-5">
                <span class="text-orange-600 text-xs font-bold tracking-widest uppercase">Our Purpose</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Visi & Misi Kami</h2>
                <p class="text-slate-500 text-sm mt-4 leading-relaxed">
                    Kami hadir untuk menjembatani ide-ide cemerlang akademisi dan para penulis hebat dengan pembaca di seluruh penjuru negeri melalui platform literasi modern.
                </p>
                <div class="mt-8 border-l-4 border-orange-500 pl-4 italic text-slate-600 text-sm">
                    "Membaca membuka jendela dunia, menulis membangun jembatan peradaban."
                </div>
            </div>

            <div class="lg:col-span-7 flex flex-col gap-6">
                <div class="bg-white/70 backdrop-blur-xl p-6 rounded-2xl border border-white/60 shadow-lg shadow-orange-900/5 hover:shadow-xl hover:shadow-orange-900/10 hover:-translate-y-0.5 transition-all duration-300">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <span class="text-orange-500 text-xl">🎯</span> Visi Kami
                    </h3>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Menjadi penyedia utama pendidikan dan pelatihan berbasis informasi yang berkualitas, membangun budaya literasi yang kuat untuk mendukung pembelajaran berkelanjutan, serta menjadi pusat referensi unggulan dalam pengembangan literasi dan keahlian melalui pelatihan berbasis data.
                    </p>
                </div>

                <div class="bg-white/70 backdrop-blur-xl p-6 rounded-2xl border border-white/60 shadow-lg shadow-orange-900/5 hover:shadow-xl hover:shadow-orange-900/10 hover:-translate-y-0.5 transition-all duration-300">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <span class="text-orange-500 text-xl">⚡</span> Misi Kami
                    </h3>
                    <ul class="text-xs text-slate-500 mt-2 space-y-2 list-disc list-inside leading-relaxed">
                        <li>Menyediakan informasi yang objektif dan netral.</li>
                        <li>Menyediakan informasi yang up to date atau terkini.</li>
                        <li>Menyediakan informasi yang valid dan akurat.</li>
                        <li>Menyediakan data dan informasi yang dapat digunakan dalam pengambilan keputusan bagi berbagai stakeholder.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

@push('scripts')
<style>
    html {
        scroll-behavior: smooth;
    }

    .fade-in-card {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    .fade-in-card.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .tab-link.active {
        color: #ea580c;
        background-color: #fff7ed;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fade-in animation
        const cards = document.querySelectorAll('.fade-in-card');
        const cardObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 100);
                    cardObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });
        cards.forEach(card => cardObserver.observe(card));

        // Highlight tab aktif sesuai section yang sedang terlihat
        const sections = document.querySelectorAll('section[id]');
        const tabLinks = document.querySelectorAll('.tab-link');

        const tabObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const id = entry.target.getAttribute('id');
                const link = document.querySelector(`.tab-link[href="#${id}"]`);
                if (entry.isIntersecting) {
                    tabLinks.forEach(l => l.classList.remove('active'));
                    if (link) link.classList.add('active');
                }
            });
        }, { threshold: 0.4 });

        sections.forEach(section => tabObserver.observe(section));
    });
</script>
@endpush
@endsection