@extends('layouts.app')

@section('content')

@php
    use Illuminate\Support\Str;

    $plain = static function ($value, int $limit = 160): string {
        $text = html_entity_decode(
            strip_tags((string) $value),
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );

        $text = preg_replace('/\s+/u', ' ', $text) ?: '';

        return Str::limit(trim($text), $limit);
    };
@endphp

<style>
.bd-search-page{
    --navy:#241B52;
    --orange:#D96A2B;
    --orange-dark:#C94F35;
    --text:#2F3640;
    --muted:#6E737A;
    --line:#E9E2DA;
    --soft:#FFF8F1;
    min-height:70vh;
    background:#fff;
    color:var(--text);
}

.bd-search-shell{
    width:min(calc(100% - 48px),1080px);
    margin:0 auto;
    padding:56px 0 80px;
}

.bd-search-head{
    max-width:760px;
    margin-bottom:28px;
}

.bd-search-kicker{
    margin:0 0 8px;
    color:var(--orange-dark);
    font-size:12px;
    font-weight:800;
    letter-spacing:.08em;
    text-transform:uppercase;
}

.bd-search-title{
    margin:0;
    color:var(--navy);
    font-size:clamp(30px,4vw,46px);
    line-height:1.08;
    font-weight:800;
    letter-spacing:-.03em;
}

.bd-search-subtitle{
    max-width:670px;
    margin:12px 0 0;
    color:var(--muted);
    font-size:15px;
    line-height:1.7;
}

.bd-search-form{
    display:grid;
    grid-template-columns:minmax(0,1fr) auto;
    gap:10px;
    margin-top:26px;
}

.bd-search-input{
    width:100%;
    min-height:50px;
    padding:12px 16px;
    border:1px solid #D8D5DD;
    border-radius:12px;
    background:#fff;
    color:var(--text);
    font:inherit;
    font-size:16px;
    outline:none;
    transition:border-color .2s ease,box-shadow .2s ease;
}

.bd-search-input:focus{
    border-color:var(--orange);
    box-shadow:0 0 0 4px rgba(217,106,43,.12);
}

.bd-search-submit{
    min-height:50px;
    padding:12px 22px;
    border:0;
    border-radius:12px;
    background:var(--navy);
    color:#fff;
    font-size:14px;
    font-weight:800;
    cursor:pointer;
}

.bd-search-summary{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    margin:34px 0 18px;
    padding-bottom:14px;
    border-bottom:1px solid var(--line);
}

.bd-search-summary strong{
    color:var(--navy);
    font-size:15px;
}

.bd-search-summary span{
    color:var(--muted);
    font-size:13px;
}

.bd-search-section{
    margin-top:30px;
}

.bd-search-section-title{
    display:flex;
    align-items:center;
    gap:10px;
    margin:0 0 12px;
    color:var(--navy);
    font-size:17px;
    font-weight:800;
}

.bd-search-section-count{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:25px;
    height:25px;
    padding:0 8px;
    border-radius:999px;
    background:var(--soft);
    color:var(--orange-dark);
    font-size:11px;
    font-weight:800;
}

.bd-search-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:12px;
}

.bd-search-card{
    display:flex;
    flex-direction:column;
    min-width:0;
    padding:18px;
    border:1px solid var(--line);
    border-radius:15px;
    background:#fff;
    text-decoration:none!important;
    transition:transform .2s ease,border-color .2s ease,box-shadow .2s ease;
}

.bd-search-card-type{
    margin-bottom:7px;
    color:var(--orange-dark);
    font-size:10px;
    font-weight:800;
    letter-spacing:.08em;
    text-transform:uppercase;
}

.bd-search-card-title{
    margin:0;
    color:var(--navy);
    font-size:15px;
    line-height:1.45;
    font-weight:800;
}

.bd-search-card-text{
    margin:8px 0 0;
    color:var(--muted);
    font-size:13px;
    line-height:1.65;
}

.bd-search-card-action{
    margin-top:auto;
    padding-top:13px;
    color:var(--orange-dark);
    font-size:12px;
    font-weight:800;
}

.bd-search-empty{
    margin-top:28px;
    padding:24px;
    border:1px solid var(--line);
    border-radius:16px;
    background:#FFFCF8;
}

.bd-search-empty strong{
    display:block;
    color:var(--navy);
    font-size:16px;
}

.bd-search-empty p{
    margin:7px 0 0;
    color:var(--muted);
    font-size:14px;
    line-height:1.65;
}

@media(hover:hover) and (pointer:fine){
    .bd-search-card:hover{
        transform:translateY(-2px);
        border-color:rgba(217,106,43,.28);
        box-shadow:0 12px 28px rgba(36,27,82,.07);
    }

    .bd-search-submit:hover{
        background:#312564;
    }
}

@media(max-width:720px){
    .bd-search-shell{
        width:calc(100% - 30px);
        padding:38px 0 60px;
    }

    .bd-search-form{
        grid-template-columns:1fr;
    }

    .bd-search-submit{
        width:100%;
        min-height:52px;
    }

    .bd-search-grid{
        grid-template-columns:1fr;
    }

    .bd-search-summary{
        align-items:flex-start;
        flex-direction:column;
    }

    .bd-search-card{
        padding:17px;
    }
}

@media(prefers-reduced-motion:reduce){
    .bd-search-card,
    .bd-search-input,
    .bd-search-submit{
        transition:none!important;
    }
}
</style>

<section class="bd-search-page">
    <div class="bd-search-shell">

        <header class="bd-search-head">
            <p class="bd-search-kicker">Pencarian BacaDulu</p>

            <h1 class="bd-search-title">
                Cari konten dengan lebih mudah.
            </h1>

            <p class="bd-search-subtitle">
                Temukan informasi, jurnal, conference, buku, artikel blog,
                event, dan komunitas dalam satu pencarian.
            </p>

            <form
                method="GET"
                action="{{ route('search') }}"
                class="bd-search-form"
                role="search"
            >
                <label for="bdGlobalSearch" class="visually-hidden">
                    Kata kunci pencarian
                </label>

                <input
                    id="bdGlobalSearch"
                    type="search"
                    name="q"
                    value="{{ $query }}"
                    maxlength="100"
                    autocomplete="off"
                    enterkeyhint="search"
                    placeholder="Contoh: jurnal manajemen, buku kesehatan, seminar..."
                    class="bd-search-input"
                >

                <button type="submit" class="bd-search-submit">
                    Cari
                </button>
            </form>

            @error('q')
                <p class="mt-2 text-sm text-red-600" role="alert">
                    {{ $message }}
                </p>
            @enderror
        </header>

        @if($query === '')
            <div class="bd-search-empty">
                <strong>Masukkan kata kunci untuk mulai mencari.</strong>
                <p>
                    Gunakan judul, nama penulis, kategori, ISSN, ISBN,
                    lokasi event, atau kata yang ada di deskripsi.
                </p>
            </div>
        @elseif($totalResults === 0)
            <div class="bd-search-empty" role="status">
                <strong>Tidak ada hasil untuk “{{ $query }}”.</strong>
                <p>
                    Coba gunakan kata yang lebih singkat atau istilah yang berbeda.
                </p>
            </div>
        @else
            <div class="bd-search-summary" aria-live="polite">
                <strong>Hasil untuk “{{ $query }}”</strong>
                <span>{{ $totalResults }} hasil ditampilkan</span>
            </div>

            @if($informations->isNotEmpty())
                <section class="bd-search-section">
                    <h2 class="bd-search-section-title">
                        Informasi
                        <span class="bd-search-section-count">{{ $informations->count() }}</span>
                    </h2>

                    <div class="bd-search-grid">
                        @foreach($informations as $item)
                            <a
                                href="{{ route('informasi.show', $item->slug) }}"
                                class="bd-search-card"
                            >
                                <span class="bd-search-card-type">Baca Informasi</span>
                                <h3 class="bd-search-card-title">{{ $item->title }}</h3>
                                <p class="bd-search-card-text">{{ $plain($item->content) }}</p>
                                <span class="bd-search-card-action">Buka informasi →</span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if($journals->isNotEmpty())
                <section class="bd-search-section">
                    <h2 class="bd-search-section-title">
                        Jurnal
                        <span class="bd-search-section-count">{{ $journals->count() }}</span>
                    </h2>

                    <div class="bd-search-grid">
                        @foreach($journals as $item)
                            @php
                                $journalHref = $item->journal_url ?: route('jurnal');
                                $journalExternal = filled($item->journal_url);
                            @endphp

                            <a
                                href="{{ $journalHref }}"
                                class="bd-search-card"
                                @if($journalExternal)
                                    target="_blank"
                                    rel="noopener noreferrer"
                                @endif
                            >
                                <span class="bd-search-card-type">Baca Jurnal</span>
                                <h3 class="bd-search-card-title">{{ $item->judul }}</h3>
                                <p class="bd-search-card-text">
                                    {{ $plain($item->deskripsi ?: collect([$item->e_issn, $item->p_issn])->filter()->implode(' • ')) }}
                                </p>
                                <span class="bd-search-card-action">
                                    {{ $journalExternal ? 'Kunjungi jurnal ↗' : 'Lihat katalog jurnal →' }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if($conferences->isNotEmpty())
                <section class="bd-search-section">
                    <h2 class="bd-search-section-title">
                        Conference
                        <span class="bd-search-section-count">{{ $conferences->count() }}</span>
                    </h2>

                    <div class="bd-search-grid">
                        @foreach($conferences as $item)
                            @php
                                $conferenceHref = $item->conference_url ?: route('conference');
                                $conferenceExternal = filled($item->conference_url);
                            @endphp

                            <a
                                href="{{ $conferenceHref }}"
                                class="bd-search-card"
                                @if($conferenceExternal)
                                    target="_blank"
                                    rel="noopener noreferrer"
                                @endif
                            >
                                <span class="bd-search-card-type">Baca Conference</span>
                                <h3 class="bd-search-card-title">{{ $item->name }}</h3>
                                <p class="bd-search-card-text">
                                    {{ $plain($item->description ?: $item->edition) }}
                                </p>
                                <span class="bd-search-card-action">
                                    {{ $conferenceExternal ? 'Kunjungi conference ↗' : 'Lihat conference →' }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if($books->isNotEmpty())
                <section class="bd-search-section">
                    <h2 class="bd-search-section-title">
                        Buku
                        <span class="bd-search-section-count">{{ $books->count() }}</span>
                    </h2>

                    <div class="bd-search-grid">
                        @foreach($books as $item)
                            <a
                                href="{{ route('portofolio.bookstore.show', $item->slug) }}"
                                class="bd-search-card"
                            >
                                <span class="bd-search-card-type">Bookstore</span>
                                <h3 class="bd-search-card-title">{{ $item->title }}</h3>
                                <p class="bd-search-card-text">
                                    {{ $plain(collect([$item->author, $item->publisher, $item->category])->filter()->implode(' • ')) }}
                                </p>
                                <span class="bd-search-card-action">Lihat buku →</span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if($posts->isNotEmpty())
                <section class="bd-search-section">
                    <h2 class="bd-search-section-title">
                        Artikel Blog
                        <span class="bd-search-section-count">{{ $posts->count() }}</span>
                    </h2>

                    <div class="bd-search-grid">
                        @foreach($posts as $item)
                            <a
                                href="{{ route('blog.show', $item->slug) }}"
                                class="bd-search-card"
                            >
                                <span class="bd-search-card-type">Blogging</span>
                                <h3 class="bd-search-card-title">{{ $item->title }}</h3>
                                <p class="bd-search-card-text">{{ $plain($item->content) }}</p>
                                <span class="bd-search-card-action">Baca artikel →</span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if($events->isNotEmpty())
                <section class="bd-search-section">
                    <h2 class="bd-search-section-title">
                        Event
                        <span class="bd-search-section-count">{{ $events->count() }}</span>
                    </h2>

                    <div class="bd-search-grid">
                        @foreach($events as $item)
                            <a
                                href="{{ route('event.show', $item->slug) }}"
                                class="bd-search-card"
                            >
                                <span class="bd-search-card-type">Event</span>
                                <h3 class="bd-search-card-title">{{ $item->title }}</h3>
                                <p class="bd-search-card-text">
                                    {{ $plain(collect([$item->category, $item->location])->filter()->implode(' • ')) }}
                                </p>
                                <span class="bd-search-card-action">Lihat event →</span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if($communities->isNotEmpty())
                <section class="bd-search-section">
                    <h2 class="bd-search-section-title">
                        Komunitas
                        <span class="bd-search-section-count">{{ $communities->count() }}</span>
                    </h2>

                    <div class="bd-search-grid">
                        @foreach($communities as $item)
                            <a
                                href="{{ route('community.show', $item) }}"
                                class="bd-search-card"
                            >
                                <span class="bd-search-card-type">Komunitas</span>
                                <h3 class="bd-search-card-title">{{ $item->name }}</h3>
                                <p class="bd-search-card-text">{{ $plain($item->description) }}</p>
                                <span class="bd-search-card-action">Buka komunitas →</span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        @endif

    </div>
</section>

@endsection
