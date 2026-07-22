@extends('landing-page.layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Jadwal Conference & Event</h1>

    <div class="row">
        @foreach($conferences as $conf)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($conf->poster)
                        <img src="{{ asset('storage/' . $conf->poster) }}" class="card-img-top" alt="{{ $conf->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $conf->title }}</h5>
                        <p class="text-primary fw-bold mb-2">Tanggal: {{ $conf->event_date }}</p>
                        <div class="card-text">
                            {!! Str::limit($conf->description, 150) !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection