@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="row justify-content-center text-center mb-5 animate__animated animate__fadeInDown">
        <div class="col-md-8">
            <span class="bg-primary/15 text-primary px-3 py-1 rounded-pill text-xs font-bold uppercase tracking-wider">Pusat Informasi</span>
            <h1 class="fw-bold display-5 mt-3 text-dark">Informasi Terbaru</h1>
            <p class="text-muted lead">Pengumuman dan berita penting seputar layanan.</p>
        </div>
    </div>

    <!-- Grid Kartu Berita (Mirip Gambar 1) -->
    <div class="row g-4 justify-content-center">
        @forelse($informations as $info)
            <div class="col-md-4 animate__animated animate__fadeInUp">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 transition-hover bg-white">
                    
                    <!-- Bagian Gambar di atas kartu -->
                    @if($info->image)
                        <div style="height: 220px; overflow: hidden;" class="position-relative">
                            <img src="{{ asset('storage/' . $info->image) }}" alt="{{ $info->title }}" class="w-100 h-100 object-fit-cover">
                        </div>
                    @endif

                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                          
                            <!-- Judul Berita -->
                            <h4 class="fw-bold text-dark mb-2" style="font-size: 1.25rem; line-height: 1.4;">
                                {{ $info->title }}
                            </h4>

                            <!-- Isi Konten Ringkas (Membersihkan tag HTML dari RichEditor) -->
                            <p class="text-muted small mb-4" style="line-height: 1.6;">
                                {{ Str::limit(strip_tags($info->content), 100) }}
                            </p>
                        </div>

                        <!-- Tombol Baca Selengkapnya (Warna Ungu Cantik ala Gambar 1) -->
                        <div>
                            <a href="#" class="btn w-100 fw-bold py-2 rounded-pill shadow-none transition-btn" style="background-color: #f3e8ff; color: #7e22ce; border: none;">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 bg-white rounded-4 shadow-sm border border-light">
                    <h4 class="text-muted fw-semibold">Belum Ada Informasi</h4>
                    <p class="text-muted small mt-1">Silakan tambahkan data informasi melalui panel admin CMS.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Styling Tambahan untuk Efek Hover & Gambar -->
<style>
    .transition-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }
    .object-fit-cover {
        object-fit: cover;
    }
    .transition-btn:hover {
        background-color: #7e22ce !important;
        color: #ffffff !important;
    }
</style>
@endsection