@php
    $depth = $depth ?? 0;
    $flatMode = $flatMode ?? false;
    $isRootComment = !$flatMode && $depth === 0;

    $threadReplies = collect();

    if ($isRootComment) {
        $flattenReplies = function ($items) use (&$flattenReplies) {
            $flat = collect();

            foreach ($items as $item) {
                $flat->push($item);

                if ($item->replies->isNotEmpty()) {
                    $flat = $flat->concat($flattenReplies($item->replies));
                }
            }

            return $flat;
        };

        $threadReplies = $flattenReplies($comment->replies);
    }

    $replyCount = $threadReplies->count();
    $replyToName = $comment->parent?->user?->name;
@endphp

<article
    class="bd-comment {{ $depth > 0 ? 'is-reply' : '' }}"
    id="comment-{{ $comment->id }}"
    data-comment-id="{{ $comment->id }}"
    data-parent-id="{{ $comment->parent_id ?? '' }}"
>
    <div class="bd-comment-avatar">{{ strtoupper(mb_substr($comment->user->name ?? 'U', 0, 1)) }}</div>

    <div class="bd-comment-body">
        <div class="bd-comment-top">
            <div class="bd-comment-meta">
                <div class="bd-comment-author">
                    @if($comment->user)
                        <a
                            href="{{ route('profile.public', $comment->user) }}"
                            class="bd-comment-author-link"
                            title="Lihat profil {{ $comment->user->name }}"
                        >
                            {{ $comment->user->name }}
                        </a>
                    @else
                        <span>User</span>
                    @endif

                    @if((int) $comment->user_id === (int) $post->user_id)
                        <span class="bd-author-badge">Penulis Artikel</span>
                    @endif

                    @if($comment->user?->isVerifiedAuthor())
                        <span
                            class="bd-verified-badge"
                            title="Identitas kepenulisan telah diverifikasi admin BacaDulu"
                        >
                            ✓ Penulis Terverifikasi
                        </span>
                    @endif
                </div>
            </div>

            @auth
            @if((int) auth()->id() === (int) $comment->user_id)
            <div class="bd-comment-actions">
                <button type="button" class="bd-comment-action js-comment-edit" title="Edit komentar" aria-label="Edit komentar">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9M16.5 3.5a2.1 2.1 0 013 3L8 18l-4 1 1-4L16.5 3.5z"/>
                    </svg>
                </button>

                <button type="button" class="bd-comment-action delete js-comment-delete" title="Hapus komentar" aria-label="Hapus komentar">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12m-10 0l1 13h6l1-13m-6-3h4l1 3H9l1-3z"/>
                    </svg>
                </button>
            </div>
            @endif
            @endauth
        </div>

        <p class="bd-comment-text">
            @if($replyToName)
                @if($comment->parent?->user)
                    <a
                        href="{{ route('profile.public', $comment->parent->user) }}"
                        class="bd-comment-mention"
                        title="Lihat profil {{ $replyToName }}"
                    >
                        {{ '@' . $replyToName }}
                    </a>
                @else
                    <span class="bd-comment-mention">{{ '@' . $replyToName }}</span>
                @endif
            @endif
            <span class="bd-comment-text-content">{{ $comment->content }}</span>
        </p>

        <div class="bd-comment-footer">
            <time class="bd-comment-time">{{ $comment->created_at->diffForHumans() }}</time>

            @auth
            @if($canInteract)
            <button
                type="button"
                class="bd-comment-reply js-comment-reply"
                title="Balas komentar"
                aria-expanded="false"
            >
                Balas
            </button>
            @endif
            @endauth
        </div>

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
                <span>Membalas <strong>{{ '@' . ($comment->user->name ?? 'User') }}</strong></span>
                <button type="button" class="bd-reply-close js-comment-reply-cancel" aria-label="Batal membalas">×</button>
            </div>

            <div class="bd-reply-composer">
                <span class="bd-reply-mention">{{ '@' . ($comment->user->name ?? 'User') }}</span>
                <textarea
                    name="content"
                    class="bd-reply-textarea"
                    maxlength="2000"
                    placeholder="Tulis balasan..."
                    required
                ></textarea>
            </div>

            <div class="bd-reply-form-footer">
                <span>Maksimal 2000 karakter.</span>
                <button type="submit" class="bd-reply-submit">Kirim Balasan</button>
            </div>
        </form>
        @endif
        @endauth

        @if($isRootComment && $replyCount > 0)
        <button
            type="button"
            class="bd-replies-toggle js-replies-toggle"
            aria-expanded="false"
            aria-controls="replies-{{ $comment->id }}"
            data-count="{{ $replyCount }}"
        >
            <span class="bd-replies-toggle-line" aria-hidden="true"></span>
            <span class="bd-replies-toggle-label">Lihat {{ $replyCount }} balasan</span>
            <svg class="bd-replies-toggle-icon" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/>
            </svg>
        </button>

        <div class="bd-comment-replies" id="replies-{{ $comment->id }}" hidden>
            @foreach($threadReplies as $reply)
                @include('blog.partials.comment', [
                    'comment' => $reply,
                    'post' => $post,
                    'canInteract' => $canInteract,
                    'depth' => 1,
                    'flatMode' => true,
                ])
            @endforeach
        </div>
        @endif
    </div>
</article>
