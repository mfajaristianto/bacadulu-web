@extends('layouts.app')

@section('content')

<style>
.bd-blog-page{
    min-height:100vh;
    background:#f8f9fb;
}
.bd-blog-layout{
    position:relative;
    align-items:stretch;
}
.bd-blog-left-rail{
    position:relative;
    min-width:0;
}
.bd-blog-left-card{
    width:100%;
}
.bd-blog-left-card.is-fixed{
    position:fixed;
    z-index:40;
}
.bd-blog-left-card.is-bottom{
    position:absolute;
    top:auto!important;
    bottom:0;
    left:0!important;
}
.bd-blog-right-inner{
    position:sticky;
    top:32px;
}
@media(max-width:1023px){
    .bd-blog-left-card,
    .bd-blog-left-card.is-fixed,
    .bd-blog-left-card.is-bottom{
        position:relative!important;
        top:auto!important;
        bottom:auto!important;
        left:auto!important;
        width:100%!important;
    }
    .bd-blog-right-inner{
        position:relative;
        top:auto;
    }
}
</style>

<div class="bd-blog-page">
    <div class="max-w-7xl mx-auto px-4 py-8">

        <div
            id="bdBlogLayout"
            class="bd-blog-layout grid grid-cols-1 lg:grid-cols-4 gap-6"
        >

            {{-- ================================================= --}}
            {{-- SIDEBAR KIRI --}}
            {{-- ================================================= --}}

            <aside
                id="bdBlogLeftRail"
                class="bd-blog-left-rail lg:col-span-1"
            >

                <div
                    id="bdBlogLeftCard"
                    class="bd-blog-left-card"
                >

                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">

                        {{-- MENU UTAMA --}}
                        <div class="space-y-1">

                            {{-- HOME --}}
                            <a
                                href="{{ route('blog.index') }}"
                                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold transition
                                {{ request()->routeIs('blog.index')
                                    ? 'bg-orange-50 text-orange-700'
                                    : 'text-slate-600 hover:bg-orange-50 hover:text-orange-700'
                                }}"
                            >
                                <svg
                                    class="w-5 h-5 shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 12l9-9 9 9M5 10v10h5v-6h4v6h5V10"
                                    />
                                </svg>

                                <span>Home</span>
                            </a>


                            {{-- EVENT --}}
                            <a
                                href="{{ route('event.index') }}"
                                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold transition
                                {{ request()->routeIs('event.*')
                                    ? 'bg-orange-50 text-orange-700'
                                    : 'text-slate-600 hover:bg-orange-50 hover:text-orange-700'
                                }}"
                            >
                                <svg
                                    class="w-5 h-5 shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"
                                    />
                                </svg>

                                <span>Event</span>
                            </a>


                            {{-- KOMUNITAS --}}
                            <a
                                href="{{ route('community.index') }}"
                                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold transition
                                {{ request()->routeIs('community.*')
                                    ? 'bg-orange-50 text-orange-700'
                                    : 'text-slate-600 hover:bg-orange-50 hover:text-orange-700'
                                }}"
                            >
                                <svg
                                    class="w-5 h-5 shrink-0"
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

                                <span>Komunitas</span>
                            </a>


                            {{-- ARTIKEL SAYA --}}
                            @auth
                                <a
                                    href="{{ route('blog.myPosts') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold transition
                                    {{ request()->routeIs('blog.myPosts')
                                        ? 'bg-orange-50 text-orange-700'
                                        : 'text-slate-600 hover:bg-orange-50 hover:text-orange-700'
                                    }}"
                                >
                                    <svg
                                        class="w-5 h-5 shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M8 4h8a2 2 0 012 2v14H6V6a2 2 0 012-2zm2 5h4m-4 4h4"
                                        />
                                    </svg>

                                    <span>Artikel Saya</span>
                                </a>
                            @endauth

                        </div>


                        {{-- ================================================= --}}
                        {{-- KATEGORI --}}
                        {{-- ================================================= --}}

                        <div class="border-t border-slate-100 mt-4 pt-4">

                            <div class="px-3 mb-2">
                                <div class="text-[11px] uppercase tracking-[0.16em] font-bold text-slate-400">
                                    Kategori
                                </div>
                            </div>

                            <div class="space-y-1">

                                @foreach([
                                    'Sosial',
                                    'Ekonomi',
                                    'Teknik',
                                    'Kesehatan'
                                ] as $sidebarCategory)

                                    <a
                                        href="{{ route('blog.index', [
                                            'category' => $sidebarCategory
                                        ]) }}"
                                        class="block px-4 py-2 rounded-lg text-sm font-medium transition
                                        {{ request('category') === $sidebarCategory
                                            ? 'bg-orange-50 text-orange-700'
                                            : 'text-slate-500 hover:bg-orange-50 hover:text-orange-700'
                                        }}"
                                    >
                                        {{ $sidebarCategory }}
                                    </a>

                                @endforeach

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- TOMBOL TULIS ARTIKEL --}}
                        {{-- INI YANG TADI HILANG --}}
                        {{-- ================================================= --}}

                        @auth

                            <div class="border-t border-slate-100 mt-4 pt-4">

                                <a
                                    href="{{ route('blog.create') }}"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold transition"
                                >
                                    <svg
                                        class="w-4 h-4 shrink-0"
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

                                    <span>Tulis Artikel</span>
                                </a>

                            </div>

                        @else

                            <div class="border-t border-slate-100 mt-4 pt-4">

                                <a
                                    href="{{ route('login') }}"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-orange-200 bg-orange-50 hover:bg-orange-100 text-orange-700 text-sm font-semibold transition"
                                >
                                    <svg
                                        class="w-4 h-4 shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5m5 5H3"
                                        />
                                    </svg>

                                    <span>Masuk untuk Menulis</span>
                                </a>

                            </div>

                        @endauth

                    </div>

                </div>

            </aside>


            {{-- ================================================= --}}
            {{-- KONTEN TENGAH --}}
            {{-- ================================================= --}}

            <main class="lg:col-span-2 min-w-0">
                @yield('blogging-main')
            </main>


            {{-- ================================================= --}}
            {{-- SIDEBAR KANAN --}}
            {{-- ================================================= --}}

            <aside class="lg:col-span-1">

                <div class="bd-blog-right-inner space-y-5">
                    @yield('blogging-right')
                </div>

            </aside>

        </div>

    </div>
</div>


{{-- ========================================================= --}}
{{-- SIDEBAR FOLLOW SCRIPT --}}
{{-- JANGAN DIUBAH - INI YANG SUDAH PAS --}}
{{-- ========================================================= --}}

@push('scripts')

<script>
(() => {

    const rail =
        document.getElementById(
            'bdBlogLeftRail'
        );

    const card =
        document.getElementById(
            'bdBlogLeftCard'
        );

    const layout =
        document.getElementById(
            'bdBlogLayout'
        );


    if (
        !rail ||
        !card ||
        !layout
    ) {
        return;
    }


    const desktop =
        window.matchMedia(
            '(min-width:1024px)'
        );


    let ticking = false;


    /*
    |--------------------------------------------------------------------------
    | HITUNG POSISI SIDEBAR
    |--------------------------------------------------------------------------
    |
    | Sidebar dibuat balance antara bagian atas
    | dan bawah viewport.
    |
    */

    function getBalancedTop() {

        const cardHeight =
            card.offsetHeight;


        const availableSpace =
            window.innerHeight -
            cardHeight;


        const centeredTop =
            availableSpace / 2;


        return Math.max(
            28,
            Math.min(
                72,
                centeredTop
            )
        );

    }


    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    function resetSidebar() {

        card.classList.remove(
            'is-fixed',
            'is-bottom'
        );


        card.style.top = '';
        card.style.left = '';
        card.style.width = '';


        rail.style.minHeight = '';

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE POSISI
    |--------------------------------------------------------------------------
    */

    function updateSidebar() {

        ticking = false;


        if (!desktop.matches) {

            resetSidebar();

            return;

        }


        resetSidebar();


        const scrollY =
            window.scrollY;


        const railRect =
            rail.getBoundingClientRect();


        const layoutRect =
            layout.getBoundingClientRect();


        const railTop =
            railRect.top +
            scrollY;


        const layoutBottom =
            layoutRect.bottom +
            scrollY;


        const cardHeight =
            card.offsetHeight;


        const railWidth =
            rail.offsetWidth;


        const balancedTop =
            getBalancedTop();


        /*
        |--------------------------------------------------------------------------
        | JAGA RUANG SIDEBAR
        |--------------------------------------------------------------------------
        */

        rail.style.minHeight =
            `${cardHeight}px`;


        /*
        |--------------------------------------------------------------------------
        | MULAI FOLLOW
        |--------------------------------------------------------------------------
        */

        const startAt =
            railTop -
            balancedTop;


        /*
        |--------------------------------------------------------------------------
        | BERHENTI SEBELUM AKHIR AREA BLOG
        |--------------------------------------------------------------------------
        */

        const stopAt =
            layoutBottom -
            cardHeight -
            balancedTop;


        /*
        |--------------------------------------------------------------------------
        | POSISI NORMAL
        |--------------------------------------------------------------------------
        */

        if (
            scrollY <= startAt
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | SUDAH SAMPAI BAWAH
        |--------------------------------------------------------------------------
        */

        if (
            scrollY >= stopAt
        ) {

            card.classList.add(
                'is-bottom'
            );


            card.style.width =
                `${railWidth}px`;


            return;

        }


        /*
        |--------------------------------------------------------------------------
        | FOLLOW SCROLL
        |--------------------------------------------------------------------------
        */

        const freshRailRect =
            rail.getBoundingClientRect();


        card.classList.add(
            'is-fixed'
        );


        card.style.top =
            `${balancedTop}px`;


        card.style.left =
            `${freshRailRect.left}px`;


        card.style.width =
            `${railWidth}px`;

    }


    /*
    |--------------------------------------------------------------------------
    | REQUEST UPDATE
    |--------------------------------------------------------------------------
    */

    function requestUpdate() {

        if (ticking) {
            return;
        }


        ticking = true;


        requestAnimationFrame(
            updateSidebar
        );

    }


    window.addEventListener(
        'scroll',
        requestUpdate,
        {
            passive:true
        }
    );


    window.addEventListener(
        'resize',
        requestUpdate
    );


    window.addEventListener(
        'load',
        requestUpdate
    );


    if (
        desktop.addEventListener
    ) {

        desktop.addEventListener(
            'change',
            requestUpdate
        );

    }


    requestUpdate();

})();
</script>

@endpush

@endsection