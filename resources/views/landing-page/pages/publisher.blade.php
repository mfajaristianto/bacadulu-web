@extends('landing-page.layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Daftar Publisher & Buku</h1>

    <div class="row">
        @foreach($publishers as $pub)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($pub->logo_or_cover)
                        <img src="{{ asset('storage/' . $pub->logo_or_cover) }}" class="card-img-top" alt="{{ $pub->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $pub->name }}</h5>
                        <div class="card-text">
                            {!! Str::limit($pub->about, 150) !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection