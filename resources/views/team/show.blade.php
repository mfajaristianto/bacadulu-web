@extends('layouts.app')

@section('content')

<section class="relative w-full overflow-hidden bg-gradient-to-b from-white to-orange-50/40 pb-24">

    {{-- ===== BANNER ATAS ===== --}}
    <div class="relative h-64 md:h-80 w-full overflow-hidden bg-gradient-to-br from-orange-500 via-orange-600 to-orange-700">
        <div class="absolute top-0 -left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 -right-10 w-96 h-96 bg-orange-900/20 rounded-full blur-3xl"></div>
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 24px 24px;"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-orange-700/40 via-transparent to-black/10"></div>
    </div>

    <div class="relative max-w-5xl mx-auto px-6">

        {{-- ===== PROFILE CARD MENGAMBANG ===== --}}
        <div class="fade-in-card relative -mt-24 md:-mt-28 bg-white/80 backdrop-blur-xl rounded-3xl border border-white/60 shadow-2xl shadow-orange-900/10 p-6 md:p-10">
            <div class="flex flex-col md:flex-row items-center md:items-end gap-6 text-center md:text-left">

                <div class="relative flex-shrink-0">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-2xl overflow-hidden border-4 border-white shadow-xl shadow-orange-900/20 ring-1 ring-orange-100">
                        <img src="{{ asset($item['img']) }}" class="w-full h-full object-cover">
                    </div>
                    <span class="absolute -bottom-2 -right-2 w-8 h-8 bg-orange-500 rounded-full border-4 border-white flex items-center justify-center shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                </div>

                <div class="flex-1">
                    <span class="inline-block text-orange-600 text-xs font-bold uppercase tracking-widest mb-2">
                        Team BacaDulu
                    </span>
                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 leading-tight mb-3">
                        {{ $item['nama'] }}
                    </h1>

                </div>

                @if($item['scholar'])
                <a href="{{ $item['scholar'] }}" target="_blank"
                   class="flex-shrink-0 inline-flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold uppercase px-5 py-3.5 rounded-xl transition-all shadow-md shadow-orange-500/20 hover:shadow-lg hover:shadow-orange-500/30 hover:-translate-y-0.5 whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Google Scholar
                </a>
                @endif
            </div>
        </div>

        {{-- ===== KONTEN BAWAH ===== --}}
        <div class="fade-in-card grid grid-cols-1 md:grid-cols-12 gap-6 mt-8">

            {{-- Biografi --}}
            <div class="md:col-span-{{ !empty($item['pendidikan']) ? '7' : '12' }}">
                <div class="h-full bg-white/70 backdrop-blur-xl rounded-2xl border border-white/60 shadow-lg shadow-orange-900/5 p-6 md:p-8 hover:shadow-xl hover:shadow-orange-900/10 transition-all duration-300">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-orange-500/10 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Biografi Singkat</h3>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $item['bio'] }}</p>
                </div>
            </div>

            {{-- Pendidikan --}}
            @if(!empty($item['pendidikan']))
            <div class="md:col-span-5">
                <div class="h-full bg-white/70 backdrop-blur-xl rounded-2xl border border-white/60 shadow-lg shadow-orange-900/5 p-6 md:p-8 hover:shadow-xl hover:shadow-orange-900/10 transition-all duration-300">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-orange-500/10 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Pendidikan</h3>
                    </div>
                    <ul class="space-y-4">
                        @foreach($item['pendidikan'] as $p)
                        <li class="relative pl-5 text-sm text-slate-600 border-l-2 border-orange-200 last:border-transparent pb-1">
                            <span class="absolute -left-[5px] top-1 w-2 h-2 rounded-full bg-orange-500"></span>
                            {{ $p }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>

        {{-- ===== CTA BAWAH ===== --}}
        <div class="fade-in-card text-center mt-12">
            <p class="text-slate-500 text-sm mb-4">Ingin berkenalan dengan anggota tim lainnya?</p>
            <a href="{{ route('tentang.dewan-redaksi') }}"
               class="inline-flex items-center gap-2 bg-white border border-orange-200 text-orange-600 text-sm font-bold px-6 py-3 rounded-full hover:bg-orange-50 hover:gap-3 transition-all shadow-sm">
                Lihat Anggota Tim Lainnya
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

    </div>
</section>

@push('scripts')
<style>
    .fade-in-card {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInCard 0.7s ease-out forwards;
    }
    .fade-in-card:nth-of-type(2) { animation-delay: 0.15s; }
    .fade-in-card:nth-of-type(3) { animation-delay: 0.3s; }
    @keyframes fadeInCard {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@endsection