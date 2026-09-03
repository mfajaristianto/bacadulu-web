@extends('layouts.app')

@section('content')

<style>
.bd-article-page{
    --orange:#EF5843;
    --orange-dark:#DC4936;
    --navy:#241B52;
    --text:#182235;
    --body:#667085;
    --muted:#98A2B3;
    --line:#E5E9EF;
    min-height:100vh;
    padding:42px 20px 72px;
    background:#f8f9fb;
    color:var(--text);
    font-family:Inter,sans-serif;
}
.bd-article-page *{box-sizing:border-box}
.bd-article-shell{width:min(100%,900px);margin:auto}
.bd-back{
    display:inline-flex;align-items:center;gap:7px;margin-bottom:18px;
    color:#64748b;font-size:13px;font-weight:600;text-decoration:none;transition:.2s
}
.bd-back:hover{color:var(--orange);transform:translateX(-3px)}

/* ARTICLE */
.bd-article-card{
    padding:34px;border:1px solid var(--line);border-radius:18px;
    background:#fff;box-shadow:0 8px 30px rgba(31,41,55,.035)
}
.bd-category{
    display:inline-flex;align-items:center;min-height:30px;margin-bottom:15px;
    padding:0 11px;border-radius:999px;background:#fff1ec;
    color:#dc4936;font-size:10px;font-weight:800
}
.bd-article-header{display:flex;align-items:flex-start;justify-content:space-between;gap:22px}
.bd-article-title{
    min-width:0;margin:0;color:#171f32;font-size:clamp(29px,4vw,43px);
    line-height:1.08;font-weight:800;letter-spacing:-.035em;overflow-wrap:anywhere
}
.bd-owner-actions{display:flex;gap:8px;flex-shrink:0}
.bd-owner-action{
    width:38px;height:38px;display:grid;place-items:center;padding:0;
    border:1px solid #e2e6ec;border-radius:10px;background:#fff;
    color:#64748b;text-decoration:none;cursor:pointer;transition:.2s
}
.bd-owner-action:hover{
    border-color:#ffd1c4;background:#fff6f2;color:var(--orange);transform:translateY(-1px)
}
.bd-owner-action.delete{color:#dc5962}
.bd-author{display:flex;align-items:center;gap:11px;margin-top:21px}
.bd-avatar{
    width:40px;height:40px;display:grid;place-items:center;flex:0 0 40px;
    border-radius:50%;background:var(--orange);color:#fff;font-size:13px;font-weight:800
}
.bd-author-name{color:#273247;font-size:13px;font-weight:800}
.bd-author-date{margin-top:2px;color:#94a3b8;font-size:11px}

/* IMAGE */
.bd-article-media{
    width:min(100%,560px);margin:27px auto 0;padding:10px;
    border:1px solid #e8ebf0;border-radius:14px;background:#f8f9fb
}
.bd-article-image{
    display:block;width:100%;height:auto;max-height:300px;margin:auto;
    object-fit:contain;object-position:center;border-radius:9px
}

/* CONTENT */
.bd-content{
    margin-top:29px;color:#3f4959;font-size:15px;line-height:1.88;overflow-wrap:anywhere
}
.bd-content p{margin:0 0 17px}
.bd-content img{display:block;max-width:100%;height:auto;margin:22px auto;border-radius:10px}

/* LIKE */
.bd-engagement{display:flex;margin-top:30px;padding-top:18px;border-top:1px solid #eef0f3}
.bd-like{
    min-height:38px;display:inline-flex;align-items:center;gap:8px;padding:0 14px;
    border:1px solid #e3e6eb;border-radius:999px;background:#fff;
    color:#596579;font-size:11px;font-weight:800;text-decoration:none;cursor:pointer;transition:.2s
}
.bd-like:hover,.bd-like.liked{border-color:#ffd2c4;background:#fff5f1;color:var(--orange)}
.bd-like-count{
    min-width:22px;height:22px;display:grid;place-items:center;padding:0 6px;
    border-radius:999px;background:#f5f6f8;font-size:10px
}

/* DISCUSSION */
.bd-discussion{margin-top:36px;scroll-margin-top:110px}
.bd-discussion-head{
    display:flex;align-items:flex-end;justify-content:space-between;
    gap:20px;margin-bottom:17px
}
.bd-discussion-kicker{
    margin:0 0 5px;color:var(--orange);font-size:9px;
    font-weight:800;letter-spacing:.14em;text-transform:uppercase
}
.bd-discussion-title{margin:0;color:#172036;font-size:26px;font-weight:800;letter-spacing:-.025em}
.bd-discussion-subtitle{margin:5px 0 0;color:#7b8799;font-size:11px}
.bd-comment-count{
    flex-shrink:0;padding:7px 11px;border:1px solid #e4e8ee;
    border-radius:999px;background:#fff;color:#64748b;font-size:10px;font-weight:800
}

/* COMMENT COMPOSER */
.bd-compose{
    padding:18px;border:1px solid #e3e7ed;border-radius:16px;background:#fff;
    box-shadow:0 5px 20px rgba(31,41,55,.025)
}
.bd-compose-row{display:flex;align-items:flex-start;gap:13px}
.bd-compose-main{min-width:0;flex:1}
.bd-compose textarea,.bd-edit-textarea{
    width:100%;resize:vertical;padding:13px 14px;border:1px solid transparent;
    border-radius:11px;outline:none;background:#f7f8fa;color:#263247;
    font-family:inherit;font-size:12px;line-height:1.65;transition:.2s
}
.bd-compose textarea{min-height:105px}
.bd-edit-textarea{min-height:86px}
.bd-compose textarea:focus,.bd-edit-textarea:focus{
    border-color:rgba(239,88,67,.28);background:#fff;
    box-shadow:0 0 0 3px rgba(239,88,67,.08)
}
.bd-compose-footer{
    display:flex;align-items:center;justify-content:space-between;gap:15px;margin-top:11px
}
.bd-compose-help{color:#9aa4b2;font-size:9px}
.bd-send{
    min-height:39px;display:inline-flex;align-items:center;gap:7px;padding:0 17px;
    border:0;border-radius:9px;background:var(--orange);color:#fff;
    font-family:inherit;font-size:11px;font-weight:800;cursor:pointer;transition:.2s
}
.bd-send:hover{background:var(--orange-dark);transform:translateY(-1px)}
.bd-send:disabled{opacity:.6;cursor:wait;transform:none}

/* COMMENT LIST */
.bd-comments{
    margin-top:17px;overflow:hidden;border:1px solid #e3e7ed;
    border-radius:16px;background:#fff
}
.bd-comment{display:flex;align-items:flex-start;gap:13px;padding:19px 20px;transition:.25s}
.bd-comment+.bd-comment{border-top:1px solid #eef0f3}
.bd-comment-avatar{
    width:38px;height:38px;display:grid;place-items:center;flex:0 0 38px;
    border-radius:50%;background:#fff1ec;color:#e44c37;font-size:11px;font-weight:800
}
.bd-comment-body{min-width:0;flex:1}
.bd-comment-top{display:flex;align-items:flex-start;justify-content:space-between;gap:15px}
.bd-comment-meta{min-width:0}
.bd-comment-author{
    display:flex;align-items:center;gap:7px;color:#273247;font-size:11px;font-weight:800
}
.bd-author-badge{
    padding:3px 6px;border-radius:999px;background:#fff2ed;
    color:#e34e38;font-size:7px;font-weight:800;text-transform:uppercase
}
.bd-comment-time{display:block;margin-top:3px;color:#a0a8b4;font-size:8px}
.bd-comment-text{
    margin:8px 0 0;color:#4b5565;font-size:12px;
    line-height:1.65;white-space:pre-line;overflow-wrap:anywhere
}

/* COMMENT OWNER ACTION */
.bd-comment-actions{display:flex;align-items:center;gap:3px;flex-shrink:0}
.bd-comment-action{
    width:30px;height:30px;display:grid;place-items:center;padding:0;
    border:0;border-radius:8px;background:transparent;color:#98a2b3;
    cursor:pointer;transition:.2s
}
.bd-comment-action:hover{background:#f5f6f8;color:#475467}
.bd-comment-action.delete:hover{background:#fff1f2;color:#dc4452}

/* INLINE EDIT */
.bd-comment-edit{display:none;margin-top:10px}
.bd-comment.editing .bd-comment-text{display:none}
.bd-comment.editing .bd-comment-edit{display:block}
.bd-comment.editing .bd-comment-actions{opacity:.4;pointer-events:none}
.bd-edit-actions{display:flex;justify-content:flex-end;gap:7px;margin-top:8px}
.bd-edit-btn{
    min-height:33px;padding:0 12px;border:1px solid #e1e5ea;
    border-radius:8px;background:#fff;color:#667085;
    font-size:9px;font-weight:800;cursor:pointer
}
.bd-edit-btn.save{border-color:var(--orange);background:var(--orange);color:#fff}

/* EMPTY */
.bd-comment-empty{padding:45px 20px;text-align:center;color:#98a1ae;font-size:11px}
.bd-comment-empty strong{display:block;margin-bottom:4px;color:#5d6878;font-size:12px}

/* GUEST */
.bd-login-comment{
    display:flex;align-items:center;justify-content:space-between;gap:20px;
    padding:18px;border:1px solid #e3e7ed;border-radius:14px;background:#fff
}
.bd-login-comment strong{display:block;color:#263247;font-size:12px}
.bd-login-comment p{margin:4px 0 0;color:#8791a1;font-size:10px}
.bd-login-btn{
    padding:9px 14px;border:1px solid #ffd0c0;border-radius:8px;
    color:#df4a34;font-size:10px;font-weight:800;text-decoration:none
}

/* =========================================================
   FEEDBACK POPUP
========================================================= */
.bd-feedback{
    position:fixed;z-index:999999;inset:0;display:grid;place-items:center;
    padding:20px;visibility:hidden;pointer-events:none
}
.bd-feedback.is-open{visibility:visible;pointer-events:auto}
.bd-feedback-backdrop{
    position:absolute;inset:0;background:rgba(24,20,46,.28);
    backdrop-filter:blur(2px);opacity:0
}
.bd-feedback-card{
    position:relative;z-index:2;width:min(330px,92vw);
    overflow:hidden;padding:25px 24px 22px;
    border:1px solid rgba(36,27,82,.08);border-radius:20px;
    background:#fff;box-shadow:0 25px 70px rgba(30,25,60,.20);
    text-align:center;opacity:0;transform:scale(.88) translateY(12px)
}
.bd-feedback-accent{
    position:absolute;left:0;right:0;top:0;height:4px;
    background:linear-gradient(90deg,var(--orange),#F7AA35)
}
.bd-feedback-icon{
    position:relative;width:62px;height:62px;display:grid;place-items:center;
    margin:1px auto 14px;border-radius:50%;background:#fff2ed;color:var(--orange)
}
.bd-feedback-icon::before,.bd-feedback-icon::after{
    content:"";position:absolute;border-radius:50%;border:1px solid rgba(239,88,67,.18)
}
.bd-feedback-icon::before{inset:-7px}
.bd-feedback-icon::after{inset:-14px;opacity:.5}
.bd-feedback-icon svg{width:27px;height:27px}
.bd-feedback-check{stroke-dasharray:35;stroke-dashoffset:35}
.bd-feedback-label{
    margin:0 0 5px;color:var(--orange);font-size:8px;font-weight:900;
    letter-spacing:.16em;text-transform:uppercase
}
.bd-feedback-title{
    margin:0;color:#1f2937;font-size:18px;font-weight:850;letter-spacing:-.02em
}
.bd-feedback-message{
    max-width:245px;margin:7px auto 0;color:#7c8798;font-size:10px;line-height:1.55
}
.bd-feedback.error .bd-feedback-accent{background:#dc4452}
.bd-feedback.error .bd-feedback-icon{background:#fff1f2;color:#dc4452}
.bd-feedback.error .bd-feedback-label{color:#dc4452}

/* DELETE CONFIRM */
.bd-confirm{
    position:fixed;z-index:1000000;inset:0;display:grid;place-items:center;
    padding:20px;visibility:hidden;pointer-events:none
}
.bd-confirm.open{visibility:visible;pointer-events:auto}
.bd-confirm-backdrop{position:absolute;inset:0;background:rgba(24,20,46,.35);backdrop-filter:blur(2px)}
.bd-confirm-card{
    position:relative;z-index:2;width:min(345px,92vw);
    padding:25px;border-radius:18px;background:#fff;
    box-shadow:0 25px 70px rgba(25,20,50,.25);
    opacity:0;transform:scale(.92) translateY(10px)
}
.bd-confirm-icon{
    width:44px;height:44px;display:grid;place-items:center;
    margin-bottom:14px;border-radius:12px;background:#fff1f2;color:#dc4452
}
.bd-confirm-card h3{margin:0;color:#1f2937;font-size:16px;font-weight:800}
.bd-confirm-card p{margin:7px 0 0;color:#7c8798;font-size:10px;line-height:1.6}
.bd-confirm-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:20px}
.bd-confirm-btn{
    min-height:36px;padding:0 14px;border:1px solid #e2e6eb;border-radius:9px;
    background:#fff;color:#667085;font-size:10px;font-weight:800;cursor:pointer
}
.bd-confirm-btn.delete{border-color:#dc4452;background:#dc4452;color:#fff}

@media(max-width:640px){
    .bd-article-page{padding:26px 14px 55px}
    .bd-article-card{padding:22px 18px}
    .bd-article-header{display:block}
    .bd-owner-actions{margin-top:15px}
    .bd-article-media{width:100%;max-width:420px;padding:7px}
    .bd-article-image{max-height:240px}
    .bd-compose-row{display:block}
    .bd-compose-row>.bd-avatar{display:none}
    .bd-login-comment{align-items:flex-start;flex-direction:column}
    .bd-comment{padding:17px 15px}
}
</style>

@php
    $authorName=$post->user->name ?? $post->author ?? 'Admin Utama';
    $isLiked=auth()->check() && $post->likes()->where('user_id',auth()->id())->exists();
@endphp

<div class="bd-article-page">
<div class="bd-article-shell">

<a href="{{ route('blog.index') }}" class="bd-back">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
    </svg>
    Kembali ke Blogging
</a>

<article class="bd-article-card">

@if($post->category)
<span class="bd-category">{{ $post->category }}</span>
@endif

<div class="bd-article-header">
    <h1 class="bd-article-title">{{ $post->title }}</h1>

    @auth
    @if(auth()->id()===$post->user_id)
    <div class="bd-owner-actions">
        <a href="{{ route('blog.edit',$post->slug) }}" class="bd-owner-action" title="Edit artikel">
            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.4-9.4a2 2 0 112.8 2.8L11.8 15H9v-2.8l8.6-8.6z"/>
            </svg>
        </a>

        <form action="{{ route('blog.destroy',$post->slug) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
            @csrf
            @method('DELETE')
            <button class="bd-owner-action delete">
                <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.8 12A2 2 0 0116 21H8a2 2 0 01-2-2L5 7m5 4v6m4-6v6M9 4h6l1 3H8l1-3z"/>
                </svg>
            </button>
        </form>
    </div>
    @endif
    @endauth
</div>

<div class="bd-author">
    <div class="bd-avatar">{{ strtoupper(mb_substr($authorName,0,1)) }}</div>
    <div>
        <div class="bd-author-name">{{ $authorName }}</div>
        <div class="bd-author-date">{{ $post->created_at->translatedFormat('d F Y') }}</div>
    </div>
</div>

@if($post->image)
<div class="bd-article-media">
    <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" class="bd-article-image">
</div>
@endif

<div class="bd-content prose prose-slate max-w-none">{!! $post->content !!}</div>

<div class="bd-engagement">
@auth
<button type="button" onclick="toggleLike('{{ $post->slug }}')" id="like-btn" class="bd-like {{ $isLiked?'liked':'' }}">
    <svg id="like-icon" width="17" height="17" fill="{{ $isLiked?'currentColor':'none' }}" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.3 6.3a4.5 4.5 0 000 6.4L12 20.4l7.7-7.7a4.5 4.5 0 00-6.4-6.4L12 7.6l-1.3-1.3a4.5 4.5 0 00-6.4 0z"/>
    </svg>
    Suka
    <span class="bd-like-count" id="like-count">{{ $post->likes()->count() }}</span>
</button>
@else
<a href="{{ route('login') }}" class="bd-like">Suka <span class="bd-like-count">{{ $post->likes()->count() }}</span></a>
@endauth
</div>

</article>

<section class="bd-discussion" id="comments">

<div class="bd-discussion-head">
    <div>
        <p class="bd-discussion-kicker">Diskusi</p>
        <h2 class="bd-discussion-title">Komentar</h2>
        <p class="bd-discussion-subtitle">Bagikan tanggapan atau pemikiran yang relevan dengan artikel.</p>
    </div>
    <span class="bd-comment-count" id="bdCommentCount">{{ $post->comments->count() }} komentar</span>
</div>

@auth
<form action="{{ route('post.comment.store',$post->slug) }}" method="POST" class="bd-compose" id="bdCommentForm">
    @csrf
    <div class="bd-compose-row">
        <div class="bd-avatar">{{ strtoupper(mb_substr(auth()->user()->name ?? 'U',0,1)) }}</div>

        <div class="bd-compose-main">
            <textarea name="content" id="bdCommentTextarea" placeholder="Tulis tanggapan Anda..." required></textarea>

            <div class="bd-compose-footer">
                <span class="bd-compose-help">Jaga diskusi tetap relevan dan nyaman dibaca.</span>
                <button type="submit" class="bd-send" id="bdCommentSubmit">
                    <span id="bdCommentSubmitText">Kirim</span>
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</form>
@else
<div class="bd-login-comment">
    <div>
        <strong>Ingin ikut berdiskusi?</strong>
        <p>Masuk ke akun Baca Dulu untuk menulis komentar.</p>
    </div>
    <a href="{{ route('login') }}" class="bd-login-btn">Masuk untuk berkomentar</a>
</div>
@endauth

<div class="bd-comments" id="bdCommentsList">

@forelse($post->comments as $comment)

<article class="bd-comment" id="comment-{{ $comment->id }}" data-comment-id="{{ $comment->id }}">
    <div class="bd-comment-avatar">{{ strtoupper(mb_substr($comment->user->name ?? 'U',0,1)) }}</div>

    <div class="bd-comment-body">
        <div class="bd-comment-top">
            <div class="bd-comment-meta">
                <div class="bd-comment-author">
                    <span>{{ $comment->user->name ?? 'User' }}</span>

                    @if($comment->user_id===$post->user_id)
                    <span class="bd-author-badge">Penulis</span>
                    @endif
                </div>

                <time class="bd-comment-time">{{ $comment->created_at->diffForHumans() }}</time>
            </div>

            @auth
            @if(auth()->id()===$comment->user_id)
            <div class="bd-comment-actions">
                <button type="button" class="bd-comment-action js-comment-edit" title="Edit komentar">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9M16.5 3.5a2.1 2.1 0 013 3L8 18l-4 1 1-4L16.5 3.5z"/>
                    </svg>
                </button>

                <button type="button" class="bd-comment-action delete js-comment-delete" title="Hapus komentar">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12m-10 0l1 13h6l1-13m-6-3h4l1 3H9l1-3z"/>
                    </svg>
                </button>
            </div>
            @endif
            @endauth
        </div>

        <p class="bd-comment-text">{{ $comment->content }}</p>

        @auth
        @if(auth()->id()===$comment->user_id)
        <div class="bd-comment-edit">
            <textarea class="bd-edit-textarea">{{ $comment->content }}</textarea>

            <div class="bd-edit-actions">
                <button type="button" class="bd-edit-btn js-comment-cancel">Batal</button>
                <button type="button" class="bd-edit-btn save js-comment-save">Simpan</button>
            </div>
        </div>
        @endif
        @endauth
    </div>
</article>

@empty
<div class="bd-comment-empty" id="bdCommentEmpty">
    <strong>Belum ada komentar</strong>
    Jadilah orang pertama yang memulai diskusi.
</div>
@endforelse

</div>

</section>
</div>
</div>

{{-- SUCCESS / ERROR POPUP --}}
<div class="bd-feedback" id="bdFeedback">
    <div class="bd-feedback-backdrop"></div>

    <div class="bd-feedback-card">
        <div class="bd-feedback-accent"></div>

        <div class="bd-feedback-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.7">
                <path class="bd-feedback-check" stroke-linecap="round" stroke-linejoin="round" d="M5 12.5l4 4L19 7"/>
            </svg>
        </div>

        <p class="bd-feedback-label" id="bdFeedbackLabel">Berhasil</p>
        <h3 class="bd-feedback-title" id="bdFeedbackTitle">Komentar terkirim</h3>
        <p class="bd-feedback-message" id="bdFeedbackMessage">Komentar berhasil ditambahkan.</p>
    </div>
</div>

{{-- DELETE CONFIRM --}}
<div class="bd-confirm" id="bdDeleteConfirm">
    <div class="bd-confirm-backdrop"></div>

    <div class="bd-confirm-card">
        <div class="bd-confirm-icon">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12m-10 0l1 13h6l1-13m-6-3h4l1 3H9l1-3z"/>
            </svg>
        </div>

        <h3>Hapus komentar?</h3>
        <p>Komentar yang sudah dihapus tidak dapat dikembalikan.</p>

        <div class="bd-confirm-actions">
            <button type="button" class="bd-confirm-btn" id="bdDeleteCancel">Batal</button>
            <button type="button" class="bd-confirm-btn delete" id="bdDeleteOkay">Hapus</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
(() => {
    const csrf='{{ csrf_token() }}';
    const currentUserId={{ auth()->id() ?? 'null' }};
    const postUserId={{ $post->user_id ?? 'null' }};

    const feedback=document.getElementById('bdFeedback');
    const feedbackCard=feedback?.querySelector('.bd-feedback-card');
    const feedbackBackdrop=feedback?.querySelector('.bd-feedback-backdrop');
    const feedbackIcon=feedback?.querySelector('.bd-feedback-icon');
    const feedbackCheck=feedback?.querySelector('.bd-feedback-check');

    const resolveGsap=()=>{
        const candidates=[window.bdGsap,window.bdGsap?.gsap,window.gsap];
        return candidates.find(g=>g&&typeof g.timeline==='function')||null;
    };

    function showFeedback(type,title,message){
        const gsap=resolveGsap();

        feedback.classList.remove('error');
        if(type==='error')feedback.classList.add('error');

        document.getElementById('bdFeedbackLabel').textContent=type==='error'?'Terjadi masalah':'Berhasil';
        document.getElementById('bdFeedbackTitle').textContent=title;
        document.getElementById('bdFeedbackMessage').textContent=message;

        feedback.classList.add('is-open');

        if(gsap){
            gsap.killTweensOf([feedbackCard,feedbackBackdrop,feedbackIcon]);

            gsap.set(feedbackCheck,{strokeDashoffset:35});

            const tl=gsap.timeline();

            tl.fromTo(feedbackBackdrop,
                {opacity:0},
                {opacity:1,duration:.16,ease:'power2.out'}
            );

            tl.fromTo(feedbackCard,
                {opacity:0,scale:.88,y:14},
                {opacity:1,scale:1,y:0,duration:.32,ease:'back.out(1.7)'},
                '-=.10'
            );

            tl.fromTo(feedbackIcon,
                {scale:.45,rotation:-12},
                {scale:1,rotation:0,duration:.28,ease:'back.out(2)'},
                '-=.22'
            );

            tl.to(feedbackCheck,{
                strokeDashoffset:0,
                duration:.22,
                ease:'power2.out'
            },'-=.14');

            tl.to({}, {duration:.55});

            tl.to(feedbackCard,{
                opacity:0,
                scale:.94,
                y:-7,
                duration:.18,
                ease:'power2.in'
            });

            tl.to(feedbackBackdrop,{
                opacity:0,
                duration:.16,
                ease:'power2.in',
                onComplete:()=>{
                    feedback.classList.remove('is-open');
                }
            },'-=.12');

            return;
        }

        setTimeout(()=>{
            feedback.classList.remove('is-open');
        },1200);
    }

    window.toggleLike=async slug=>{
        try{
            const response=await fetch(`/blog/${slug}/like`,{
                method:'POST',
                credentials:'same-origin',
                headers:{
                    'Accept':'application/json',
                    'X-Requested-With':'XMLHttpRequest',
                    'X-CSRF-TOKEN':csrf
                }
            });

            if(!response.ok)throw new Error();

            const data=await response.json();

            document.getElementById('like-count').textContent=data.likes_count;

            const btn=document.getElementById('like-btn');
            const icon=document.getElementById('like-icon');

            btn?.classList.toggle('liked',data.liked);
            icon?.setAttribute('fill',data.liked?'currentColor':'none');

        }catch{
            showFeedback('error','Like gagal','Silakan coba kembali.');
        }
    };

    const escapeHtml=value=>String(value??'')
        .replaceAll('&','&amp;')
        .replaceAll('<','&lt;')
        .replaceAll('>','&gt;')
        .replaceAll('"','&quot;')
        .replaceAll("'",'&#039;');

    function updateCount(count){
        const counter=document.getElementById('bdCommentCount');
        if(counter)counter.textContent=`${count} komentar`;
    }

    function newCommentMarkup(comment){
        return `
        <article class="bd-comment" id="comment-${comment.id}" data-comment-id="${comment.id}">
            <div class="bd-comment-avatar">${escapeHtml(comment.initial)}</div>

            <div class="bd-comment-body">
                <div class="bd-comment-top">
                    <div class="bd-comment-meta">
                        <div class="bd-comment-author">
                            <span>${escapeHtml(comment.user_name)}</span>
                            ${comment.is_post_author?'<span class="bd-author-badge">Penulis</span>':''}
                        </div>
                        <time class="bd-comment-time">baru saja</time>
                    </div>

                    <div class="bd-comment-actions">
                        <button type="button" class="bd-comment-action js-comment-edit" title="Edit komentar">
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9M16.5 3.5a2.1 2.1 0 013 3L8 18l-4 1 1-4L16.5 3.5z"/>
                            </svg>
                        </button>

                        <button type="button" class="bd-comment-action delete js-comment-delete" title="Hapus komentar">
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12m-10 0l1 13h6l1-13m-6-3h4l1 3H9l1-3z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <p class="bd-comment-text">${escapeHtml(comment.content)}</p>

                <div class="bd-comment-edit">
                    <textarea class="bd-edit-textarea">${escapeHtml(comment.content)}</textarea>
                    <div class="bd-edit-actions">
                        <button type="button" class="bd-edit-btn js-comment-cancel">Batal</button>
                        <button type="button" class="bd-edit-btn save js-comment-save">Simpan</button>
                    </div>
                </div>
            </div>
        </article>`;
    }

    const commentForm=document.getElementById('bdCommentForm');

    commentForm?.addEventListener('submit',async e=>{
        e.preventDefault();

        const textarea=document.getElementById('bdCommentTextarea');
        const submit=document.getElementById('bdCommentSubmit');
        const submitText=document.getElementById('bdCommentSubmitText');
        const content=textarea.value.trim();

        if(!content){
            showFeedback('error','Komentar kosong','Tulis komentar terlebih dahulu.');
            textarea.focus();
            return;
        }

        submit.disabled=true;
        submitText.textContent='Mengirim...';

        try{
            const response=await fetch(commentForm.action,{
                method:'POST',
                credentials:'same-origin',
                headers:{
                    'Accept':'application/json',
                    'X-Requested-With':'XMLHttpRequest',
                    'X-CSRF-TOKEN':csrf,
                    'Content-Type':'application/json'
                },
                body:JSON.stringify({content})
            });

            if(!response.ok)throw new Error();

            const data=await response.json();

            textarea.value='';

            document.getElementById('bdCommentEmpty')?.remove();

            const list=document.getElementById('bdCommentsList');
            list.insertAdjacentHTML('afterbegin',newCommentMarkup(data.comment));

            updateCount(data.comments_count);

            showFeedback(
                'success',
                'Komentar terkirim',
                'Komentar Anda sudah masuk ke diskusi.'
            );

        }catch{
            showFeedback(
                'error',
                'Komentar gagal',
                'Silakan coba kembali.'
            );
        }finally{
            submit.disabled=false;
            submitText.textContent='Kirim';
        }
    });

    document.addEventListener('click',async e=>{
        const edit=e.target.closest('.js-comment-edit');
        const cancel=e.target.closest('.js-comment-cancel');
        const save=e.target.closest('.js-comment-save');
        const remove=e.target.closest('.js-comment-delete');

        if(edit){
            const comment=edit.closest('.bd-comment');
            comment.classList.add('editing');
            comment.querySelector('.bd-edit-textarea')?.focus();
            return;
        }

        if(cancel){
            const comment=cancel.closest('.bd-comment');
            const text=comment.querySelector('.bd-comment-text')?.textContent.trim()??'';
            comment.querySelector('.bd-edit-textarea').value=text;
            comment.classList.remove('editing');
            return;
        }

        if(save){
            const comment=save.closest('.bd-comment');
            const id=comment.dataset.commentId;
            const textarea=comment.querySelector('.bd-edit-textarea');
            const content=textarea.value.trim();

            if(!content){
                showFeedback('error','Komentar kosong','Komentar tidak boleh kosong.');
                textarea.focus();
                return;
            }

            save.disabled=true;
            save.textContent='Menyimpan...';

            try{
                const response=await fetch(`/blog/comments/${id}`,{
                    method:'PUT',
                    credentials:'same-origin',
                    headers:{
                        'Accept':'application/json',
                        'X-Requested-With':'XMLHttpRequest',
                        'X-CSRF-TOKEN':csrf,
                        'Content-Type':'application/json'
                    },
                    body:JSON.stringify({content})
                });

                if(!response.ok)throw new Error();

                const data=await response.json();

                comment.querySelector('.bd-comment-text').textContent=data.comment.content;
                textarea.value=data.comment.content;
                comment.classList.remove('editing');

                showFeedback(
                    'success',
                    'Komentar diperbarui',
                    'Perubahan berhasil disimpan.'
                );

            }catch{
                showFeedback('error','Gagal menyimpan','Silakan coba kembali.');
            }finally{
                save.disabled=false;
                save.textContent='Simpan';
            }

            return;
        }

        if(remove){
            openDeleteConfirm(remove.closest('.bd-comment'));
        }
    });

    /* DELETE CONFIRM */
    const deleteModal=document.getElementById('bdDeleteConfirm');
    const deleteCard=deleteModal?.querySelector('.bd-confirm-card');
    const deleteBackdrop=deleteModal?.querySelector('.bd-confirm-backdrop');

    let commentToDelete=null;

    function openDeleteConfirm(comment){
        commentToDelete=comment;
        deleteModal.classList.add('open');

        const gsap=resolveGsap();

        if(gsap){
            gsap.fromTo(deleteBackdrop,{opacity:0},{opacity:1,duration:.16});
            gsap.fromTo(
                deleteCard,
                {opacity:0,scale:.9,y:12},
                {opacity:1,scale:1,y:0,duration:.28,ease:'back.out(1.5)'}
            );
        }else{
            deleteCard.style.opacity=1;
            deleteCard.style.transform='none';
        }
    }

    function closeDeleteConfirm(){
        const gsap=resolveGsap();

        if(gsap){
            gsap.to(deleteCard,{
                opacity:0,
                scale:.94,
                y:8,
                duration:.15,
                onComplete:()=>{
                    deleteModal.classList.remove('open');
                    commentToDelete=null;
                }
            });

            gsap.to(deleteBackdrop,{opacity:0,duration:.15});
        }else{
            deleteModal.classList.remove('open');
            commentToDelete=null;
        }
    }

    document.getElementById('bdDeleteCancel')?.addEventListener('click',closeDeleteConfirm);
    deleteBackdrop?.addEventListener('click',closeDeleteConfirm);

    document.getElementById('bdDeleteOkay')?.addEventListener('click',async ()=>{
        if(!commentToDelete)return;

        const id=commentToDelete.dataset.commentId;
        const button=document.getElementById('bdDeleteOkay');

        button.disabled=true;
        button.textContent='Menghapus...';

        try{
            const response=await fetch(`/blog/comments/${id}`,{
                method:'DELETE',
                credentials:'same-origin',
                headers:{
                    'Accept':'application/json',
                    'X-Requested-With':'XMLHttpRequest',
                    'X-CSRF-TOKEN':csrf
                }
            });

            if(!response.ok)throw new Error();

            const data=await response.json();
            const target=commentToDelete;

            closeDeleteConfirm();

            const gsap=resolveGsap();

            if(gsap){
                gsap.to(target,{
                    opacity:0,
                    height:0,
                    paddingTop:0,
                    paddingBottom:0,
                    duration:.28,
                    ease:'power2.inOut',
                    onComplete:()=>target.remove()
                });
            }else{
                target.remove();
            }

            updateCount(data.comments_count);

            showFeedback(
                'success',
                'Komentar dihapus',
                'Komentar berhasil dihapus.'
            );

        }catch{
            showFeedback(
                'error',
                'Gagal menghapus',
                'Silakan coba kembali.'
            );
        }finally{
            button.disabled=false;
            button.textContent='Hapus';
        }
    });
})();
</script>
@endpush

@endsection