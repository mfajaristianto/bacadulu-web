@extends('layouts.blogging')


@section('blogging-main')

@php

    /*
    |--------------------------------------------------------------------------
    | DATA DASAR
    |--------------------------------------------------------------------------
    */

    $communityName =
        $community->name
        ?? $community->title
        ?? 'Komunitas';


    $communityDescription =
        $community->description
        ?? $community->about
        ?? '';


    $communityCategory =
        $community->category
        ?? $community->type
        ?? 'Komunitas';


    $communityLocation =
        $community->location
        ?? $community->city
        ?? null;



    /*
    |--------------------------------------------------------------------------
    | DETEKSI GAMBAR OTOMATIS
    |--------------------------------------------------------------------------
    |
    | Tidak lagi bergantung hanya pada:
    |
    | image
    | cover_image
    | banner_image
    |
    | Sistem akan mencari atribut model yang:
    |
    | - namanya mengandung image
    | - photo
    | - foto
    | - picture
    | - cover
    | - banner
    | - thumbnail
    | - logo
    |
    | atau nilainya berakhiran jpg/jpeg/png/webp/gif.
    |
    |--------------------------------------------------------------------------
    */

    $communityImage = null;

    $communityAttributes =
        $community->getAttributes();


    /*
    |--------------------------------------------------------------------------
    | PRIORITAS KOLOM UMUM
    |--------------------------------------------------------------------------
    */

    $priorityImageColumns = [
        'image',
        'image_path',
        'community_image',
        'community_image_path',
        'cover_image',
        'cover',
        'banner_image',
        'banner',
        'photo',
        'photo_path',
        'foto',
        'foto_path',
        'picture',
        'profile_picture',
        'thumbnail',
        'logo',
    ];


    foreach ($priorityImageColumns as $column) {

        if (
            array_key_exists(
                $column,
                $communityAttributes
            )
            &&
            !empty(
                $communityAttributes[$column]
            )
        ) {

            $communityImage =
                $communityAttributes[$column];

            break;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | JIKA BELUM KETEMU
    |--------------------------------------------------------------------------
    |
    | Scan semua kolom.
    |
    */

    if (!$communityImage) {

        foreach (
            $communityAttributes
            as $attributeName => $attributeValue
        ) {

            if (
                empty($attributeValue)
                ||
                !is_string($attributeValue)
            ) {

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Nama kolom terlihat seperti gambar
            |--------------------------------------------------------------------------
            */

            $looksLikeImageColumn =
                preg_match(
                    '/image|photo|foto|picture|cover|banner|thumbnail|logo/i',
                    $attributeName
                );


            /*
            |--------------------------------------------------------------------------
            | Nilai terlihat seperti file gambar
            |--------------------------------------------------------------------------
            */

            $looksLikeImageFile =
                preg_match(
                    '/\.(jpg|jpeg|png|webp|gif)(\?.*)?$/i',
                    $attributeValue
                );


            if (
                $looksLikeImageColumn
                ||
                $looksLikeImageFile
            ) {

                $communityImage =
                    $attributeValue;

                break;
            }
        }
    }



    /*
    |--------------------------------------------------------------------------
    | BUAT URL GAMBAR
    |--------------------------------------------------------------------------
    */

    $communityImageUrl = null;


    if ($communityImage) {

        $communityImage =
            trim(
                $communityImage
            );


        /*
        |--------------------------------------------------------------------------
        | URL ONLINE
        |--------------------------------------------------------------------------
        */

        if (
            filter_var(
                $communityImage,
                FILTER_VALIDATE_URL
            )
        ) {

            $communityImageUrl =
                $communityImage;


        } else {

            /*
            |--------------------------------------------------------------------------
            | NORMALISASI PATH
            |--------------------------------------------------------------------------
            */

            $communityImage =
                ltrim(
                    $communityImage,
                    '/'
                );


            /*
            |--------------------------------------------------------------------------
            | public/storage/...
            |--------------------------------------------------------------------------
            */

            if (
                \Illuminate\Support\Str::startsWith(
                    $communityImage,
                    'public/storage/'
                )
            ) {

                $communityImageUrl =
                    asset(
                        \Illuminate\Support\Str::after(
                            $communityImage,
                            'public/'
                        )
                    );


            /*
            |--------------------------------------------------------------------------
            | storage/...
            |--------------------------------------------------------------------------
            */

            } elseif (
                \Illuminate\Support\Str::startsWith(
                    $communityImage,
                    'storage/'
                )
            ) {

                $communityImageUrl =
                    asset(
                        $communityImage
                    );


            /*
            |--------------------------------------------------------------------------
            | public/...
            |--------------------------------------------------------------------------
            */

            } elseif (
                \Illuminate\Support\Str::startsWith(
                    $communityImage,
                    'public/'
                )
            ) {

                $communityImageUrl =
                    asset(
                        'storage/' .
                        \Illuminate\Support\Str::after(
                            $communityImage,
                            'public/'
                        )
                    );


            /*
            |--------------------------------------------------------------------------
            | FILE YANG LANGSUNG ADA DI PUBLIC
            |--------------------------------------------------------------------------
            */

            } elseif (
                \Illuminate\Support\Str::startsWith(
                    $communityImage,
                    [
                        'img/',
                        'images/',
                        'assets/',
                        'uploads/',
                    ]
                )
            ) {

                $communityImageUrl =
                    asset(
                        $communityImage
                    );


            /*
            |--------------------------------------------------------------------------
            | DEFAULT STORAGE
            |--------------------------------------------------------------------------
            */

            } else {

                $communityImageUrl =
                    asset(
                        'storage/' .
                        $communityImage
                    );
            }
        }
    }



    /*
    |--------------------------------------------------------------------------
    | OWNER
    |--------------------------------------------------------------------------
    */

    $ownerId =
        $community->user_id
        ?? $community->created_by
        ?? null;


    $isOwner =
        auth()->check()
        &&
        $ownerId
        &&
        (int) auth()->id()
        ===
        (int) $ownerId;



    /*
    |--------------------------------------------------------------------------
    | MEMBER
    |--------------------------------------------------------------------------
    */

    $memberCount =
        $community->members_count
        ?? null;


    $isMember =
        false;


    if (
        method_exists(
            $community,
            'members'
        )
    ) {

        try {

            if ($memberCount === null) {

                $memberCount =
                    $community
                        ->members()
                        ->count();
            }


            if (
                auth()->check()
            ) {

                $isMember =
                    $community
                        ->members()
                        ->where(
                            'user_id',
                            auth()->id()
                        )
                        ->exists();
            }

        } catch (\Throwable $e) {

            $isMember = false;
        }
    }

@endphp



{{-- ========================================================= --}}
{{-- BREADCRUMB --}}
{{-- ========================================================= --}}

<div class="flex items-center gap-2 text-xs text-slate-400 mb-4">

    <a
        href="{{ route('blog.index') }}"
        class="hover:text-orange-600 transition"
    >
        Blogging
    </a>


    <span>/</span>


    <a
        href="{{ route('community.index') }}"
        class="hover:text-orange-600 transition"
    >
        Komunitas
    </a>


    <span>/</span>


    <span class="text-slate-500 truncate">
        {{ $communityName }}
    </span>

</div>



{{-- ========================================================= --}}
{{-- COMMUNITY --}}
{{-- ========================================================= --}}

<article
    class="
        bg-white
        rounded-xl
        border
        border-slate-200
        shadow-sm
        overflow-hidden
    "
>


    {{-- ===================================================== --}}
    {{-- COVER COMMUNITY --}}
    {{-- ===================================================== --}}

    @if($communityImageUrl)

        <div
            class="
                relative
                w-full
                bg-slate-100
                overflow-hidden
            "
        >

            <img
                src="{{ $communityImageUrl }}"
                alt="{{ $communityName }}"
                class="
                    w-full
                    h-[300px]
                    md:h-[360px]
                    object-cover
                "
                onerror="
                    console.error('Gambar komunitas gagal dimuat:', this.src);
                    this.closest('.community-cover-wrapper').style.display = 'none';
                "
            >

        </div>


    @else

        {{-- ================================================= --}}
        {{-- FALLBACK --}}
        {{-- ================================================= --}}

        <div
            class="
                h-48
                bg-slate-50
                border-b
                border-slate-100
                flex
                items-center
                justify-center
            "
        >

            <div class="text-center">

                <div
                    class="
                        w-12
                        h-12
                        mx-auto
                        rounded-xl
                        bg-orange-50
                        border
                        border-orange-100
                        flex
                        items-center
                        justify-center
                        text-orange-600
                    "
                >

                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H2v-2a4 4 0 014-4h3m7-4a4 4 0 11-8 0 4 4 0 018 0z"
                        />
                    </svg>

                </div>


                <p class="text-xs text-slate-400 mt-3">
                    Baca Dulu Komunitas
                </p>

            </div>

        </div>

    @endif



    {{-- ===================================================== --}}
    {{-- CONTENT --}}
    {{-- ===================================================== --}}

    <div class="p-6 md:p-8">


        {{-- ================================================= --}}
        {{-- CATEGORY --}}
        {{-- ================================================= --}}

        <div class="flex flex-wrap items-center gap-2 mb-4">

            <span
                class="
                    inline-flex
                    items-center
                    rounded-full
                    border
                    border-orange-100
                    bg-orange-50
                    px-3
                    py-1
                    text-xs
                    font-semibold
                    text-orange-700
                "
            >
                {{ $communityCategory }}
            </span>


            @if($memberCount !== null)

                <span class="text-xs text-slate-400">
                    {{ $memberCount }} anggota
                </span>

            @endif

        </div>



        {{-- ================================================= --}}
        {{-- TITLE + EDIT --}}
        {{-- ================================================= --}}

        <div class="flex items-start justify-between gap-4">

            <div class="min-w-0">

                <h1
                    class="
                        text-2xl
                        md:text-3xl
                        font-extrabold
                        text-slate-900
                        leading-tight
                        break-words
                    "
                >
                    {{ $communityName }}
                </h1>


                <div class="flex items-center gap-2 mt-3">

                    <span
                        class="
                            w-2
                            h-2
                            bg-orange-500
                            rounded-full
                        "
                    ></span>


                    <span class="text-xs text-slate-400">
                        Baca Dulu Komunitas
                    </span>

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- EDIT PEMILIK --}}
            {{-- ================================================= --}}

            @if($isOwner)

                <a
                    href="{{ route(
                        'community.edit',
                        $community
                    ) }}"
                    title="Edit Komunitas"
                    class="
                        w-9
                        h-9
                        shrink-0
                        inline-flex
                        items-center
                        justify-center
                        rounded-lg
                        border
                        border-slate-200
                        text-slate-500
                        hover:text-orange-700
                        hover:border-orange-200
                        hover:bg-orange-50
                        transition
                    "
                >

                    <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                        />
                    </svg>

                </a>

            @endif

        </div>



        {{-- ================================================= --}}
        {{-- QUICK INFO --}}
        {{-- ================================================= --}}

        <div
            class="
                grid
                grid-cols-1
                sm:grid-cols-2
                gap-3
                mt-7
            "
        >


            <div class="bg-slate-50 rounded-lg px-4 py-3">

                <div
                    class="
                        text-[10px]
                        uppercase
                        tracking-wide
                        font-semibold
                        text-slate-400
                    "
                >
                    Anggota
                </div>


                <div
                    class="
                        text-sm
                        font-semibold
                        text-slate-800
                        mt-1
                    "
                >

                    @if($memberCount !== null)

                        {{ $memberCount }} anggota

                    @else

                        Komunitas terbuka

                    @endif

                </div>

            </div>



            <div class="bg-slate-50 rounded-lg px-4 py-3">

                <div
                    class="
                        text-[10px]
                        uppercase
                        tracking-wide
                        font-semibold
                        text-slate-400
                    "
                >
                    Lokasi
                </div>


                <div
                    class="
                        text-sm
                        font-semibold
                        text-slate-800
                        mt-1
                    "
                >
                    {{ $communityLocation ?: 'Online / terbuka untuk umum' }}
                </div>

            </div>

        </div>



        {{-- ================================================= --}}
        {{-- DESCRIPTION --}}
        {{-- ================================================= --}}

        <div
            class="
                mt-8
                pt-7
                border-t
                border-slate-100
            "
        >

            <h2
                class="
                    text-lg
                    font-bold
                    text-slate-900
                "
            >
                Tentang Komunitas
            </h2>


            @if($communityDescription)

                <div
                    class="
                        mt-4
                        text-slate-700
                        leading-relaxed
                        whitespace-pre-line
                        break-words
                    "
                >{{ $communityDescription }}</div>


            @else

                <p class="mt-4 text-sm text-slate-400">
                    Belum ada deskripsi untuk komunitas ini.
                </p>

            @endif

        </div>



        {{-- ================================================= --}}
        {{-- JOIN / LEAVE --}}
        {{-- ================================================= --}}

        @unless($isOwner)

            <div
                class="
                    mt-8
                    pt-6
                    border-t
                    border-slate-100
                "
            >

                @auth


                    @if($isMember)

                        <div
                            class="
                                flex
                                flex-col
                                sm:flex-row
                                sm:items-center
                                sm:justify-between
                                gap-3
                            "
                        >

                            <div>

                                <p
                                    class="
                                        text-sm
                                        font-semibold
                                        text-slate-800
                                    "
                                >
                                    Anda sudah bergabung
                                </p>


                                <p class="text-xs text-slate-400 mt-1">
                                    Anda merupakan bagian dari komunitas ini.
                                </p>

                            </div>


                            <form
                                action="{{ route(
                                    'community.leave',
                                    $community
                                ) }}"
                                method="POST"
                            >

                                @csrf


                                <button
                                    type="submit"
                                    class="
                                        w-full
                                        sm:w-auto
                                        inline-flex
                                        items-center
                                        justify-center
                                        px-4
                                        py-2.5
                                        rounded-lg
                                        border
                                        border-slate-200
                                        text-slate-600
                                        hover:bg-slate-50
                                        text-sm
                                        font-semibold
                                        transition
                                    "
                                >
                                    Keluar dari Komunitas
                                </button>

                            </form>

                        </div>


                    @else

                        <div
                            class="
                                flex
                                flex-col
                                sm:flex-row
                                sm:items-center
                                sm:justify-between
                                gap-4
                            "
                        >

                            <div>

                                <p
                                    class="
                                        text-sm
                                        font-semibold
                                        text-slate-800
                                    "
                                >
                                    Tertarik dengan komunitas ini?
                                </p>


                                <p class="text-xs text-slate-400 mt-1">
                                    Bergabung untuk menjadi bagian dari komunitas.
                                </p>

                            </div>


                            <form
                                action="{{ route(
                                    'community.join',
                                    $community
                                ) }}"
                                method="POST"
                            >

                                @csrf


                                <button
                                    type="submit"
                                    class="
                                        w-full
                                        sm:w-auto
                                        inline-flex
                                        items-center
                                        justify-center
                                        px-5
                                        py-2.5
                                        rounded-lg
                                        bg-orange-600
                                        hover:bg-orange-700
                                        text-white
                                        text-sm
                                        font-semibold
                                        transition
                                    "
                                >
                                    Gabung Komunitas
                                </button>

                            </form>

                        </div>

                    @endif


                @else

                    <div
                        class="
                            flex
                            flex-col
                            sm:flex-row
                            sm:items-center
                            sm:justify-between
                            gap-4
                        "
                    >

                        <div>

                            <p
                                class="
                                    text-sm
                                    font-semibold
                                    text-slate-800
                                "
                            >
                                Ingin bergabung?
                            </p>


                            <p class="text-xs text-slate-400 mt-1">
                                Masuk ke akun Baca Dulu terlebih dahulu.
                            </p>

                        </div>


                        <a
                            href="{{ route('login') }}"
                            class="
                                inline-flex
                                items-center
                                justify-center
                                px-5
                                py-2.5
                                rounded-lg
                                border
                                border-orange-200
                                text-orange-700
                                hover:bg-orange-50
                                text-sm
                                font-semibold
                                transition
                            "
                        >
                            Masuk
                        </a>

                    </div>

                @endauth

            </div>

        @endunless

    </div>

</article>



{{-- ========================================================= --}}
{{-- BACK --}}
{{-- ========================================================= --}}

<div class="mt-6">

    <a
        href="{{ route('community.index') }}"
        class="
            inline-flex
            items-center
            gap-2
            text-sm
            font-semibold
            text-orange-600
            hover:text-orange-700
            transition
        "
    >
        ← Lihat Komunitas Lainnya
    </a>

</div>

@endsection



{{-- ========================================================= --}}
{{-- RIGHT SIDEBAR --}}
{{-- ========================================================= --}}

@section('blogging-right')


{{-- ========================================================= --}}
{{-- INFORMATION --}}
{{-- ========================================================= --}}

<div
    class="
        bg-white
        rounded-xl
        border
        border-slate-200
        shadow-sm
        p-5
    "
>

    <div class="flex items-center gap-2">

        <span
            class="
                w-1
                h-5
                rounded-full
                bg-orange-500
            "
        ></span>


        <h3 class="text-base font-bold text-slate-900">
            Informasi Komunitas
        </h3>

    </div>


    <div class="mt-5 space-y-5">

        <div>

            <div class="text-xs text-slate-400">
                Kategori
            </div>

            <div
                class="
                    text-sm
                    font-semibold
                    text-slate-800
                    mt-1
                "
            >
                {{ $communityCategory }}
            </div>

        </div>


        <div>

            <div class="text-xs text-slate-400">
                Anggota
            </div>


            <div
                class="
                    text-sm
                    font-semibold
                    text-slate-800
                    mt-1
                "
            >

                @if($memberCount !== null)

                    {{ $memberCount }} orang

                @else

                    -

                @endif

            </div>

        </div>


        <div>

            <div class="text-xs text-slate-400">
                Lokasi
            </div>

            <div
                class="
                    text-sm
                    font-semibold
                    text-slate-800
                    mt-1
                "
            >
                {{ $communityLocation ?: 'Terbuka / Online' }}
            </div>

        </div>


        @if($community->created_at)

            <div>

                <div class="text-xs text-slate-400">
                    Dibuat
                </div>


                <div
                    class="
                        text-sm
                        font-semibold
                        text-slate-800
                        mt-1
                    "
                >

                    {{ $community
                        ->created_at
                        ->copy()
                        ->timezone('Asia/Jakarta')
                        ->translatedFormat('d F Y')
                    }}

                </div>

            </div>

        @endif

    </div>

</div>



{{-- ========================================================= --}}
{{-- OWNER --}}
{{-- ========================================================= --}}

@if($isOwner)

    <div
        class="
            bg-white
            rounded-xl
            border
            border-orange-100
            p-5
        "
    >

        <div
            class="
                text-[10px]
                uppercase
                tracking-[0.16em]
                font-bold
                text-orange-600
            "
        >
            Komunitas Anda
        </div>


        <p
            class="
                text-sm
                font-semibold
                text-slate-800
                mt-2
            "
        >
            Anda adalah pembuat komunitas ini.
        </p>


        <p
            class="
                text-xs
                text-slate-400
                mt-1
                leading-relaxed
            "
        >
            Informasi komunitas dapat diperbarui melalui halaman edit user.
        </p>


        <a
            href="{{ route(
                'community.edit',
                $community
            ) }}"
            class="
                mt-4
                w-full
                inline-flex
                items-center
                justify-center
                px-4
                py-2.5
                rounded-lg
                bg-orange-600
                hover:bg-orange-700
                text-white
                text-sm
                font-semibold
                transition
            "
        >
            Edit Komunitas
        </a>

    </div>

@endif



{{-- ========================================================= --}}
{{-- BRAND --}}
{{-- ========================================================= --}}

<div
    class="
        bg-[#2b2f3a]
        rounded-xl
        p-5
    "
>

    <div
        class="
            text-[10px]
            uppercase
            tracking-[0.18em]
            font-bold
            text-orange-400
        "
    >
        Baca Dulu
    </div>


    <h4 class="text-base font-bold text-white mt-2">
        Ruang untuk tumbuh bersama.
    </h4>


    <p
        class="
            text-xs
            text-slate-300
            leading-relaxed
            mt-2
        "
    >
        Diskusi yang baik dimulai dari orang-orang yang mau berbagi dan mendengarkan.
    </p>

</div>

@endsection