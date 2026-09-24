@extends('layouts.app')

@section('title', 'Preview ' . $book->title . ' - Baca Publisher')

@section('content')
<style>
.bd-preview-page{
    min-height:100vh;
    background:#f6f7f9;
    padding:32px 0 64px;
    font-family:Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
}
.bd-preview-shell{
    width:min(calc(100% - 40px),1180px);
    margin:0 auto;
}
.bd-preview-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    margin-bottom:18px;
}
.bd-preview-back{
    display:inline-flex;
    align-items:center;
    gap:8px;
    color:#5f6671;
    font-size:12px;
    font-weight:700;
    text-decoration:none;
}
.bd-preview-back:hover{color:#ef5843}
.bd-preview-title-wrap{min-width:0;text-align:right}
.bd-preview-eyebrow{
    color:#ef5843;
    font-size:9px;
    font-weight:800;
    letter-spacing:.13em;
    text-transform:uppercase;
}
.bd-preview-title{
    margin:4px 0 0;
    color:#241b52;
    font-size:18px;
    line-height:1.3;
    font-weight:750;
}
.bd-preview-frame-wrap{
    overflow:hidden;
    border:1px solid #e1e4e8;
    border-radius:18px;
    background:#fff;
    box-shadow:0 18px 45px rgba(36,27,82,.08);
}
.bd-preview-frame{
    display:block;
    width:100%;
    height:calc(100vh - 190px);
    min-height:650px;
    border:0;
    background:#fff;
}
.bd-preview-fallback{
    padding:14px 18px;
    border-top:1px solid #eceef1;
    color:#66707c;
    font-size:11px;
}
.bd-preview-fallback a{color:#ef5843;font-weight:700}
@media(max-width:640px){
    .bd-preview-page{padding-top:20px}
    .bd-preview-shell{width:calc(100% - 24px)}
    .bd-preview-head{align-items:flex-start;flex-direction:column}
    .bd-preview-title-wrap{text-align:left}
    .bd-preview-frame{height:72vh;min-height:520px}
}
</style>

<section class="bd-preview-page">
    <div class="bd-preview-shell">
        <div class="bd-preview-head">
            <a href="{{ route('publisher.books.show', $book->slug) }}" class="bd-preview-back">← Kembali ke detail buku</a>
            <div class="bd-preview-title-wrap">
                <div class="bd-preview-eyebrow">Preview Buku</div>
                <h1 class="bd-preview-title">{{ $book->title }}</h1>
            </div>
        </div>

        <div class="bd-preview-frame-wrap">
            <iframe
                class="bd-preview-frame"
                src="{{ asset('storage/' . $book->preview_pdf) }}#view=FitH"
                title="Preview PDF {{ $book->title }}"
            ></iframe>
            <div class="bd-preview-fallback">
                Jika PDF tidak tampil di browser, <a href="{{ asset('storage/' . $book->preview_pdf) }}" target="_blank" rel="noopener">buka PDF langsung</a>.
            </div>
        </div>
    </div>
</section>
@endsection
