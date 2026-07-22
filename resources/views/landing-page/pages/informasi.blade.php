@extends('landing-page.layouts.app') {{-- Sesuaikan layout utama web kamu --}}

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Daftar Informasi & Berita</h1>

    <div class="row">
        {{-- Perulangan untuk menampilkan semua data yang diinput admin --}}
        @foreach($informations as $info)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    {{-- Tampilkan gambar yang sudah otomatis jadi .webp --}}
                    @if($info->image)
                        <img src="{{ asset('storage/' . $info->image) }}" class="card-img-top" alt="{{ $info->title }}">
                    @endif
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $info->title }}</h5>
                        
                        {{-- {!! ... !!} agar format RichEditor (bold, italic, dll) ikutan tampil di web --}}
                        <div class="card-text">
                            {!! Str::limit($info->content, 150) !!} 
                        </div>
                        
                        <p class="text-muted small mt-2">Dibuat pada: {{ $info->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection