@extends('layouts.blogging')


@section('blogging-main')

@php

    /*
    |--------------------------------------------------------------------------
    | HELPER GAMBAR KOMUNITAS
    |--------------------------------------------------------------------------
    |
    | Mencari gambar dari berbagai kemungkinan nama kolom:
    |
    | image
    | image_path
    | community_image
    | community_image_path
    | cover_image
    | cover
    | banner_image
    | banner
    | photo
    | foto
    | picture
    | thumbnail
    | logo
    |
    | Jika nama kolom tidak ada di daftar, semua atribut model juga discan.
    |
    */

    $resolveCommunityImage = function ($community) {

        $attributes =
            $community->getAttributes();


        /*
        |--------------------------------------------------------------------------
        | PRIORITAS NAMA KOLOM
        |--------------------------------------------------------------------------
        */

        $possibleColumns = [
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


        $image = null;


        foreach ($possibleColumns as $column) {

            if (
                array_key_exists(
                    $column,
                    $attributes
                )
                &&
                !empty(
                    $attributes[$column]
                )
            ) {

                $image =
                    $attributes[$column];

                break;
            }
        }



        /*
        |--------------------------------------------------------------------------
        | JIKA BELUM KETEMU
        |--------------------------------------------------------------------------
        |
        | Scan seluruh atribut Community.
        |
        */

        if (!$image) {

            foreach (
                $attributes
                as $attributeName => $attributeValue
            ) {

                if (
                    empty($attributeValue)
                    ||
                    !is_string($attributeValue)
                ) {

                    continue;
                }


                $looksLikeImageColumn =
                    preg_match(
                        '/image|photo|foto|picture|cover|banner|thumbnail|logo/i',
                        $attributeName
                    );


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

                    $image =
                        $attributeValue;

                    break;
                }
            }
        }



        /*
        |--------------------------------------------------------------------------
        | TIDAK ADA GAMBAR
        |--------------------------------------------------------------------------
        */

        if (!$image) {

            return null;
        }



        /*
        |--------------------------------------------------------------------------
        | NORMALISASI
        |--------------------------------------------------------------------------
        */

        $image =
            trim(
                $image
            );


        /*
        |--------------------------------------------------------------------------
        | URL ONLINE
        |--------------------------------------------------------------------------
        */

        if (
            filter_var(
                $image,
                FILTER_VALIDATE_URL
            )
        ) {

            return $image;
        }



        /*
        |--------------------------------------------------------------------------
        | HAPUS / AWAL
        |--------------------------------------------------------------------------
        */

        $image =
            ltrim(
                $image,
                '/'
            );



        /*
        |--------------------------------------------------------------------------
        | public/storage/...
        |--------------------------------------------------------------------------
        */

        if (
            \Illuminate\Support\Str::startsWith(
                $image,
                'public/storage/'
            )
        ) {

            return asset(
                \Illuminate\Support\Str::after(
                    $image,
                    'public/'
                )
            );
        }



        /*
        |--------------------------------------------------------------------------
        | storage/...
        |--------------------------------------------------------------------------
        */

        if (
            \Illuminate\Support\Str::startsWith(
                $image,
                'storage/'
            )
        ) {

            return asset(
                $image
            );
        }



        /*
        |--------------------------------------------------------------------------
        | public/...
        |--------------------------------------------------------------------------
        */

        if (
            \Illuminate\Support\Str::startsWith(
                $image,
                'public/'
            )
        ) {

            return asset(
                'storage/' .
                \Illuminate\Support\Str::after(
                    $image,
                    'public/'
                )
            );
        }



        /*
        |--------------------------------------------------------------------------
        | FILE LANGSUNG DI PUBLIC
        |--------------------------------------------------------------------------
        */

        if (
            \Illuminate\Support\Str::startsWith(
                $image,
                [
                    'img/',
                    'images/',
                    'assets/',
                    'uploads/',
                ]
            )
        ) {

            return asset(
                $image
            );
        }



        /*
        |--------------------------------------------------------------------------
        | DEFAULT: STORAGE
        |--------------------------------------------------------------------------
        */

        return asset(
            'storage/' .
            $image
        );
    };



    /*
    |--------------------------------------------------------------------------
    | COLLECTION UNTUK SIDEBAR
    |--------------------------------------------------------------------------
    */

    $communityCollection =
        $communities instanceof
        \Illuminate\Pagination\AbstractPaginator

            ? $communities
                ->getCollection()

            : collect(
                $communities
            );


    $latestCommunities =
        $communityCollection
            ->take(5);

@endphp



{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<div class="mb-6">

    <div class="flex items-start justify-between gap-4">

        <div class="min-w-0">

            <div class="flex items-center gap-2 mb-2">

                <span
                    class="
                        w-7
                        h-[3px]
                        rounded-full
                        bg-orange-500
                    "
                ></span>


                <span
                    class="
                        text-[11px]
                        uppercase
                        tracking-[0.16em]
                        font-bold
                        text-orange-600
                    "
                >
                    Baca Dulu
                </span>

            </div>


            <h1
                class="
                    text-2xl
                    font-extrabold
                    text-slate-900
                "
            >
                Komunitas
            </h1>


            <p
                class="
                    text-sm
                    text-slate-500
                    mt-1
                    max-w-xl
                    leading-relaxed
                "
            >
                Temukan ruang untuk berdiskusi, berbagi pengalaman, dan bertemu dengan orang-orang yang memiliki minat serupa.
            </p>

        </div>



        {{-- ================================================= --}}
        {{-- CREATE COMMUNITY --}}
        {{-- ================================================= --}}

        @auth

            <a
                href="{{ route('community.create') }}"
                class="
                    hidden
                    sm:inline-flex
                    items-center
                    gap-2
                    px-4
                    py-2.5
                    rounded-lg
                    bg-orange-600
                    hover:bg-orange-700
                    text-white
                    text-sm
                    font-semibold
                    transition
                    shrink-0
                "
            >

                <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4v16m8-8H4"
                    />
                </svg>

                Buat Komunitas

            </a>

        @endauth

    </div>



    {{-- MOBILE BUTTON --}}
    @auth

        <a
            href="{{ route('community.create') }}"
            class="
                sm:hidden
                mt-4
                w-full
                inline-flex
                items-center
                justify-center
                gap-2
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

            <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 4v16m8-8H4"
                />
            </svg>

            Buat Komunitas

        </a>

    @endauth

</div>



{{-- ========================================================= --}}
{{-- SUCCESS --}}
{{-- ========================================================= --}}

@if(session('success'))

    <div
        class="
            mb-5
            rounded-xl
            border
            border-green-200
            bg-green-50
            px-4
            py-3
            text-sm
            text-green-700
        "
    >
        {{ session('success') }}
    </div>

@endif



{{-- ========================================================= --}}
{{-- DAFTAR KOMUNITAS --}}
{{-- ========================================================= --}}

<div class="space-y-4">

    @forelse($communities as $community)

        @php

            /*
            |--------------------------------------------------------------------------
            | DATA
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
            | GAMBAR
            |--------------------------------------------------------------------------
            */

            $communityImageUrl =
                $resolveCommunityImage(
                    $community
                );



            /*
            |--------------------------------------------------------------------------
            | MEMBER COUNT
            |--------------------------------------------------------------------------
            */

            $memberCount =
                $community->members_count
                ?? null;


            if (
                $memberCount === null
                &&
                method_exists(
                    $community,
                    'members'
                )
            ) {

                try {

                    $memberCount =
                        $community
                            ->members()
                            ->count();

                } catch (\Throwable $e) {

                    $memberCount =
                        null;
                }
            }

        @endphp



        <article
            class="
                bg-white
                rounded-xl
                border
                border-slate-200
                shadow-sm
                overflow-hidden
                hover:border-orange-200
                hover:shadow-md
                transition
            "
        >


            {{-- ================================================= --}}
            {{-- GAMBAR KOMUNITAS --}}
            {{-- ================================================= --}}

            @if($communityImageUrl)

                <a
                    href="{{ route(
                        'community.show',
                        $community
                    ) }}"
                    class="
                        block
                        overflow-hidden
                        bg-slate-100
                    "
                >

                    <img
                        src="{{ $communityImageUrl }}"
                        alt="{{ $communityName }}"
                        class="
                            w-full
                            h-56
                            md:h-64
                            object-cover
                            transition
                            duration-300
                            hover:scale-[1.01]
                        "
                        loading="lazy"
                    >

                </a>


            @else

                {{-- ================================================= --}}
                {{-- FALLBACK JIKA BENAR-BENAR TIDAK ADA GAMBAR --}}
                {{-- ================================================= --}}

                <a
                    href="{{ route(
                        'community.show',
                        $community
                    ) }}"
                    class="
                        h-44
                        bg-slate-50
                        flex
                        items-center
                        justify-center
                        border-b
                        border-slate-100
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


                        <p
                            class="
                                text-xs
                                text-slate-400
                                mt-3
                            "
                        >
                            Baca Dulu Komunitas
                        </p>

                    </div>

                </a>

            @endif



            {{-- ================================================= --}}
            {{-- CONTENT --}}
            {{-- ================================================= --}}

            <div class="p-5">


                {{-- ================================================= --}}
                {{-- META --}}
                {{-- ================================================= --}}

                <div
                    class="
                        flex
                        flex-wrap
                        items-center
                        gap-2
                        mb-3
                    "
                >

                    <span
                        class="
                            inline-flex
                            items-center
                            rounded-full
                            border
                            border-orange-100
                            bg-orange-50
                            px-2.5
                            py-1
                            text-xs
                            font-semibold
                            text-orange-700
                        "
                    >
                        {{ $communityCategory }}
                    </span>



                    @if($memberCount !== null)

                        <span
                            class="
                                inline-flex
                                items-center
                                gap-1.5
                                text-xs
                                text-slate-400
                            "
                        >

                            <svg
                                class="w-3.5 h-3.5"
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

                            {{ $memberCount }} anggota

                        </span>

                    @endif

                </div>



                {{-- ================================================= --}}
                {{-- TITLE --}}
                {{-- ================================================= --}}

                <a
                    href="{{ route(
                        'community.show',
                        $community
                    ) }}"
                    class="
                        group
                        block
                    "
                >

                    <h2
                        class="
                            text-lg
                            md:text-xl
                            font-bold
                            text-slate-900
                            leading-snug
                            group-hover:text-orange-700
                            transition
                            break-words
                        "
                    >
                        {{ $communityName }}
                    </h2>

                </a>



                {{-- ================================================= --}}
                {{-- DESCRIPTION --}}
                {{-- ================================================= --}}

                @if($communityDescription)

                    <p
                        class="
                            mt-2
                            text-sm
                            text-slate-600
                            leading-relaxed
                            line-clamp-3
                        "
                    >

                        {{ \Illuminate\Support\Str::limit(
                            strip_tags(
                                $communityDescription
                            ),
                            180
                        ) }}

                    </p>

                @endif



                {{-- ================================================= --}}
                {{-- LOCATION --}}
                {{-- ================================================= --}}

                @if($communityLocation)

                    <div
                        class="
                            mt-4
                            inline-flex
                            items-center
                            gap-2
                            text-xs
                            text-slate-500
                        "
                    >

                        <svg
                            class="w-4 h-4 text-slate-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>

                        {{ $communityLocation }}

                    </div>

                @endif



                {{-- ================================================= --}}
                {{-- FOOTER --}}
                {{-- ================================================= --}}

                <div
                    class="
                        mt-5
                        pt-4
                        border-t
                        border-slate-100
                        flex
                        items-center
                        justify-between
                        gap-3
                    "
                >

                    <div
                        class="
                            flex
                            items-center
                            gap-2
                        "
                    >

                        <span
                            class="
                                w-2
                                h-2
                                rounded-full
                                bg-orange-500
                            "
                        ></span>


                        <span
                            class="
                                text-xs
                                text-slate-400
                            "
                        >
                            Baca Dulu Komunitas
                        </span>

                    </div>


                    <a
                        href="{{ route(
                            'community.show',
                            $community
                        ) }}"
                        class="
                            text-sm
                            font-semibold
                            text-orange-600
                            hover:text-orange-700
                            transition
                            whitespace-nowrap
                        "
                    >
                        Lihat Komunitas →
                    </a>

                </div>

            </div>

        </article>


    @empty

        {{-- ================================================= --}}
        {{-- EMPTY --}}
        {{-- ================================================= --}}

        <div
            class="
                bg-white
                border
                border-slate-200
                rounded-xl
                px-6
                py-16
                text-center
            "
        >

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


            <h3
                class="
                    mt-4
                    font-semibold
                    text-slate-800
                "
            >
                Belum ada komunitas
            </h3>


            <p
                class="
                    mt-1
                    text-sm
                    text-slate-400
                "
            >
                Komunitas yang telah disetujui akan tampil di sini.
            </p>


            @auth

                <a
                    href="{{ route('community.create') }}"
                    class="
                        mt-5
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
                    Buat Komunitas
                </a>

            @endauth

        </div>

    @endforelse

</div>



{{-- ========================================================= --}}
{{-- PAGINATION --}}
{{-- ========================================================= --}}

@if(
    $communities instanceof
        \Illuminate\Pagination\AbstractPaginator
    &&
    $communities->hasPages()
)

    <div class="mt-6">

        {{ $communities->links() }}

    </div>

@endif

@endsection



{{-- ========================================================= --}}
{{-- SIDEBAR KANAN --}}
{{-- ========================================================= --}}

@section('blogging-right')


{{-- ========================================================= --}}
{{-- KOMUNITAS TERBARU --}}
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

    <div
        class="
            flex
            items-center
            gap-2
            mb-4
        "
    >

        <span
            class="
                w-1
                h-5
                rounded-full
                bg-orange-500
            "
        ></span>


        <h3
            class="
                text-base
                font-bold
                text-slate-900
            "
        >
            Komunitas Terbaru
        </h3>

    </div>


    <div class="space-y-4">

        @forelse(
            $latestCommunities
            as $latestCommunity
        )

            @php

                $latestName =
                    $latestCommunity->name
                    ?? $latestCommunity->title
                    ?? 'Komunitas';


                $latestCategory =
                    $latestCommunity->category
                    ?? $latestCommunity->type
                    ?? 'Komunitas';

            @endphp


            <a
                href="{{ route(
                    'community.show',
                    $latestCommunity
                ) }}"
                class="
                    flex
                    gap-3
                    group
                    min-w-0
                "
            >

                <span
                    class="
                        w-6
                        shrink-0
                        text-lg
                        font-extrabold
                        text-slate-200
                        group-hover:text-orange-300
                        transition
                    "
                >
                    {{ $loop->iteration }}
                </span>


                <div class="min-w-0">

                    <p
                        class="
                            text-sm
                            font-semibold
                            text-slate-800
                            leading-snug
                            line-clamp-2
                            group-hover:text-orange-700
                            transition
                        "
                    >
                        {{ $latestName }}
                    </p>


                    <p
                        class="
                            text-xs
                            text-slate-400
                            mt-1
                        "
                    >
                        {{ $latestCategory }}
                    </p>

                </div>

            </a>


        @empty

            <p class="text-sm text-slate-400">
                Belum ada komunitas terbaru.
            </p>

        @endforelse

    </div>

</div>



{{-- ========================================================= --}}
{{-- BACA DULU BRAND --}}
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


    <h4
        class="
            text-base
            font-bold
            text-white
            mt-2
        "
    >
        Bertemu karena minat yang sama.
    </h4>


    <p
        class="
            text-xs
            text-slate-300
            leading-relaxed
            mt-2
        "
    >
        Ruang sederhana untuk berbagi pengetahuan, pengalaman, dan percakapan yang bermanfaat.
    </p>

</div>



{{-- ========================================================= --}}
{{-- GUEST --}}
{{-- ========================================================= --}}

@guest

    <div
        class="
            bg-white
            rounded-xl
            border
            border-slate-200
            p-5
        "
    >

        <h4
            class="
                text-sm
                font-bold
                text-slate-900
            "
        >
            Ingin bergabung?
        </h4>


        <p
            class="
                text-xs
                text-slate-500
                leading-relaxed
                mt-2
            "
        >
            Masuk ke akun Baca Dulu untuk bergabung atau membuat komunitas baru.
        </p>


        <a
            href="{{ route('login') }}"
            class="
                mt-4
                w-full
                inline-flex
                items-center
                justify-center
                px-4
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

@endguest

@endsection