@extends('layouts.app')

@section('content')

<style>
.bd-my-posts{
    --navy:#241B52;
    --orange:#EF5843;
    --text:#182235;
    --body:#667085;
    --line:#E6E9EE;
    min-height:calc(100vh - 80px);
    padding:56px 24px 80px;
    background:#f8f9fb;
    font-family:Inter,sans-serif;
}
.bd-my-shell{width:min(100%,1100px);margin:auto}
.bd-my-header{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:30px;
    margin-bottom:28px;
}
.bd-my-kicker{
    display:flex;
    align-items:center;
    gap:9px;
    margin-bottom:8px;
    color:var(--orange);
    font-size:10px;
    font-weight:800;
    letter-spacing:.14em;
    text-transform:uppercase;
}
.bd-my-kicker::before{content:"";width:25px;height:2px;background:var(--orange)}
.bd-my-title{
    margin:0;
    color:var(--text);
    font-size:34px;
    line-height:1.1;
    letter-spacing:-.025em;
}
.bd-my-subtitle{
    max-width:550px;
    margin:8px 0 0;
    color:var(--body);
    font-size:13px;
    line-height:1.65;
}
.bd-my-create{
    min-height:44px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    padding:0 17px;
    border-radius:10px;
    background:var(--orange);
    color:#fff;
    font-size:12px;
    font-weight:800;
    text-decoration:none;
    transition:.2s;
}
.bd-my-create:hover{
    background:#dc4936;
    transform:translateY(-1px);
}
.bd-my-summary{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    margin-bottom:13px;
}
.bd-my-total{
    color:#7d8796;
    font-size:11px;
}
.bd-my-total strong{color:#263247}
.bd-my-list{display:grid;gap:11px}

.bd-my-card{
    position:relative;
    display:grid;
    grid-template-columns:minmax(0,1fr) auto;
    gap:25px;
    align-items:center;
    padding:21px 22px 21px 25px;
    overflow:hidden;
    border:1px solid var(--line);
    border-radius:14px;
    background:#fff;
    transition:border-color .2s,box-shadow .2s,transform .2s;
}
.bd-my-card::before{
    content:"";
    position:absolute;
    top:0;
    bottom:0;
    left:0;
    width:4px;
    background:#d8dde5;
}
.bd-my-card.status-approved::before{background:#27ae60}
.bd-my-card.status-pending::before{background:#f2a93b}
.bd-my-card.status-rejected::before{background:#dc5962}
.bd-my-card:hover{
    border-color:#d9dee6;
    box-shadow:0 10px 28px rgba(31,41,55,.055);
    transform:translateY(-1px);
}
.bd-my-main{min-width:0}
.bd-my-topline{
    display:flex;
    align-items:center;
    gap:9px;
    margin-bottom:7px;
}
.bd-my-status{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:5px 8px;
    border-radius:999px;
    font-size:9px;
    font-weight:800;
}
.bd-my-status::before{
    content:"";
    width:6px;
    height:6px;
    border-radius:50%;
    background:currentColor;
}
.bd-my-status.approved{background:#eafaf0;color:#18834b}
.bd-my-status.pending{background:#fff7e8;color:#b66a00}
.bd-my-status.rejected{background:#fff0f1;color:#c8424d}
.bd-my-date{
    color:#a0a8b4;
    font-size:10px;
}
.bd-my-post-title{
    margin:0;
    color:#1d2638;
    font-size:17px;
    font-weight:800;
    line-height:1.35;
    overflow-wrap:anywhere;
}
.bd-my-category{
    margin:6px 0 0;
    color:#748095;
    font-size:11px;
}
.bd-my-description{
    margin:7px 0 0;
    color:#929baa;
    font-size:10px;
}
.bd-my-actions{
    display:flex;
    align-items:center;
    gap:7px;
    flex-shrink:0;
}
.bd-my-action{
    min-height:36px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    padding:0 12px;
    border:1px solid #e1e5eb;
    border-radius:8px;
    background:#fff;
    color:#556175;
    font-size:10px;
    font-weight:800;
    text-decoration:none;
    transition:.2s;
}
.bd-my-action:hover{
    border-color:#ffd2c4;
    background:#fff6f2;
    color:var(--orange);
}
.bd-my-action.primary{
    border-color:var(--navy);
    background:var(--navy);
    color:#fff;
}
.bd-my-action.primary:hover{
    border-color:#171230;
    background:#171230;
    color:#fff;
}

.bd-my-empty{
    padding:65px 25px;
    border:1px solid var(--line);
    border-radius:16px;
    background:#fff;
    text-align:center;
}
.bd-my-empty-icon{
    width:50px;
    height:50px;
    display:grid;
    place-items:center;
    margin:0 auto 15px;
    border-radius:50%;
    background:#fff3ee;
    color:var(--orange);
}
.bd-my-empty h2{
    margin:0;
    color:#263247;
    font-size:17px;
}
.bd-my-empty p{
    max-width:380px;
    margin:7px auto 18px;
    color:#8993a2;
    font-size:11px;
    line-height:1.6;
}
.bd-my-pagination{margin-top:24px}

@media(max-width:700px){
    .bd-my-posts{padding:35px 15px 60px}
    .bd-my-header{display:block}
    .bd-my-create{margin-top:18px}
    .bd-my-card{grid-template-columns:1fr;padding:19px 18px 19px 21px}
    .bd-my-actions{justify-content:flex-start}
}
</style>

<div class="bd-my-posts">
    <div class="bd-my-shell">

        <header class="bd-my-header">
            <div>
                <div class="bd-my-kicker">Blogging</div>

                <h1 class="bd-my-title">Artikel Saya</h1>

                <p class="bd-my-subtitle">
                    Kelola tulisan yang sudah dibuat dan pantau status publikasinya di Baca Dulu.
                </p>
            </div>

            <a href="{{ route('blog.create') }}" class="bd-my-create">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" d="M12 5v14M5 12h14"/>
                </svg>
                Tulis Artikel Baru
            </a>
        </header>

        @if($posts->count())
            <div class="bd-my-summary">
                <div class="bd-my-total">
                    <strong>{{ $posts->total() }}</strong> artikel
                </div>
            </div>
        @endif

        <div class="bd-my-list">

            @forelse($posts as $post)

                @php
                    if($post->status === 'approved'){
                        $statusClass = 'approved';
                        $statusLabel = 'Tayang';
                        $statusDescription = 'Artikel sudah diterbitkan dan dapat dibaca publik.';
                    } elseif($post->status === 'pending'){
                        $statusClass = 'pending';
                        $statusLabel = 'Menunggu Review';
                        $statusDescription = 'Artikel sedang menunggu pemeriksaan sebelum diterbitkan.';
                    } else {
                        $statusClass = 'rejected';
                        $statusLabel = 'Perlu Perbaikan';
                        $statusDescription = 'Artikel belum dapat diterbitkan dan dapat diperbaiki kembali.';
                    }
                @endphp

                <article class="bd-my-card status-{{ $statusClass }}">
                    <div class="bd-my-main">

                        <div class="bd-my-topline">
                            <span class="bd-my-status {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>

                            <time class="bd-my-date">
                                {{ $post->created_at->translatedFormat('d M Y') }}
                            </time>
                        </div>

                        <h2 class="bd-my-post-title">
                            {{ $post->title }}
                        </h2>

                        <p class="bd-my-category">
                            {{ $post->category ?: 'Tanpa kategori' }}
                        </p>

                        <p class="bd-my-description">
                            {{ $statusDescription }}
                        </p>
                    </div>

                    <div class="bd-my-actions">

                        <a href="{{ route('blog.edit', $post->slug) }}" class="bd-my-action">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11.8 15H9v-2.8l8.6-8.6z"/>
                            </svg>

                            {{ $post->status === 'rejected' ? 'Perbaiki' : 'Edit' }}
                        </a>

                        @if($post->status === 'approved')
                            <a href="{{ route('blog.show', $post->slug) }}" class="bd-my-action primary">
                                Lihat Artikel

                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/>
                                </svg>
                            </a>
                        @endif

                    </div>
                </article>

            @empty

                <div class="bd-my-empty">
                    <div class="bd-my-empty-icon">
                        <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                        </svg>
                    </div>

                    <h2>Belum ada artikel</h2>

                    <p>
                        Mulai tulis artikel pertama dan bagikan gagasan Anda bersama komunitas Baca Dulu.
                    </p>

                    <a href="{{ route('blog.create') }}" class="bd-my-create">
                        Tulis Artikel Pertama
                    </a>
                </div>

            @endforelse

        </div>

        @if($posts->hasPages())
            <div class="bd-my-pagination">
                {{ $posts->links() }}
            </div>
        @endif

    </div>
</div>

@endsection