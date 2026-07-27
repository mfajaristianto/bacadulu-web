@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-extrabold text-gray-900 mb-8 border-b pb-4">Daftar Jurnal</h1>

    <!-- Wrapper Grid Card dengan Animasi Zoom -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($jurnals as $jurnal)
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden transition-all duration-300 transform hover:-translate-y-2 hover:shadow-xl flex flex-col justify-between">
                
                <!-- BAGIAN FOTO/GAMBAR JURNAL DENGAN EFEK ZOOM -->
                @if(!empty($jurnal->gambar))
                    <div class="h-48 w-full overflow-hidden bg-gray-100 relative group">
                        <img src="{{ asset('storage/' . $jurnal->gambar) }}" alt="{{ $jurnal->judul }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </div>
                @else
                    <div class="h-48 w-full bg-gray-100 flex items-center justify-center text-gray-400 text-sm italic">
                        Tidak ada gambar
                    </div>
                @endif

                <!-- BAGIAN KONTEN TEKS & TOMBOL PDF -->
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">{{ $jurnal->judul }}</h3>
                        <!-- Render HTML deskripsi dari database secara aman -->
                        <div class="text-gray-600 text-sm mb-6 line-clamp-3">
                            {!! $jurnal->deskripsi ?? $jurnal->content ?? '' !!}
                        </div>
                    </div>
                    
                    <div>
                        @if(!empty($jurnal->file_pdf))
                            <a href="{{ asset('storage/' . $jurnal->file_pdf) }}" target="_blank" 
                               class="inline-flex items-center justify-center w-full bg-[#f05a42] hover:bg-[#d94f38] text-white font-bold py-2 px-4 rounded-lg transition duration-200 text-sm !no-underline shadow">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download PDF
                            </a>
                        @else
                            <span class="text-gray-400 text-sm italic">File PDF tidak tersedia</span>
                        @endif
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full text-center py-10 text-gray-500">
                Belum ada jurnal yang tersedia.
            </div>
        @endforelse
    </div>

    <!-- Paginasi -->
    <div class="mt-6">
        {{ method_exists($jurnals, 'links') ? $jurnals->links() : '' }}
    </div>
</div>
@endsection