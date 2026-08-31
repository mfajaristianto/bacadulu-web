@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#f8f9fb]">

    <div class="max-w-7xl mx-auto px-4 py-8">

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">


            {{-- ========================================================= --}}
            {{-- SIDEBAR KIRI --}}
            {{-- ========================================================= --}}

            <aside
                class="lg:col-span-1
                       lg:sticky
                       lg:top-24
                       lg:self-start"
            >

                <div
                    class="bg-white
                           rounded-xl
                           border border-slate-200
                           shadow-sm
                           p-4"
                >

                    {{-- ================================================= --}}
                    {{-- MENU UTAMA --}}
                    {{-- ================================================= --}}

                    <div class="space-y-1">


                        {{-- HOME BLOGGING --}}
                        <a
                            href="{{ route('blog.index') }}"
                            class="flex
                                   items-center
                                   gap-3
                                   px-4 py-2.5
                                   rounded-lg
                                   text-sm
                                   font-semibold
                                   transition
                                   {{ request()->routeIs('blog.*')
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

                            <span>
                                Home
                            </span>

                        </a>


                        {{-- EVENT --}}
                        <a
                            href="{{ route('event.index') }}"
                            class="flex
                                   items-center
                                   gap-3
                                   px-4 py-2.5
                                   rounded-lg
                                   text-sm
                                   font-semibold
                                   transition
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

                            <span>
                                Event
                            </span>

                        </a>


                        {{-- KOMUNITAS --}}
                        <a
                            href="{{ route('community.index') }}"
                            class="flex
                                   items-center
                                   gap-3
                                   px-4 py-2.5
                                   rounded-lg
                                   text-sm
                                   font-semibold
                                   transition
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

                            <span>
                                Komunitas
                            </span>

                        </a>

                    </div>


                    {{-- ================================================= --}}
                    {{-- CATEGORY BLOGGING --}}
                    {{-- ================================================= --}}

                    <div class="border-t border-slate-100 mt-4 pt-4">

                        <div class="px-3 mb-2">

                            <div
                                class="text-[11px]
                                       uppercase
                                       tracking-[0.16em]
                                       font-bold
                                       text-slate-400"
                            >
                                Kategori
                            </div>

                        </div>


                        <div class="space-y-1">

                            @foreach(
                                [
                                    'Sosial',
                                    'Ekonomi',
                                    'Teknik',
                                    'Kesehatan'
                                ] as $sidebarCategory
                            )

                                <a
                                    href="{{ route(
                                        'blog.index',
                                        [
                                            'category' => $sidebarCategory
                                        ]
                                    ) }}"
                                    class="block
                                           px-4 py-2
                                           rounded-lg
                                           text-sm
                                           font-medium
                                           text-slate-500
                                           hover:bg-orange-50
                                           hover:text-orange-700
                                           transition"
                                >
                                    {{ $sidebarCategory }}
                                </a>

                            @endforeach

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- TULIS ARTIKEL --}}
                    {{-- SELALU TAMPIL --}}
                    {{-- JIKA GUEST, MIDDLEWARE AUTH AKAN ARAHKAN KE LOGIN --}}
                    {{-- ================================================= --}}

                    <div class="border-t border-slate-100 mt-4 pt-4">

                        <a
                            href="{{ route('blog.create') }}"
                            class="w-full
                                   inline-flex
                                   items-center
                                   justify-center
                                   gap-2
                                   px-4 py-2.5
                                   bg-orange-600
                                   hover:bg-orange-700
                                   text-white
                                   text-sm
                                   font-semibold
                                   rounded-lg
                                   transition"
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

                            Tulis Artikel

                        </a>

                    </div>

                </div>

            </aside>



            {{-- ========================================================= --}}
            {{-- KONTEN TENGAH --}}
            {{-- ========================================================= --}}

            <main class="lg:col-span-2 min-w-0">

                @yield('blogging-main')

            </main>



            {{-- ========================================================= --}}
            {{-- SIDEBAR KANAN --}}
            {{-- ========================================================= --}}

            <aside class="lg:col-span-1 self-start">

                <div
                    class="lg:sticky
                           lg:top-24
                           space-y-5"
                >

                    @yield('blogging-right')

                </div>

            </aside>

        </div>

    </div>

</div>

@endsection