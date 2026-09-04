@props([
    'user' => null,
    'size' => 40,
])

@php
    $name = $user?->name ?? 'User';

    $initials = collect(
        preg_split('/\s+/', trim($name))
    )
        ->filter()
        ->map(fn($word) => mb_strtoupper(
            mb_substr($word, 0, 1)
        ))
        ->take(2)
        ->implode('');

    if ($initials === '') {
        $initials = 'U';
    }

    $source =
        $user?->avatar_source
        ?: 'google';

    $avatarUrl = null;

    if (
        $source === 'custom' &&
        !empty($user?->profile_photo)
    ) {
        $avatarUrl = asset(
            'storage/' .
            $user->profile_photo
        );
    }

    if (
        $source === 'google' &&
        !empty($user?->avatar) &&
        filter_var(
            $user->avatar,
            FILTER_VALIDATE_URL
        )
    ) {
        $avatarUrl = route(
            'profile.google-avatar',
            $user->id
        );
    }
@endphp

<div
    {{ $attributes->merge([
        'class' =>
            'relative shrink-0 overflow-hidden rounded-full bg-orange-600'
    ]) }}
    style="width:{{ (int)$size }}px;height:{{ (int)$size }}px;"
>
    @if($avatarUrl)

        <img
            src="{{ $avatarUrl }}"
            alt="{{ $name }}"
            loading="lazy"
            decoding="async"
            referrerpolicy="no-referrer"
            class="absolute inset-0 block h-full w-full object-cover"
            onerror="
                this.style.display='none';
                this.nextElementSibling.style.display='flex';
            "
        >

    @endif

    <div
        class="
            absolute
            inset-0
            items-center
            justify-center
            bg-orange-600
            text-white
            font-bold
            select-none
        "
        style="
            display:{{ $avatarUrl ? 'none' : 'flex' }};
            font-size:{{ max(10, (int)$size * .34) }}px;
        "
        aria-label="{{ $name }}"
    >
        {{ $initials }}
    </div>
</div>