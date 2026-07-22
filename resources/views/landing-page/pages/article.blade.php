@extends('landing-page.layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Daftar Data & Grafik</h1>

    <div class="row">
        @foreach($dataArticles as $data)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($data->image)
                        <img src="{{ asset('storage/' . $data->image) }}" class="card-img-top" alt="{{ $data->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $data->title }}</h5>
                        <div class="card-text">
                            {!! Str::limit($data->description, 150) !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection