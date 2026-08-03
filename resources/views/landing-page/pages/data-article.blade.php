@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center text-center mb-5 animate__animated animate__fadeInDown">
        <div class="col-md-8">
            <span class="bg-primary/15 text-primary px-3 py-1 rounded-pill text-xs font-bold uppercase tracking-wider">Arsip</span>
            <h1 class="fw-bold display-5 mt-3 text-dark">Data Artikel</h1>
            <p class="text-muted lead">Kumpulan artikel dan publikasi pilihan.</p>
        </div>
    </div>

    <div class="row g-4">
        @foreach($dataArticles as $article)
            <div class="col-md-4 animate__animated animate__fadeInUp">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 transition-hover">
                    @if($article->image)
                        <div style="height: 200px; overflow: hidden;">
                            <img src="{{ asset('storage/' . $article->image) }}"
                                 alt="{{ $article->title ?? 'Artikel' }}"
                                 class="w-100 h-100 object-fit-cover">
                        </div>
                    @endif
                    <div class="card-body p-4">
                        <h4 class="fw-bold text-dark mb-2">{{ $article->title ?? 'Artikel' }}</h4>
                        <div class="text-muted small">{!! $article->description ?? '-' !!}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<style>
.transition-hover { transition: transform 0.3s ease; }
.transition-hover:hover { transform: translateY(-5px); }
.object-fit-cover { object-fit: cover; }
.text-muted.small p { margin-bottom: 0.5rem; }
.text-muted.small p:last-child { margin-bottom: 0; }
</style>
@endsection