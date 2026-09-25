@extends('layouts.app')

@section('title', ($profileUser->name ?? 'Profil Pengguna') . ' - Baca Dulu')

@section('content')

@php
    $verification = $profileUser->authorVerification;
    $isVerifiedAuthor = $verification?->status === 'approved';

    $initials = collect(
        preg_split('/\s+/', trim($profileUser->name ?? 'User'))
    )
        ->filter()
        ->map(fn($word) => mb_strtoupper(mb_substr($word, 0, 1)))
        ->take(2)
        ->implode('');
@endphp

<style>
.bd-public-profile{
    --bd-navy:#241B52;
    --bd-orange:#EF5843;
    --bd-text:#182235;
    --bd-muted:#667085;
    --bd-line:#E5E9EF;
    min-height:100vh;
    padding:36px 18px 70px;
    background:#f8fafc;
}
.bd-public-profile *{box-sizing:border-box}
.bd-public-shell{width:min(100%,980px);margin:0 auto}
.bd-public-back{
    display:inline-flex;align-items:center;gap:7px;margin-bottom:18px;
    color:#64748b;font-size:13px;font-weight:700;text-decoration:none
}
.bd-public-back:hover{color:var(--bd-orange)}
.bd-profile-card{
    display:grid;grid-template-columns:auto 1fr;gap:22px;padding:28px;
    border:1px solid var(--bd-line);border-radius:22px;background:#fff;
    box-shadow:0 12px 35px rgba(36,27,82,.05)
}
.bd-profile-avatar{
    width:92px;height:92px;display:grid;place-items:center;border-radius:24px;
    background:linear-gradient(135deg,#EF5843,#F7AA35);
    color:#fff;font-size:28px;font-weight:900;overflow:hidden
}
.bd-profile-avatar img{width:100%;height:100%;object-fit:cover}
.bd-profile-name-row{display:flex;align-items:center;flex-wrap:wrap;gap:8px}
.bd-profile-name{margin:0;color:var(--bd-text);font-size:28px;font-weight:900;letter-spacing:-.03em}
.bd-verified-badge{
    display:inline-flex;align-items:center;gap:5px;padding:6px 10px;
    border:1px solid #b9e7cf;border-radius:999px;background:#ecfdf3;
    color:#087443;font-size:10px;font-weight:900;text-transform:uppercase
}
.bd-profile-sub{margin:8px 0 0;color:var(--bd-muted);font-size:13px;line-height:1.7}
.bd-profile-links{display:flex;flex-wrap:wrap;gap:8px;margin-top:13px}
.bd-profile-link{
    display:inline-flex;align-items:center;min-height:32px;padding:0 10px;
    border:1px solid #e5e7eb;border-radius:999px;background:#fff;
    color:#475467;font-size:11px;font-weight:800;text-decoration:none
}
.bd-profile-link:hover{border-color:#ffc8bb;color:var(--bd-orange)}
.bd-profile-stats{
    display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px;
    margin-top:18px
}
.bd-stat{padding:14px;border-radius:14px;background:#f8fafc;border:1px solid #eef1f5}
.bd-stat strong{display:block;color:var(--bd-navy);font-size:23px;font-weight:900}
.bd-stat span{display:block;margin-top:3px;color:#98a2b3;font-size:10px;font-weight:800;text-transform:uppercase}
.bd-profile-note{
    margin-top:18px;padding:13px 15px;border:1px solid #fde2d8;border-radius:14px;
    background:#fff8f5;color:#7c3c30;font-size:12px;line-height:1.7
}
.bd-section{margin-top:28px}
.bd-section-head{display:flex;align-items:end;justify-content:space-between;gap:16px;margin-bottom:14px}
.bd-section-kicker{margin:0 0 4px;color:var(--bd-orange);font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:.13em}
.bd-section-title{margin:0;color:var(--bd-text);font-size:24px;font-weight:900;letter-spacing:-.025em}
.bd-post-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:14px}
.bd-post-card{
    display:flex;flex-direction:column;min-width:0;padding:19px;border:1px solid var(--bd-line);
    border-radius:17px;background:#fff;text-decoration:none;transition:.2s
}
.bd-post-card:hover{transform:translateY(-2px);border-color:#ffcdbf;box-shadow:0 12px 28px rgba(36,27,82,.06)}
.bd-post-cat{color:var(--bd-orange);font-size:9px;font-weight:900;text-transform:uppercase;letter-spacing:.1em}
.bd-post-title{margin:7px 0 0;color:var(--bd-text);font-size:17px;line-height:1.35;font-weight:850}
.bd-post-excerpt{margin:9px 0 0;color:#667085;font-size:12px;line-height:1.65}
.bd-post-meta{display:flex;flex-wrap:wrap;gap:10px;margin-top:auto;padding-top:14px;color:#98a2b3;font-size:10px;font-weight:700}
.bd-empty{
    padding:42px 20px;border:1px dashed #cbd5e1;border-radius:17px;background:#fff;
    color:#64748b;text-align:center;font-size:13px
}
@media(max-width:700px){
    .bd-public-profile{padding:24px 14px 54px}
    .bd-profile-card{grid-template-columns:1fr;padding:22px}
    .bd-profile-avatar{width:76px;height:76px;border-radius:20px;font-size:23px}
    .bd-profile-name{font-size:24px}
    .bd-post-grid{grid-template-columns:1fr}
}
</style>

<div class="bd-public-profile">
    <div class="bd-public-shell">

        <a href="{{ url()->previous() }}" class="bd-public-back">
            ← Kembali
        </a>

        <section class="bd-profile-card">

            <div>
                <div class="bd-profile-avatar">
                    <x-user-avatar
                        :user="$profileUser"
                        :size="92"
                    />
                </div>
            </div>

            <div>
                <div class="bd-profile-name-row">
                    <h1 class="bd-profile-name">
                        {{ $profileUser->name ?? 'Pengguna BacaDulu' }}
                    </h1>

                    @if($isVerifiedAuthor)
                        <span
                            class="bd-verified-badge"
                            title="Identitas kepenulisan telah diverifikasi admin BacaDulu"
                        >
                            ✓ Penulis Terverifikasi
                        </span>
                    @endif
                </div>

                <p class="bd-profile-sub">
                    Profil publik BacaDulu.
                    @if($isVerifiedAuthor && $verification?->institution)
                        Afiliasi: <strong>{{ $verification->institution }}</strong>.
                    @endif
                </p>

                @if($isVerifiedAuthor)
                    <div class="bd-profile-links">
                        @if($verification?->orcid_url)
                            <a
                                href="{{ $verification->orcid_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="bd-profile-link"
                            >
                                ORCID
                            </a>
                        @endif

                        @if($verification?->google_scholar_url)
                            <a
                                href="{{ $verification->google_scholar_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="bd-profile-link"
                            >
                                Google Scholar
                            </a>
                        @endif

                        @if($verification?->publication_url)
                            <a
                                href="{{ $verification->publication_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="bd-profile-link"
                            >
                                Bukti Publikasi
                            </a>
                        @endif
                    </div>
                @endif

                <div class="bd-profile-stats">
                    <div class="bd-stat">
                        <strong>{{ $publishedCount }}</strong>
                        <span>Artikel diterbitkan</span>
                    </div>

                    <div class="bd-stat">
                        <strong>{{ number_format($totalViews, 0, ',', '.') }}</strong>
                        <span>Total dibaca</span>
                    </div>
                </div>

                <div class="bd-profile-note">
                    Profil ini hanya menampilkan metadata dan ringkasan artikel yang sudah
                    disetujui. Dokumen verifikasi, email, dan data pribadi tidak ditampilkan
                    kepada publik.
                </div>
            </div>

        </section>

        <section class="bd-section">
            <div class="bd-section-head">
                <div>
                    <p class="bd-section-kicker">Rekam Jejak Publikasi</p>
                    <h2 class="bd-section-title">Artikel yang telah diterbitkan</h2>
                </div>
            </div>

            @if($posts->count())
                <div class="bd-post-grid">
                    @foreach($posts as $post)
                        @php
                            $excerpt = \Illuminate\Support\Str::limit(
                                trim(
                                    preg_replace(
                                        '/\s+/u',
                                        ' ',
                                        strip_tags(html_entity_decode($post->content))
                                    )
                                ),
                                190
                            );
                        @endphp

                        <a
                            href="{{ route('blog.show', $post->slug) }}"
                            class="bd-post-card"
                        >
                            <span class="bd-post-cat">
                                {{ $post->category ?: 'Artikel' }}
                            </span>

                            <h3 class="bd-post-title">
                                {{ $post->title }}
                            </h3>

                            <p class="bd-post-excerpt">
                                {{ $excerpt }}
                            </p>

                            <div class="bd-post-meta">
                                <span>{{ $post->created_at->translatedFormat('d M Y') }}</span>
                                <span>{{ number_format((int) $post->views, 0, ',', '.') }} dibaca</span>
                                <span>{{ $post->comments_count }} komentar</span>
                            </div>
                        </a>
                    @endforeach
                </div>

                @if($posts->hasPages())
                    <div class="mt-7">
                        {{ $posts->links() }}
                    </div>
                @endif
            @else
                <div class="bd-empty">
                    Belum ada artikel yang diterbitkan dari akun ini.
                </div>
            @endif
        </section>

    </div>
</div>

@endsection
