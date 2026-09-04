@extends('layouts.app')

@section('title', 'Foto Profil - Baca Dulu')

@section('content')

@php
    $initials = collect(
        preg_split('/\s+/', trim($user->name ?? 'User'))
    )
        ->filter()
        ->map(fn($word) =>
            mb_strtoupper(
                mb_substr($word,0,1)
            )
        )
        ->take(2)
        ->implode('');

    $hasGoogleAvatar =
        !empty($user->avatar) &&
        filter_var(
            $user->avatar,
            FILTER_VALIDATE_URL
        );

    $hasCustomAvatar =
        !empty($user->profile_photo);
@endphp

<div class="min-h-[calc(100vh-80px)] bg-slate-50 py-10">

    <div class="mx-auto w-full max-w-3xl px-5">

        <div class="mb-6">

            <div class="mb-2 flex items-center gap-2">

                <span class="h-[3px] w-7 rounded-full bg-orange-500"></span>

                <span class="text-[11px] font-bold uppercase tracking-[.16em] text-orange-600">
                    Profil Baca Dulu
                </span>

            </div>

            <h1 class="text-3xl font-extrabold text-slate-900">
                Foto Profil
            </h1>

            <p class="mt-2 text-sm leading-relaxed text-slate-500">
                Pilih foto Google, gunakan foto sendiri, atau tampilkan inisial nama.
            </p>

        </div>


        @if($errors->any())

            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

                <ul class="list-disc space-y-1 pl-5">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =====================================================
             CURRENT PROFILE
        ====================================================== --}}

        <section class="mb-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-center gap-5">

                <x-user-avatar
                    :user="$user"
                    :size="88"
                    class="ring-4 ring-slate-50"
                />

                <div class="min-w-0">

                    <p class="text-lg font-bold text-slate-900">
                        {{ $user->name }}
                    </p>

                    <p class="mt-1 truncate text-sm text-slate-500">
                        {{ $user->email }}
                    </p>

                    <p class="mt-3 text-xs font-semibold text-slate-400">

                        Foto aktif:

                        <span class="text-orange-600">

                            @if(($user->avatar_source ?? 'google') === 'custom')

                                Foto sendiri

                            @elseif(($user->avatar_source ?? 'google') === 'initials')

                                Inisial

                            @else

                                Google

                            @endif

                        </span>

                    </p>

                </div>

            </div>

        </section>


        {{-- =====================================================
             OPTIONS
        ====================================================== --}}

        <div class="grid gap-5 md:grid-cols-3">

            {{-- GOOGLE --}}
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="mb-4 flex h-16 items-center">

                    @if($hasGoogleAvatar)

                        <img
                            src="{{ route('profile.google-avatar',$user->id) }}"
                            alt="Foto Google"
                            class="h-14 w-14 rounded-full border border-slate-200 object-cover"
                            onerror="this.style.display='none';"
                        >

                    @else

                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-400">
                            Google
                        </div>

                    @endif

                </div>


                <h2 class="font-bold text-slate-900">
                    Foto Google
                </h2>

                <p class="mt-2 min-h-[48px] text-xs leading-relaxed text-slate-500">
                    Gunakan foto yang berasal dari akun Google saat login.
                </p>


                <form
                    action="{{ route('profile.photo.google') }}"
                    method="POST"
                    class="mt-5"
                >

                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        {{ !$hasGoogleAvatar ? 'disabled' : '' }}
                        class="
                            w-full rounded-xl px-4 py-2.5
                            text-sm font-bold transition
                            {{ $hasGoogleAvatar
                                ? 'bg-[#241B52] text-white hover:bg-[#31256e]'
                                : 'cursor-not-allowed bg-slate-100 text-slate-400'
                            }}
                        "
                    >
                        Gunakan Google
                    </button>

                </form>

            </section>


            {{-- CUSTOM --}}
            <section class="rounded-2xl border border-orange-200 bg-white p-5 shadow-sm">

                <div class="mb-4 flex h-16 items-center">

                    @if($hasCustomAvatar)

                        <img
                            src="{{ asset('storage/'.$user->profile_photo) }}"
                            alt="Foto sendiri"
                            class="h-14 w-14 rounded-full border border-slate-200 object-cover"
                        >

                    @else

                        <div class="flex h-14 w-14 items-center justify-center rounded-full bg-orange-50 text-orange-600">
                            +
                        </div>

                    @endif

                </div>


                <h2 class="font-bold text-slate-900">
                    Foto Sendiri
                </h2>

                <p class="mt-2 min-h-[48px] text-xs leading-relaxed text-slate-500">
                    Upload foto sendiri. Foto akan otomatis disesuaikan ke area profil.
                </p>


                <form
                    action="{{ route('profile.photo.update') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="mt-5 space-y-3"
                >

                    @csrf

                    <input
                        type="file"
                        name="photo"
                        accept="image/jpeg,image/png,image/webp"
                        required
                        class="
                            block w-full text-xs text-slate-500
                            file:mr-2
                            file:rounded-lg
                            file:border-0
                            file:bg-orange-50
                            file:px-3
                            file:py-2
                            file:text-xs
                            file:font-bold
                            file:text-orange-700
                        "
                    >

                    <button
                        type="submit"
                        class="
                            w-full
                            rounded-xl
                            bg-orange-600
                            px-4
                            py-2.5
                            text-sm
                            font-bold
                            text-white
                            transition
                            hover:bg-orange-700
                        "
                    >
                        Upload & Gunakan
                    </button>

                </form>

            </section>


            {{-- INITIAL --}}
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="mb-4 flex h-16 items-center">

                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-orange-600 text-lg font-bold text-white">
                        {{ $initials ?: 'U' }}
                    </div>

                </div>


                <h2 class="font-bold text-slate-900">
                    Tanpa Foto
                </h2>

                <p class="mt-2 min-h-[48px] text-xs leading-relaxed text-slate-500">
                    Tidak menampilkan Google maupun foto sendiri. Hanya inisial.
                </p>


                <form
                    action="{{ route('profile.photo.initials') }}"
                    method="POST"
                    class="mt-5"
                >

                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        class="
                            w-full
                            rounded-xl
                            border
                            border-slate-300
                            bg-white
                            px-4
                            py-2.5
                            text-sm
                            font-bold
                            text-slate-700
                            transition
                            hover:bg-slate-50
                        "
                    >
                        Gunakan Inisial
                    </button>

                </form>

            </section>

        </div>


        <div class="mt-6">

            <a
                href="{{ route('blog.index') }}"
                class="
                    text-sm
                    font-semibold
                    text-slate-500
                    transition
                    hover:text-orange-600
                "
            >
                ← Kembali ke Blogging
            </a>

        </div>

    </div>

</div>


{{-- =============================================================
     SUCCESS POPUP
============================================================= --}}

@if(session('profile_success'))

    <div
        id="bdProfileSuccess"
        class="bd-profile-popup"
        role="status"
        aria-live="polite"
    >

        <div class="bd-profile-popup-backdrop"></div>

        <div class="bd-profile-popup-card">

            <div class="bd-profile-popup-icon">

                <svg viewBox="0 0 24 24">
                    <path d="M5 12.5l4.2 4.2L19 7"/>
                </svg>

            </div>

            <h3>
                Berhasil
            </h3>

            <p>
                {{ session('profile_success') }}
            </p>

        </div>

    </div>

@endif


<style>
.bd-profile-popup{
    position:fixed;
    z-index:999999;
    inset:0;
    display:grid;
    place-items:center;
    padding:20px;
    visibility:hidden;
    pointer-events:none;
}

.bd-profile-popup.is-open{
    visibility:visible;
    pointer-events:auto;
}

.bd-profile-popup-backdrop{
    position:absolute;
    inset:0;
    background:rgba(24,20,46,.28);
    opacity:0;
}

.bd-profile-popup-card{
    position:relative;
    z-index:2;
    width:min(330px,92vw);
    padding:27px 24px 24px;
    border:1px solid rgba(36,27,82,.08);
    border-radius:20px;
    background:#fff;
    box-shadow:0 24px 65px rgba(30,25,60,.20);
    text-align:center;

    opacity:0;

    transform:
        translate3d(
            0,
            18px,
            0
        )
        scale(.94);

    will-change:
        transform,
        opacity;
}

.bd-profile-popup-icon{
    width:54px;
    height:54px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:0 auto 15px;
    border-radius:50%;
    background:#FFF0EC;
    color:#EF5843;
}

.bd-profile-popup-icon svg{
    width:27px;
    height:27px;
    fill:none;
    stroke:currentColor;
    stroke-width:2.4;
    stroke-linecap:round;
    stroke-linejoin:round;
}

.bd-profile-popup-card h3{
    margin:0;
    color:#241B52;
    font-size:19px;
    font-weight:800;
}

.bd-profile-popup-card p{
    margin:8px 0 0;
    color:#64748B;
    font-size:13px;
    line-height:1.6;
}

@media(prefers-reduced-motion:reduce){
    .bd-profile-popup-card{
        transform:none!important;
    }
}
</style>


@if(session('profile_success'))

<script>
(() => {

    const popup =
        document.getElementById(
            'bdProfileSuccess'
        );

    if (!popup) return;


    const backdrop =
        popup.querySelector(
            '.bd-profile-popup-backdrop'
        );

    const card =
        popup.querySelector(
            '.bd-profile-popup-card'
        );

    const icon =
        popup.querySelector(
            '.bd-profile-popup-icon'
        );


    if (
        !backdrop ||
        !card
    ) {
        return;
    }


    let closed = false;


    const resolveGsap = () => {

        const candidates = [
            window.bdGsap,
            window.bdGsap?.gsap,
            window.gsap,
            window.GSAP
        ];

        return candidates.find(
            item =>
                item &&
                typeof item.to === 'function' &&
                typeof item.fromTo === 'function' &&
                typeof item.timeline === 'function'
        ) || null;
    };


    const closePopup = () => {

        if (closed) return;

        closed = true;

        const gsap =
            resolveGsap();


        if (gsap) {

            const tl =
                gsap.timeline({
                    onComplete:() => {
                        popup.classList.remove(
                            'is-open'
                        );
                    }
                });


            tl.to(
                card,
                {
                    opacity:0,
                    y:-5,
                    scale:.97,
                    duration:.2,
                    ease:'power2.in',
                    force3D:true
                }
            );


            tl.to(
                backdrop,
                {
                    opacity:0,
                    duration:.16,
                    ease:'power2.in'
                },
                '-=.14'
            );


            return;
        }


        card.style.opacity =
            '0';

        backdrop.style.opacity =
            '0';

        setTimeout(
            () => {
                popup.classList.remove(
                    'is-open'
                );
            },
            200
        );
    };


    const showPopup = () => {

        popup.classList.add(
            'is-open'
        );

        const gsap =
            resolveGsap();


        if (gsap) {

            const tl =
                gsap.timeline();


            tl.fromTo(
                backdrop,
                {
                    opacity:0
                },
                {
                    opacity:1,
                    duration:.18,
                    ease:'power2.out'
                }
            );


            tl.fromTo(
                card,
                {
                    opacity:0,
                    y:18,
                    scale:.94
                },
                {
                    opacity:1,
                    y:0,
                    scale:1,
                    duration:.34,
                    ease:'power3.out',
                    force3D:true
                },
                '-=.10'
            );


            if (icon) {

                tl.fromTo(
                    icon,
                    {
                        opacity:0,
                        scale:.72
                    },
                    {
                        opacity:1,
                        scale:1,
                        duration:.25,
                        ease:'power3.out',
                        force3D:true
                    },
                    '-=.20'
                );

            }

        }
        else {

            backdrop.style.opacity =
                '1';

            card.style.opacity =
                '1';

            card.style.transform =
                'translate3d(0,0,0) scale(1)';

        }


        setTimeout(
            closePopup,
            1500
        );
    };


    backdrop.addEventListener(
        'click',
        closePopup
    );


    document.addEventListener(
        'keydown',
        event => {

            if (
                event.key ===
                'Escape'
            ) {
                closePopup();
            }

        }
    );


    requestAnimationFrame(
        () => {
            requestAnimationFrame(
                showPopup
            );
        }
    );

})();
</script>

@endif

@endsection