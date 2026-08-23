@extends('layouts.blogging')


@section('blogging-main')

{{-- ========================================================= --}}
{{-- BREADCRUMB --}}
{{-- ========================================================= --}}

<div
    class="flex
           items-center
           gap-2
           text-xs
           text-slate-400
           mb-4"
>

    <a
        href="{{ route('blog.index') }}"
        class="hover:text-orange-600 transition"
    >
        Blogging
    </a>

    <span>
        /
    </span>

    <a
        href="{{ route('event.index') }}"
        class="hover:text-orange-600 transition"
    >
        Event
    </a>

    <span>
        /
    </span>

    <span
        class="text-slate-500
               truncate"
    >
        {{ $event->title }}
    </span>

</div>



{{-- ========================================================= --}}
{{-- EVENT --}}
{{-- ========================================================= --}}

<article
    class="bg-white
           rounded-xl
           border border-slate-200
           shadow-sm
           overflow-hidden"
>


    {{-- ===================================================== --}}
    {{-- BANNER --}}
    {{-- ===================================================== --}}

    @if($event->banner_image)

        <div
            class="relative
                   w-full
                   overflow-hidden"
        >

            <img
                src="{{ asset('storage/' . $event->banner_image) }}"
                alt="{{ $event->title }}"
                class="w-full
                       max-h-[430px]
                       object-cover"
            >


            @if($event->is_featured)

                <div
                    class="absolute
                           left-4
                           bottom-4"
                >

                    <span
                        class="inline-flex
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

            @endif

        </div>


    @else

        <div
            class="h-56
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



    {{-- ===================================================== --}}
    {{-- CONTENT --}}
    {{-- ===================================================== --}}

    <div class="p-6 md:p-8">


        {{-- ================================================= --}}
        {{-- CATEGORY + DATE --}}
        {{-- ================================================= --}}

        <div
            class="flex
                   flex-wrap
                   items-center
                   gap-2
                   mb-4"
        >

            @if($event->category)

                <span
                    class="inline-flex
                           px-3 py-1
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
                        ->timezone('Asia/Jakarta')
                        ->translatedFormat('d F Y')
                    }}
                </span>

            @endif

        </div>



        {{-- ================================================= --}}
        {{-- TITLE --}}
        {{-- ================================================= --}}

        <h1
            class="text-2xl
                   md:text-3xl
                   font-extrabold
                   text-slate-900
                   leading-tight
                   break-words"
        >
            {{ $event->title }}
        </h1>



        {{-- ================================================= --}}
        {{-- IDENTITAS BACA DULU --}}
        {{-- ICON BD DIGANTI LOGO --}}
        {{-- ================================================= --}}

        <div
            class="flex
                   items-center
                   gap-3
                   mt-5"
        >

            {{-- LOGO BACA DULU --}}
            <div
                class="w-11
                       h-11
                       rounded-xl
                       bg-white
                       border border-orange-100
                       flex
                       items-center
                       justify-center
                       overflow-hidden
                       shrink-0"
            >

                <img
                    src="{{ asset('img/bacadulu-logo.jpg') }}"
                    alt="Logo Baca Dulu"
                    class="w-full
                           h-full
                           object-contain
                           p-1"
                >

            </div>


            <div>

                <div
                    class="text-sm
                           font-bold
                           text-slate-800"
                >
                    Baca Dulu Event
                </div>


                <div
                    class="text-xs
                           text-slate-400
                           mt-0.5"
                >
                    Informasi kegiatan
                </div>

            </div>

        </div>



        {{-- ================================================= --}}
        {{-- QUICK INFO --}}
        {{-- ================================================= --}}

        <div
            class="grid
                   grid-cols-1
                   sm:grid-cols-2
                   gap-3
                   mt-7"
        >


            {{-- ================================================= --}}
            {{-- DATE --}}
            {{-- ================================================= --}}

            <div
                class="bg-slate-50
                       rounded-lg
                       px-4 py-3"
            >

                <div
                    class="text-[10px]
                           uppercase
                           tracking-wide
                           font-semibold
                           text-slate-400"
                >
                    Tanggal & Waktu
                </div>


                <div
                    class="text-xs
                           font-semibold
                           text-slate-700
                           mt-1"
                >

                    @if($event->start_date)

                        {{ $event
                            ->start_date
                            ->copy()
                            ->timezone('Asia/Jakarta')
                            ->translatedFormat('d F Y H:i')
                        }}
                        WIB

                    @else

                        Belum ditentukan

                    @endif

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- LOCATION --}}
            {{-- ================================================= --}}

            <div
                class="bg-slate-50
                       rounded-lg
                       px-4 py-3"
            >

                <div
                    class="text-[10px]
                           uppercase
                           tracking-wide
                           font-semibold
                           text-slate-400"
                >
                    Lokasi
                </div>


                <div
                    class="text-xs
                           font-semibold
                           text-slate-700
                           mt-1
                           break-words"
                >
                    {{ $event->location ?: 'Belum ditentukan' }}
                </div>

            </div>

        </div>



        {{-- ================================================= --}}
        {{-- DESCRIPTION --}}
        {{-- ================================================= --}}

        <div
            class="mt-8
                   pt-7
                   border-t
                   border-slate-100"
        >

            <h2
                class="text-lg
                       font-bold
                       text-slate-900"
            >
                Tentang Event
            </h2>


            <div
                class="mt-4
                       text-slate-700
                       leading-relaxed
                       whitespace-pre-line
                       break-words"
            >{{ $event->description }}</div>

        </div>

    </div>

</article>



{{-- ========================================================= --}}
{{-- BACK --}}
{{-- ========================================================= --}}

<div class="mt-6">

    <a
        href="{{ route('event.index') }}"
        class="inline-flex
               items-center
               gap-2
               text-sm
               font-semibold
               text-orange-600
               hover:text-orange-700
               transition"
    >
        ← Lihat Event Lainnya
    </a>

</div>

@endsection



@section('blogging-right')

{{-- ========================================================= --}}
{{-- INFORMASI EVENT --}}
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
               gap-2"
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
            Informasi Event
        </h3>

    </div>


    <div class="mt-5 space-y-5">


        {{-- ================================================= --}}
        {{-- DATE --}}
        {{-- ================================================= --}}

        <div>

            <div
                class="text-xs
                       text-slate-400"
            >
                Tanggal
            </div>


            <div
                class="text-sm
                       font-semibold
                       text-slate-800
                       mt-1"
            >

                @if($event->start_date)

                    {{ $event
                        ->start_date
                        ->copy()
                        ->timezone('Asia/Jakarta')
                        ->translatedFormat('d F Y')
                    }}

                @else

                    -

                @endif

            </div>

        </div>



        {{-- ================================================= --}}
        {{-- TIME --}}
        {{-- ================================================= --}}

        <div>

            <div
                class="text-xs
                       text-slate-400"
            >
                Waktu
            </div>


            <div
                class="text-sm
                       font-semibold
                       text-slate-800
                       mt-1"
            >

                @if($event->start_date)

                    {{ $event
                        ->start_date
                        ->copy()
                        ->timezone('Asia/Jakarta')
                        ->format('H:i')
                    }}
                    WIB

                @else

                    -

                @endif

            </div>

        </div>



        {{-- ================================================= --}}
        {{-- END DATE --}}
        {{-- ================================================= --}}

        @if($event->end_date)

            <div>

                <div
                    class="text-xs
                           text-slate-400"
                >
                    Selesai
                </div>


                <div
                    class="text-sm
                           font-semibold
                           text-slate-800
                           mt-1"
                >
                    {{ $event
                        ->end_date
                        ->copy()
                        ->timezone('Asia/Jakarta')
                        ->translatedFormat('d F Y H:i')
                    }}
                    WIB
                </div>

            </div>

        @endif



        {{-- ================================================= --}}
        {{-- LOCATION --}}
        {{-- ================================================= --}}

        <div>

            <div
                class="text-xs
                       text-slate-400"
            >
                Lokasi
            </div>


            <div
                class="text-sm
                       font-semibold
                       text-slate-800
                       mt-1
                       break-words"
            >
                {{ $event->location ?: '-' }}
            </div>

        </div>



        {{-- ================================================= --}}
        {{-- CATEGORY --}}
        {{-- ================================================= --}}

        <div>

            <div
                class="text-xs
                       text-slate-400"
            >
                Kategori
            </div>


            <div
                class="text-sm
                       font-semibold
                       text-slate-800
                       mt-1"
            >
                {{ $event->category ?: 'Event' }}
            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- BACA DULU CARD --}}
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
        Kenali detail kegiatan sebelum menentukan event yang ingin Anda ikuti.
    </p>

</div>

@endsection