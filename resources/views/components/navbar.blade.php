<nav
    id="main-navbar"
    class="
        sticky
        top-0
        z-50
        w-full
        bg-white
        border-b
        border-gray-100
        shadow-sm
    "
>

    {{-- =====================================================
        NAVBAR CONTAINER
    ====================================================== --}}

    <div class="w-full max-w-[1600px] mx-auto px-5 sm:px-6 lg:px-8 xl:px-10">

        <div class="flex items-center h-20 gap-5 xl:gap-8">


            {{-- =================================================
                1. LOGO
            ================================================== --}}

            <div class="flex-shrink-0">

                <a
                    href="{{ route('home') }}"
                    class="flex items-center !no-underline"
                >

                    <img
                        src="{{ asset('img/images.jpg') }}"
                        alt="Logo Baca Dulu"
                        class="
                            h-14
                            w-auto
                            max-w-[150px]
                            object-contain
                        "
                    >

                </a>

            </div>


            {{-- =================================================
                2. MENU DESKTOP
            ================================================== --}}

            <div
                class="
                    hidden
                    lg:flex
                    flex-1
                    items-center
                    justify-center
                    gap-1
                    xl:gap-2
                    text-sm
                    font-bold
                    min-w-0
                "
            >


                {{-- HOME --}}

                <a
                    href="{{ route('home') }}"
                    class="
                        px-3
                        xl:px-4
                        py-2.5
                        rounded-lg
                        whitespace-nowrap
                        transition
                        duration-200
                        !no-underline

                        {{ request()->is('/')
                            ? 'bg-[#1e1e50]/10 !text-[#1e1e50]'
                            : '!text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50]'
                        }}
                    "
                >
                    Home
                </a>



                {{-- =================================================
                    TENTANG KAMI
                ================================================== --}}

                <div class="relative group flex-shrink-0">

                    <button
                        type="button"
                        class="
                            px-3
                            xl:px-4
                            py-2.5
                            rounded-lg
                            !text-gray-600
                            hover:bg-gray-50
                            hover:!text-[#1e1e50]
                            transition
                            duration-200
                            flex
                            items-center
                            gap-1.5
                            focus:outline-none
                            font-bold
                            whitespace-nowrap
                        "
                    >

                        <span>
                            Tentang Kami
                        </span>


                        <svg
                            class="
                                w-4
                                h-4
                                transition-transform
                                duration-200
                                group-hover:rotate-180
                            "
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            />

                        </svg>

                    </button>


                    {{-- DROPDOWN TENTANG KAMI --}}

                    <div
                        class="
                            absolute
                            left-0
                            top-full
                            pt-2
                            hidden
                            group-hover:block
                            z-[100]
                        "
                    >

                        <div
                            class="
                                bg-white
                                shadow-xl
                                rounded-xl
                                py-2
                                w-56
                                border
                                border-gray-100
                            "
                        >

                            <a
                                href="{{ route('tentang.dewan-redaksi') }}#team-bacadulu"
                                class="
                                    block
                                    px-4
                                    py-2.5
                                    text-sm
                                    !text-gray-700
                                    hover:bg-gray-50
                                    hover:!text-[#1e1e50]
                                    !no-underline
                                    font-semibold
                                "
                            >
                                Team BacaDulu
                            </a>


                            <a
                                href="{{ route('tentang.dewan-redaksi') }}#nilai-perusahaan"
                                class="
                                    block
                                    px-4
                                    py-2.5
                                    text-sm
                                    !text-gray-700
                                    hover:bg-gray-50
                                    hover:!text-[#1e1e50]
                                    !no-underline
                                    font-semibold
                                "
                            >
                                Nilai Perusahaan
                            </a>


                            <a
                                href="{{ route('tentang.dewan-redaksi') }}#visi-misi"
                                class="
                                    block
                                    px-4
                                    py-2.5
                                    text-sm
                                    !text-gray-700
                                    hover:bg-gray-50
                                    hover:!text-[#1e1e50]
                                    !no-underline
                                    font-semibold
                                "
                            >
                                Visi & Misi
                            </a>

                        </div>

                    </div>

                </div>



                {{-- =================================================
                    KATALOG BACA
                ================================================== --}}

                <div class="relative group flex-shrink-0">

                    <button
                        type="button"
                        class="
                            px-3
                            xl:px-4
                            py-2.5
                            rounded-lg
                            !text-gray-600
                            hover:bg-gray-50
                            hover:!text-[#1e1e50]
                            transition
                            duration-200
                            flex
                            items-center
                            gap-1.5
                            focus:outline-none
                            font-bold
                            whitespace-nowrap
                        "
                    >

                        <span>
                            Katalog Baca
                        </span>


                        <svg
                            class="
                                w-4
                                h-4
                                transition-transform
                                duration-200
                                group-hover:rotate-180
                            "
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            />

                        </svg>

                    </button>


                    {{-- DROPDOWN KATALOG --}}

                    <div
                        class="
                            absolute
                            left-0
                            top-full
                            pt-2
                            hidden
                            group-hover:block
                            z-[100]
                        "
                    >

                        <div
                            class="
                                bg-white
                                shadow-xl
                                rounded-xl
                                py-2
                                w-60
                                border
                                border-gray-100
                            "
                        >

                            <a
                                href="{{ route('informasi') }}"
                                class="
                                    block
                                    px-4
                                    py-2.5
                                    text-sm
                                    !text-gray-700
                                    hover:bg-gray-50
                                    hover:!text-[#1e1e50]
                                    !no-underline
                                    font-semibold
                                "
                            >
                                Baca Informasi
                            </a>


                            <a
                                href="{{ route('konsultasi') }}"
                                class="
                                    block
                                    px-4
                                    py-2.5
                                    text-sm
                                    !text-gray-700
                                    hover:bg-gray-50
                                    hover:!text-[#1e1e50]
                                    !no-underline
                                    font-semibold
                                "
                            >
                                Baca Konsultasi
                            </a>


                            <a
                                href="{{ route('jurnal') }}"
                                class="
                                    block
                                    px-4
                                    py-2.5
                                    text-sm
                                    !text-gray-700
                                    hover:bg-gray-50
                                    hover:!text-[#1e1e50]
                                    !no-underline
                                    font-semibold
                                "
                            >
                                Baca Jurnal
                            </a>


                            <a
                                href="{{ route('conference') }}"
                                class="
                                    block
                                    px-4
                                    py-2.5
                                    text-sm
                                    !text-gray-700
                                    hover:bg-gray-50
                                    hover:!text-[#1e1e50]
                                    !no-underline
                                    font-semibold
                                "
                            >
                                Baca Conference
                            </a>


                            <a
                                href="{{ route('publisher') }}"
                                class="
                                    block
                                    px-4
                                    py-2.5
                                    text-sm
                                    !text-gray-700
                                    hover:bg-gray-50
                                    hover:!text-[#1e1e50]
                                    !no-underline
                                    font-semibold
                                "
                            >
                                Baca Publisher
                            </a>

                        </div>

                    </div>

                </div>



                {{-- =================================================
                    BOOKSTORE
                ================================================== --}}

                <a
                    href="{{ route('portofolio.bookstore') }}"
                    class="
                        px-3
                        xl:px-4
                        py-2.5
                        rounded-lg
                        transition
                        duration-200
                        !no-underline
                        whitespace-nowrap

                        {{ request()->routeIs('portofolio.bookstore*')
                            ? 'bg-[#1e1e50]/10 !text-[#1e1e50]'
                            : '!text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50]'
                        }}
                    "
                >
                    Bookstore
                </a>



                {{-- =================================================
                    BLOGGING
                ================================================== --}}

                <a
                    href="{{ route('blog.index') }}"
                    class="
                        px-3
                        xl:px-4
                        py-2.5
                        rounded-lg
                        transition
                        duration-200
                        !no-underline
                        whitespace-nowrap

                        {{ request()->routeIs('blog.*')
                            ? 'bg-[#1e1e50]/10 !text-[#1e1e50]'
                            : '!text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50]'
                        }}
                    "
                >
                    Blogging
                </a>



                {{-- =================================================
                    HAKI
                ================================================== --}}

                <a
                    href="{{ route('haki.index') }}"
                    class="
                        px-3
                        xl:px-4
                        py-2.5
                        rounded-lg
                        transition
                        duration-200
                        !no-underline
                        whitespace-nowrap

                        {{ request()->routeIs('haki.*')
                            ? 'bg-[#1e1e50]/10 !text-[#1e1e50]'
                            : '!text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50]'
                        }}
                    "
                >
                    HAKI
                </a>


            </div>



            {{-- =================================================
                3. AREA KANAN DESKTOP
            ================================================== --}}

            <div
                class="
                    hidden
                    lg:flex
                    items-center
                    gap-3
                    flex-shrink-0
                "
            >


                {{-- =================================================
                    KIRIM NASKAH
                ================================================== --}}

                <a
                    href="https://wa.me/6285139461070"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        bg-[#f05a42]
                        hover:bg-[#d94f38]
                        !text-white
                        px-5
                        py-2.5
                        rounded-full
                        text-xs
                        font-bold
                        shadow-md
                        hover:shadow-lg
                        transition
                        duration-200
                        !no-underline
                        whitespace-nowrap
                    "
                >
                    Kirim Naskah
                </a>



                {{-- =================================================
                    LOGIN / PROFIL
                    HANYA DI HALAMAN BLOG
                ================================================== --}}

                @if(request()->routeIs('blog.*'))


                    @auth


                        {{-- PROFILE DROPDOWN --}}

                        <div class="relative group">


                            <button
                                type="button"
                                class="
                                    flex
                                    items-center
                                    gap-2
                                    py-1
                                    px-1
                                    rounded-full
                                    focus:outline-none
                                "
                            >


                                {{-- AVATAR --}}

                                <img
                                    src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                                    alt="{{ auth()->user()->name }}"
                                    class="
                                        w-10
                                        h-10
                                        rounded-full
                                        object-cover
                                        border
                                        border-gray-200
                                        shadow-sm
                                    "
                                >


                                {{-- USER NAME --}}

                                <span
                                    class="
                                        hidden
                                        xl:block
                                        max-w-[130px]
                                        truncate
                                        text-sm
                                        font-bold
                                        text-gray-700
                                    "
                                >
                                    {{ auth()->user()->name }}
                                </span>


                                {{-- ARROW --}}

                                <svg
                                    class="
                                        hidden
                                        xl:block
                                        w-4
                                        h-4
                                        text-gray-500
                                        transition-transform
                                        duration-200
                                        group-hover:rotate-180
                                    "
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"
                                    />

                                </svg>


                            </button>



                            {{-- PROFILE DROPDOWN --}}

                            <div
                                class="
                                    absolute
                                    right-0
                                    top-full
                                    pt-2
                                    hidden
                                    group-hover:block
                                    z-[100]
                                "
                            >

                                <div
                                    class="
                                        bg-white
                                        shadow-xl
                                        rounded-xl
                                        py-2
                                        w-52
                                        border
                                        border-gray-100
                                    "
                                >


                                    {{-- ADMIN --}}

                                    @if(auth()->user()->is_admin)

                                        <a
                                            href="{{ route('admin.dashboard') }}"
                                            class="
                                                block
                                                px-4
                                                py-2.5
                                                text-sm
                                                !text-gray-700
                                                hover:bg-gray-50
                                                hover:!text-[#1e1e50]
                                                !no-underline
                                                font-semibold
                                            "
                                        >
                                            Panel Admin
                                        </a>

                                    @endif



                                    {{-- MY POSTS --}}

                                    <a
                                        href="{{ route('blog.myPosts') }}"
                                        class="
                                            block
                                            px-4
                                            py-2.5
                                            text-sm
                                            !text-gray-700
                                            hover:bg-gray-50
                                            hover:!text-[#1e1e50]
                                            !no-underline
                                            font-semibold
                                        "
                                    >
                                        Artikel Saya
                                    </a>



                                    <div
                                        class="
                                            border-t
                                            border-gray-100
                                            my-1
                                        "
                                    ></div>



                                    {{-- LOGOUT --}}

                                    <form
                                        action="{{ route('logout') }}"
                                        method="POST"
                                    >

                                        @csrf


                                        <button
                                            type="submit"
                                            class="
                                                w-full
                                                text-left
                                                px-4
                                                py-2.5
                                                text-sm
                                                text-red-600
                                                hover:bg-red-50
                                                font-semibold
                                                cursor-pointer
                                            "
                                        >
                                            Logout
                                        </button>


                                    </form>


                                </div>

                            </div>


                        </div>


                    @else


                        {{-- LOGIN --}}

                        <a
                            href="{{ route('login') }}"
                            class="
                                inline-flex
                                items-center
                                justify-center
                                bg-[#1e1e50]
                                hover:bg-[#29296b]
                                !text-white
                                px-5
                                py-2.5
                                rounded-full
                                text-xs
                                font-bold
                                shadow-md
                                hover:shadow-lg
                                transition
                                !no-underline
                                whitespace-nowrap
                            "
                        >
                            Login
                        </a>


                    @endauth


                @endif


            </div>



            {{-- =================================================
                4. HAMBURGER MOBILE/TABLET
            ================================================== --}}

            <div class="flex lg:hidden items-center ml-auto">


                <button
                    type="button"
                    id="mobile-menu-button"
                    onclick="toggleMobileMenu()"
                    aria-expanded="false"
                    aria-controls="mobile-menu"
                    aria-label="Buka menu"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        w-11
                        h-11
                        rounded-xl
                        !text-gray-600
                        hover:bg-gray-100
                        focus:outline-none
                        transition
                    "
                >


                    <svg
                        id="hamburger-icon"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />

                    </svg>


                    <svg
                        id="close-icon"
                        class="h-6 w-6 hidden"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />

                    </svg>


                </button>


            </div>


        </div>

    </div>



    {{-- =====================================================
        MOBILE MENU
    ====================================================== --}}

    <div
        id="mobile-menu"
        class="
            hidden
            lg:hidden
            bg-white
            border-t
            border-gray-100
            shadow-lg
        "
    >


        <div
            class="
                max-h-[calc(100vh-80px)]
                overflow-y-auto
                px-5
                sm:px-6
                py-4
                space-y-2
                font-bold
                text-sm
            "
        >


            {{-- =================================================
                HOME
            ================================================== --}}

            <a
                href="{{ route('home') }}"
                class="
                    block
                    py-3
                    px-4
                    rounded-xl
                    !no-underline
                    transition

                    {{ request()->is('/')
                        ? 'bg-[#1e1e50]/10 !text-[#1e1e50]'
                        : '!text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50]'
                    }}
                "
            >
                Home
            </a>



            {{-- =================================================
                TENTANG KAMI
            ================================================== --}}

            <div
                class="
                    border-t
                    border-gray-100
                    pt-4
                    mt-2
                "
            >


                <span
                    class="
                        block
                        px-4
                        mb-2
                        text-[11px]
                        font-bold
                        tracking-wider
                        text-gray-400
                        uppercase
                    "
                >
                    Tentang Kami
                </span>


                <a
                    href="{{ route('tentang.dewan-redaksi') }}#team-bacadulu"
                    class="
                        block
                        !text-gray-600
                        hover:bg-gray-50
                        hover:!text-[#1e1e50]
                        py-2.5
                        px-6
                        rounded-lg
                        !no-underline
                    "
                >
                    Team BacaDulu
                </a>


                <a
                    href="{{ route('tentang.dewan-redaksi') }}#nilai-perusahaan"
                    class="
                        block
                        !text-gray-600
                        hover:bg-gray-50
                        hover:!text-[#1e1e50]
                        py-2.5
                        px-6
                        rounded-lg
                        !no-underline
                    "
                >
                    Nilai Perusahaan
                </a>


                <a
                    href="{{ route('tentang.dewan-redaksi') }}#visi-misi"
                    class="
                        block
                        !text-gray-600
                        hover:bg-gray-50
                        hover:!text-[#1e1e50]
                        py-2.5
                        px-6
                        rounded-lg
                        !no-underline
                    "
                >
                    Visi & Misi
                </a>


            </div>



            {{-- =================================================
                KATALOG BACA
            ================================================== --}}

            <div
                class="
                    border-t
                    border-gray-100
                    pt-4
                    mt-2
                "
            >


                <span
                    class="
                        block
                        px-4
                        mb-2
                        text-[11px]
                        font-bold
                        tracking-wider
                        text-gray-400
                        uppercase
                    "
                >
                    Katalog Baca
                </span>


                <a
                    href="{{ route('informasi') }}"
                    class="
                        block
                        !text-gray-600
                        hover:bg-gray-50
                        hover:!text-[#1e1e50]
                        py-2.5
                        px-6
                        rounded-lg
                        !no-underline
                    "
                >
                    Baca Informasi
                </a>


                <a
                    href="{{ route('konsultasi') }}"
                    class="
                        block
                        !text-gray-600
                        hover:bg-gray-50
                        hover:!text-[#1e1e50]
                        py-2.5
                        px-6
                        rounded-lg
                        !no-underline
                    "
                >
                    Baca Konsultasi
                </a>


                <a
                    href="{{ route('jurnal') }}"
                    class="
                        block
                        !text-gray-600
                        hover:bg-gray-50
                        hover:!text-[#1e1e50]
                        py-2.5
                        px-6
                        rounded-lg
                        !no-underline
                    "
                >
                    Baca Jurnal
                </a>


                <a
                    href="{{ route('conference') }}"
                    class="
                        block
                        !text-gray-600
                        hover:bg-gray-50
                        hover:!text-[#1e1e50]
                        py-2.5
                        px-6
                        rounded-lg
                        !no-underline
                    "
                >
                    Baca Conference
                </a>


                <a
                    href="{{ route('publisher') }}"
                    class="
                        block
                        !text-gray-600
                        hover:bg-gray-50
                        hover:!text-[#1e1e50]
                        py-2.5
                        px-6
                        rounded-lg
                        !no-underline
                    "
                >
                    Baca Publisher
                </a>


            </div>



            {{-- =================================================
                MAIN MENU MOBILE
            ================================================== --}}

            <div
                class="
                    border-t
                    border-gray-100
                    pt-3
                    mt-3
                    space-y-1
                "
            >


                {{-- BOOKSTORE --}}

                <a
                    href="{{ route('portofolio.bookstore') }}"
                    class="
                        block
                        py-3
                        px-4
                        rounded-xl
                        !no-underline

                        {{ request()->routeIs('portofolio.bookstore*')
                            ? 'bg-[#1e1e50]/10 !text-[#1e1e50]'
                            : '!text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50]'
                        }}
                    "
                >
                    Bookstore
                </a>



                {{-- BLOGGING --}}

                <a
                    href="{{ route('blog.index') }}"
                    class="
                        block
                        py-3
                        px-4
                        rounded-xl
                        !no-underline

                        {{ request()->routeIs('blog.*')
                            ? 'bg-[#1e1e50]/10 !text-[#1e1e50]'
                            : '!text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50]'
                        }}
                    "
                >
                    Blogging
                </a>



                {{-- HAKI --}}

                <a
                    href="{{ route('haki.index') }}"
                    class="
                        block
                        py-3
                        px-4
                        rounded-xl
                        !no-underline

                        {{ request()->routeIs('haki.*')
                            ? 'bg-[#1e1e50]/10 !text-[#1e1e50]'
                            : '!text-gray-600 hover:bg-gray-50 hover:!text-[#1e1e50]'
                        }}
                    "
                >
                    HAKI
                </a>


            </div>



            {{-- =================================================
                MOBILE ACTION
            ================================================== --}}

            <div
                class="
                    border-t
                    border-gray-100
                    pt-4
                    mt-3
                    flex
                    flex-col
                    gap-2
                    pb-2
                "
            >


                {{-- KIRIM NASKAH --}}

                <a
                    href="https://wa.me/6285139461070"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="
                        flex
                        items-center
                        justify-center
                        bg-[#f05a42]
                        hover:bg-[#d94f38]
                        !text-white
                        py-3
                        px-4
                        rounded-xl
                        text-sm
                        shadow-md
                        !no-underline
                        transition
                    "
                >
                    Kirim Naskah
                </a>



                {{-- =================================================
                    PROFILE MOBILE KHUSUS BLOG
                ================================================== --}}

                @if(request()->routeIs('blog.*'))


                    @auth


                        {{-- USER INFO --}}

                        <div
                            class="
                                flex
                                items-center
                                gap-3
                                p-3
                                rounded-xl
                                bg-gray-50
                            "
                        >

                            <img
                                src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                                alt="{{ auth()->user()->name }}"
                                class="
                                    w-10
                                    h-10
                                    rounded-full
                                    object-cover
                                    border
                                    border-gray-200
                                "
                            >


                            <div class="min-w-0">

                                <p
                                    class="
                                        text-sm
                                        font-bold
                                        text-gray-700
                                        truncate
                                    "
                                >
                                    {{ auth()->user()->name }}
                                </p>

                            </div>

                        </div>



                        {{-- ADMIN --}}

                        @if(auth()->user()->is_admin)

                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="
                                    block
                                    text-center
                                    bg-gray-100
                                    hover:bg-gray-200
                                    !text-gray-700
                                    py-3
                                    rounded-xl
                                    text-sm
                                    !no-underline
                                "
                            >
                                Panel Admin
                            </a>

                        @endif



                        {{-- MY ARTICLES --}}

                        <a
                            href="{{ route('blog.myPosts') }}"
                            class="
                                block
                                text-center
                                bg-gray-100
                                hover:bg-gray-200
                                !text-gray-700
                                py-3
                                rounded-xl
                                text-sm
                                !no-underline
                            "
                        >
                            Artikel Saya
                        </a>



                        {{-- LOGOUT --}}

                        <form
                            action="{{ route('logout') }}"
                            method="POST"
                        >

                            @csrf


                            <button
                                type="submit"
                                class="
                                    w-full
                                    bg-red-50
                                    hover:bg-red-100
                                    text-red-600
                                    text-center
                                    py-3
                                    rounded-xl
                                    text-sm
                                    font-bold
                                    cursor-pointer
                                    transition
                                "
                            >
                                Logout
                            </button>


                        </form>


                    @else


                        {{-- LOGIN --}}

                        <a
                            href="{{ route('login') }}"
                            class="
                                flex
                                items-center
                                justify-center
                                bg-[#1e1e50]
                                hover:bg-[#29296b]
                                !text-white
                                py-3
                                rounded-xl
                                text-sm
                                shadow-md
                                !no-underline
                            "
                        >
                            Login
                        </a>


                    @endauth


                @endif


            </div>


        </div>

    </div>


</nav>



{{-- ============================================================
    NAVBAR SCRIPT
============================================================ --}}

<script>

    function toggleMobileMenu() {

        const menu =
            document.getElementById('mobile-menu');

        const button =
            document.getElementById('mobile-menu-button');

        const hamburgerIcon =
            document.getElementById('hamburger-icon');

        const closeIcon =
            document.getElementById('close-icon');


        if (!menu) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Toggle Menu
        |--------------------------------------------------------------------------
        */

        menu.classList.toggle('hidden');


        const isOpen =
            !menu.classList.contains('hidden');


        /*
        |--------------------------------------------------------------------------
        | Aria
        |--------------------------------------------------------------------------
        */

        if (button) {

            button.setAttribute(
                'aria-expanded',
                isOpen ? 'true' : 'false'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Change Icon
        |--------------------------------------------------------------------------
        */

        if (hamburgerIcon) {

            hamburgerIcon.classList.toggle(
                'hidden',
                isOpen
            );

        }


        if (closeIcon) {

            closeIcon.classList.toggle(
                'hidden',
                !isOpen
            );

        }

    }



    /*
    |--------------------------------------------------------------------------
    | Close menu saat ukuran layar kembali desktop
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'resize',
        function () {

            if (window.innerWidth >= 1024) {


                const menu =
                    document.getElementById('mobile-menu');

                const button =
                    document.getElementById('mobile-menu-button');

                const hamburgerIcon =
                    document.getElementById('hamburger-icon');

                const closeIcon =
                    document.getElementById('close-icon');


                if (menu) {

                    menu.classList.add('hidden');

                }


                if (button) {

                    button.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                }


                if (hamburgerIcon) {

                    hamburgerIcon.classList.remove('hidden');

                }


                if (closeIcon) {

                    closeIcon.classList.add('hidden');

                }

            }

        }
    );



    /*
    |--------------------------------------------------------------------------
    | ESC menutup mobile menu
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key !== 'Escape') {
                return;
            }


            const menu =
                document.getElementById('mobile-menu');


            if (
                menu &&
                !menu.classList.contains('hidden')
            ) {

                toggleMobileMenu();

            }

        }
    );

</script>