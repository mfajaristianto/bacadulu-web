@extends('layouts.blogging')


@section('blogging-main')

@php

    $latestEvents = $events
        ->getCollection()
        ->take(5);

@endphp


{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<div class="mb-5">

    <div class="flex items-center gap-2 mb-2">

        <span
            class="w-7
                   h-[3px]
                   rounded-full
                   bg-orange-500"
        ></span>


        <span
            class="text-[11px]
                   uppercase
                   tracking-[0.16em]
                   font-bold
                   text-orange-600"
        >
            Baca Dulu
        </span>

    </div>


    <h1
        class="text-2xl
               font-extrabold
               text-slate-900"
    >
        Event
    </h1>


    <p
        class="text-sm
               text-slate-500
               mt-1"
    >
        Pilihan kegiatan yang menarik untuk diikuti dan dibagikan.
    </p>

</div>



{{-- ========================================================= --}}
{{-- FEATURED --}}
{{-- ========================================================= --}}

@if($featured)

    <article
        class="bg-white
               rounded-xl
               border border-slate-200
               shadow-sm
               overflow-hidden
               mb-5"
    >

        {{-- BANNER --}}
        @if($featured->banner_image)

            <a
                href="{{ route(
                    'event.show',
                    $featured->slug
                ) }}"
                class="relative
                       block
                       overflow-hidden"
            >

                <img
                    src="{{ asset(
                        'storage/' .
                        $featured->banner_image
                    ) }}"
                    alt="{{ $featured->title }}"
                    class="w-full
                           h-72
                           object-cover"
                >


                <div
                    class="absolute
                           inset-x-0
                           bottom-0
                           h-24
                           bg-gradient-to-t
                           from-black/50
                           to-transparent"
                ></div>


                <div
                    class="absolute
                           left-4
                           bottom-4"
                >

                    <span
                        class="inline-flex
                               items-center
                               px-3 py-1
                               rounded-full
                               bg-orange-600
                               text-white
                               text-xs
                               font-semibold"
                    >
                        Event Pilihan
                    </span>

                </div>

            </a>


        @else

            <div
                class="h-60
                       bg-slate-100
                       flex
                       items-center
                       justify-center"
            >

                <span
                    class="text-sm
                           text-slate-400"
                >
                    Banner belum tersedia
                </span>

            </div>

        @endif



        {{-- CONTENT --}}
        <div class="p-5">


            {{-- META --}}
            <div
                class="flex
                       flex-wrap
                       items-center
                       gap-2
                       mb-3"
            >

                @if($featured->category)

                    <span
                        class="inline-flex
                               px-2.5 py-1
                               rounded-full
                               bg-orange-50
                               text-orange-700
                               border border-orange-100
                               text-xs
                               font-semibold"
                    >
                        {{ $featured->category }}
                    </span>

                @endif


                @if($featured->start_date)

                    <span
                        class="text-xs
                               text-slate-400"
                    >

                        {{ $featured
                            ->start_date
                            ->copy()
                            ->timezone(
                                'Asia/Jakarta'
                            )
                            ->translatedFormat(
                                'd F Y'
                            )
                        }}

                    </span>

                @endif

            </div>



            {{-- TITLE --}}
            <a
                href="{{ route(
                    'event.show',
                    $featured->slug
                ) }}"
            >

                <h2
                    class="text-xl
                           md:text-2xl
                           font-extrabold
                           text-slate-900
                           hover:text-orange-700
                           transition
                           leading-snug"
                >
                    {{ $featured->title }}
                </h2>

            </a>



            {{-- DESCRIPTION --}}
            <p
                class="text-sm
                       text-slate-600
                       leading-relaxed
                       mt-2
                       line-clamp-3"
            >
                {{ \Illuminate\Support\Str::limit(
                    strip_tags(
                        $featured->description
                    ),
                    180
                ) }}
            </p>



            {{-- INFO --}}
            <div
                class="grid
                       grid-cols-1
                       sm:grid-cols-2
                       gap-3
                       mt-5"
            >

                <div
                    class="bg-slate-50
                           rounded-lg
                           px-4 py-3"
                >

                    <div
                        class="text-[10px]
                               font-semibold
                               uppercase
                               tracking-wide
                               text-slate-400"
                    >
                        Tanggal
                    </div>


                    <div
                        class="text-xs
                               font-semibold
                               text-slate-700
                               mt-1"
                    >

                        @if($featured->start_date)

                            {{ $featured
                                ->start_date
                                ->copy()
                                ->timezone(
                                    'Asia/Jakarta'
                                )
                                ->translatedFormat(
                                    'd M Y H:i'
                                )
                            }}
                            WIB

                        @else

                            Belum ditentukan

                        @endif

                    </div>

                </div>


                <div
                    class="bg-slate-50
                           rounded-lg
                           px-4 py-3"
                >

                    <div
                        class="text-[10px]
                               font-semibold
                               uppercase
                               tracking-wide
                               text-slate-400"
                    >
                        Lokasi
                    </div>


                    <div
                        class="text-xs
                               font-semibold
                               text-slate-700
                               mt-1"
                    >
                        {{ $featured->location ?: 'Belum ditentukan' }}
                    </div>

                </div>

            </div>



            {{-- FOOTER --}}
            <div
                class="flex
                       items-center
                       justify-between
                       mt-5
                       pt-4
                       border-t
                       border-slate-100"
            >

                <div
                    class="flex
                           items-center
                           gap-2"
                >

                    <span
                        class="w-2
                               h-2
                               rounded-full
                               bg-orange-500"
                    ></span>

                    <span
                        class="text-xs
                               text-slate-400"
                    >
                        Pilihan Baca Dulu
                    </span>

                </div>


                <a
                    href="{{ route(
                        'event.show',
                        $featured->slug
                    ) }}"
                    class="text-sm
                           font-semibold
                           text-orange-600
                           hover:text-orange-700
                           transition"
                >
                    Lihat Detail →
                </a>

            </div>

        </div>

    </article>

@endif



{{-- ========================================================= --}}
{{-- EVENT LIST --}}
{{-- ========================================================= --}}

<div class="space-y-4">

    @forelse($events as $event)

        <article
            class="bg-white
                   rounded-xl
                   border border-slate-200
                   shadow-sm
                   overflow-hidden
                   hover:border-orange-100
                   hover:shadow-md
                   transition"
        >


            {{-- BANNER --}}
            @if($event->banner_image)

                <a
                    href="{{ route(
                        'event.show',
                        $event->slug
                    ) }}"
                    class="block overflow-hidden"
                >

                    <img
                        src="{{ asset(
                            'storage/' .
                            $event->banner_image
                        ) }}"
                        alt="{{ $event->title }}"
                        class="w-full
                               h-56
                               object-cover"
                    >

                </a>

            @endif



            <div class="p-5">


                {{-- CATEGORY & DATE --}}
                <div
                    class="flex
                           flex-wrap
                           items-center
                           gap-2
                           mb-3"
                >

                    @if($event->category)

                        <span
                            class="inline-flex
                                   px-2.5 py-1
                                   rounded-full
                                   bg-orange-50
                                   border border-orange-100
                                   text-orange-700
                                   text-xs
                                   font-semibold"
                        >
                            {{ $event->category }}
                        </span>

                    @endif


                    @if($event->start_date)

                        <span
                            class="text-xs
                                   text-slate-400"
                        >
                            {{ $event
                                ->start_date
                                ->copy()
                                ->timezone(
                                    'Asia/Jakarta'
                                )
                                ->translatedFormat(
                                    'd F Y'
                                )
                            }}
                        </span>

                    @endif

                </div>



                {{-- TITLE --}}
                <a
                    href="{{ route(
                        'event.show',
                        $event->slug
                    ) }}"
                >

                    <h2
                        class="text-lg
                               md:text-xl
                               font-bold
                               text-slate-900
                               hover:text-orange-700
                               transition
                               leading-snug"
                    >
                        {{ $event->title }}
                    </h2>

                </a>



                {{-- DESCRIPTION --}}
                <p
                    class="text-sm
                           text-slate-600
                           leading-relaxed
                           mt-2
                           line-clamp-2"
                >
                    {{ \Illuminate\Support\Str::limit(
                        strip_tags(
                            $event->description
                        ),
                        150
                    ) }}
                </p>



                {{-- INFO --}}
                <div
                    class="flex
                           flex-wrap
                           items-center
                           gap-x-5
                           gap-y-2
                           mt-4
                           text-xs
                           text-slate-500"
                >

                    @if($event->start_date)

                        <span>

                            {{ $event
                                ->start_date
                                ->copy()
                                ->timezone(
                                    'Asia/Jakarta'
                                )
                                ->translatedFormat(
                                    'd M Y'
                                )
                            }}

                        </span>

                    @endif


                    <span>
                        {{ $event->location }}
                    </span>

                </div>



                {{-- FOOTER --}}
                <div
                    class="flex
                           items-center
                           justify-between
                           mt-4
                           pt-4
                           border-t
                           border-slate-100"
                >

                    <div
                        class="flex
                               items-center
                               gap-2"
                    >

                        <span
                            class="w-2
                                   h-2
                                   bg-orange-500
                                   rounded-full"
                        ></span>


                        <span
                            class="text-xs
                                   text-slate-400"
                        >
                            Baca Dulu Event
                        </span>

                    </div>


                    <a
                        href="{{ route(
                            'event.show',
                            $event->slug
                        ) }}"
                        class="text-sm
                               font-semibold
                               text-orange-600
                               hover:text-orange-700
                               transition"
                    >
                        Detail →
                    </a>

                </div>

            </div>

        </article>


    @empty

        @if(!$featured)

            <div
                class="bg-white
                       rounded-xl
                       border border-slate-200
                       py-16
                       px-6
                       text-center"
            >

                <h3
                    class="font-semibold
                           text-slate-700"
                >
                    Belum ada event
                </h3>


                <p
                    class="text-sm
                           text-slate-400
                           mt-1"
                >
                    Event terbaru akan tampil di sini.
                </p>

            </div>

        @endif

    @endforelse

</div>



{{-- ========================================================= --}}
{{-- PAGINATION --}}
{{-- ========================================================= --}}

@if($events->hasPages())

    <div class="mt-6">

        {{ $events->links() }}

    </div>

@endif

@endsection



@section('blogging-right')

{{-- ========================================================= --}}
{{-- EVENT TERBARU --}}
{{-- ========================================================= --}}

<div
    class="bg-white
           rounded-xl
           border border-slate-200
           shadow-sm
           p-5"
>

    <div
        class="flex
               items-center
               gap-2
               mb-4"
    >

        <span
            class="w-1
                   h-5
                   rounded-full
                   bg-orange-500"
        ></span>


        <h3
            class="text-base
                   font-bold
                   text-slate-900"
        >
            Event Terbaru
        </h3>

    </div>


    <div class="space-y-4">

        @forelse($latestEvents as $latestEvent)

            <a
                href="{{ route(
                    'event.show',
                    $latestEvent->slug
                ) }}"
                class="flex
                       gap-3
                       group"
            >

                <span
                    class="text-lg
                           font-bold
                           text-slate-200
                           group-hover:text-orange-300
                           transition
                           w-5
                           shrink-0"
                >
                    {{ $loop->iteration }}
                </span>


                <div class="min-w-0">

                    <p
                        class="text-sm
                               font-semibold
                               text-slate-800
                               group-hover:text-orange-700
                               transition
                               leading-snug
                               line-clamp-2"
                    >
                        {{ $latestEvent->title }}
                    </p>


                    @if($latestEvent->start_date)

                        <p
                            class="text-xs
                                   text-slate-400
                                   mt-1"
                        >
                            {{ $latestEvent
                                ->start_date
                                ->copy()
                                ->timezone(
                                    'Asia/Jakarta'
                                )
                                ->translatedFormat(
                                    'd M Y'
                                )
                            }}
                        </p>

                    @endif

                </div>

            </a>


        @empty

            <p
                class="text-sm
                       text-slate-400"
            >
                Belum ada event terbaru.
            </p>

        @endforelse

    </div>

</div>



{{-- ========================================================= --}}
{{-- BACA DULU --}}
{{-- ========================================================= --}}

<div
    class="bg-[#2b2f3a]
           rounded-xl
           p-5"
>

    <div
        class="text-[10px]
               uppercase
               tracking-[0.18em]
               font-bold
               text-orange-400"
    >
        Baca Dulu
    </div>


    <h4
        class="text-base
               font-bold
               text-white
               mt-2"
    >
        Baca dulu, datang kemudian.
    </h4>


    <p
        class="text-xs
               text-slate-300
               leading-relaxed
               mt-2"
    >
        Kenali kegiatan yang relevan sebelum menentukan mana yang ingin Anda ikuti.
    </p>

</div>

@endsection