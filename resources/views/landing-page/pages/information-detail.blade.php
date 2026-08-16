@extends('layouts.app')

@section('content')
<style>
  .cover-3d-wrapper {
    background: linear-gradient(135deg, #FBF9F5 0%, #F1EDE4 100%);
    border: 1px solid #EAE7DF;
    padding: 40px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    box-shadow: 0 20px 40px -15px rgba(27, 36, 83, 0.08);
  }
  .image-3d-box {
    position: relative;
    width: 100%;
    max-width: 320px;
    aspect-ratio: 16/10;
    transform-style: preserve-3d;
    transform: rotateY(-8deg);
    transition: transform 0.4s ease;
  }
  .cover-3d-wrapper:hover .image-3d-box { transform: rotateY(0deg); }
  .info-img {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    box-shadow: 10px 15px 30px rgba(18, 25, 59, 0.25);
    border-radius: 8px;
  }
  .detail-content {
    max-width: 100%;
    overflow-wrap: anywhere;
    word-break: break-word;
    color: #475569;
  }
  .detail-content > * {
    max-width: 100%;
  }
  .detail-content img,
  .detail-content video,
  .detail-content iframe,
  .detail-content table,
  .detail-content pre,
  .detail-content code {
    max-width: 100%;
    height: auto;
    display: block;
  }
  .detail-content table {
    width: 100%;
    display: block;
    overflow-x: auto;
  }
  .detail-content p,
  .detail-content li,
  .detail-content blockquote,
  .detail-content h1,
  .detail-content h2,
  .detail-content h3,
  .detail-content h4,
  .detail-content h5,
  .detail-content h6 {
    max-width: 100%;
    overflow-wrap: anywhere;
    word-break: break-word;
  }
</style>

<div class="max-w-6xl mx-auto px-6 py-14 lg:px-8">
    <div class="mb-8">
        <a href="{{ route('informasi') }}" 
           class="group inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 shadow-[2px_2px_0px_0px_rgba(239,88,67,0.3)] hover:shadow-[4px_4px_0px_0px_rgba(239,88,67,0.3)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-300 ease-out font-bold text-slate-700 hover:text-orange-600">
            <span class="text-lg transition-transform group-hover:translate-x-[-4px] duration-300">←</span>
            <span>KEMBALI KE INFORMASI</span>
        </a>
    </div>

    <div class="grid gap-8 lg:grid-cols-12 items-start">
        <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-8">
            <div class="cover-3d-wrapper rounded-2xl overflow-hidden">
                <div class="image-3d-box">
                    @if($information->image)
                        <div class="info-img" style="background-image:url('{{ asset('storage/' . $information->image) }}');"></div>
                    @else
                        <div class="info-img bg-gradient-to-br from-orange-500 to-purple-600 flex items-center justify-center text-white font-bold p-4 text-center">
                            {{ $information->title }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="border border-slate-200 bg-white p-6 rounded-2xl shadow-sm">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-4 border-b pb-2">Informasi Publikasi</h3>
                <div class="space-y-3 text-xs text-slate-600">
                    <div>
                        <span class="block font-semibold text-slate-400 uppercase text-[10px]">Tanggal Rilis</span>
                        <span class="font-medium text-slate-800 text-sm">{{ $information->created_at->format('d M Y') }}</span>
                    </div>
                    <div>
                        <span class="block font-semibold text-slate-400 uppercase text-[10px]">Kategori</span>
                        <span class="font-medium text-slate-800 text-sm">Berita & Informasi</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white border border-slate-200/80 p-8 rounded-2xl shadow-sm">
                <span class="inline-block bg-orange-50 text-orange-700 text-xs font-bold uppercase px-3 py-1 rounded-full border border-orange-200">Informasi Resmi</span>
                <h1 class="text-3xl lg:text-4xl font-extrabold text-slate-900 mt-3 leading-tight">{{ $information->title }}</h1>
                
                <div class="border-t border-slate-100 my-6"></div>

                <article class="detail-content prose prose-slate text-slate-600 leading-relaxed text-sm lg:text-base space-y-4">
                    {!! $information->content !!}
                </article>
            </div>
        </div>
    </div>
</div>
@endsection
