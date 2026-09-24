@php($depth = $depth ?? 0)

<article
    class="bd-comment {{ $depth > 0 ? 'is-reply' : '' }}"
    id="comment-{{ $comment->id }}"
    data-comment-id="{{ $comment->id }}"
>
    <div class="bd-comment-avatar">{{ strtoupper(mb_substr($comment->user->name ?? 'U', 0, 1)) }}</div>

    <div class="bd-comment-body">
        <div class="bd-comment-top">
            <div class="bd-comment-meta">
                <div class="bd-comment-author">
                    <span>{{ $comment->user->name ?? 'User' }}</span>

                    @if((int) $comment->user_id === (int) $post->user_id)
                    <span class="bd-author-badge">Penulis</span>
                    @endif
                </div>

                <time class="bd-comment-time">{{ $comment->created_at->diffForHumans() }}</time>
            </div>

            @auth
            <div class="bd-comment-actions">
                @if($canInteract)
                <button
                    type="button"
                    class="bd-comment-reply js-comment-reply"
                    title="Balas komentar"
                    aria-expanded="false"
                >
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17l-5-5 5-5m-5 5h10a6 6 0 016 6v1"/>
                    </svg>
                    Balas
                </button>
                @endif

                @if((int) auth()->id() === (int) $comment->user_id)
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
                @endif
            </div>
            @endauth
        </div>

        <p class="bd-comment-text">{{ $comment->content }}</p>

        @auth
        @if((int) auth()->id() === (int) $comment->user_id)
        <div class="bd-comment-edit">
            <textarea class="bd-edit-textarea" maxlength="2000">{{ $comment->content }}</textarea>

            <div class="bd-edit-actions">
                <button type="button" class="bd-edit-btn js-comment-cancel">Batal</button>
                <button type="button" class="bd-edit-btn save js-comment-save">Simpan</button>
            </div>
        </div>
        @endif

        @if($canInteract)
        <form
            action="{{ route('post.comment.store', $post->slug) }}"
            method="POST"
            class="bd-reply-form"
        >
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">

            <div class="bd-reply-form-head">
                <span>Membalas <strong>{{ $comment->user->name ?? 'User' }}</strong></span>
                <button type="button" class="bd-reply-close js-comment-reply-cancel" aria-label="Batal membalas">×</button>
            </div>

            <textarea
                name="content"
                class="bd-reply-textarea"
                maxlength="2000"
                placeholder="Tulis balasan..."
                required
            ></textarea>

            <div class="bd-reply-form-footer">
                <span>Maksimal 2000 karakter.</span>
                <button type="submit" class="bd-reply-submit">Kirim Balasan</button>
            </div>
        </form>
        @endif
        @endauth

        @if($comment->replies->isNotEmpty())
        <div class="bd-comment-replies">
            @foreach($comment->replies as $reply)
                @include('blog.partials.comment', [
                    'comment' => $reply,
                    'post' => $post,
                    'canInteract' => $canInteract,
                    'depth' => $depth + 1,
                ])
            @endforeach
        </div>
        @endif
    </div>
</article>
