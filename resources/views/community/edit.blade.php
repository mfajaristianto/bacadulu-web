@extends('layouts.app')

@section('content')

@php

    $communityImage =
        $community->icon
        ?? $community->cover
        ?? $community->image
        ?? null;


    if ($communityImage) {

        $communityImageUrl =
            filter_var(
                $communityImage,
                FILTER_VALIDATE_URL
            )
                ? $communityImage
                : asset(
                    'storage/' . $communityImage
                );

    } else {

        $communityImageUrl = null;
    }

@endphp


<div class="bg-slate-50 min-h-screen">

    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-10">


        {{-- ========================================================= --}}
        {{-- BACK --}}
        {{-- ========================================================= --}}

        <a
            href="{{ route(
                'community.show',
                $community
            ) }}"
            class="inline-flex
                   items-center
                   gap-2
                   text-sm
                   font-semibold
                   text-slate-500
                   hover:text-orange-600
                   transition
                   mb-5"
        >
            ← Kembali
        </a>



        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div class="mb-6">

            <h1
                class="text-2xl
                       md:text-3xl
                       font-bold
                       text-slate-900"
            >
                Edit Komunitas
            </h1>


            <p
                class="text-sm
                       text-slate-500
                       mt-1"
            >
                Perbarui informasi komunitas yang Anda buat.
            </p>

        </div>



        {{-- ========================================================= --}}
        {{-- VALIDATION --}}
        {{-- ========================================================= --}}

        @if($errors->any())

            <div
                class="mb-6
                       bg-red-50
                       border border-red-200
                       rounded-xl
                       p-4"
            >

                <p
                    class="font-semibold
                           text-red-700
                           mb-2"
                >
                    Data belum dapat disimpan:
                </p>


                <ul
                    class="list-disc
                           pl-5
                           text-sm
                           text-red-600
                           space-y-1"
                >

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif



        {{-- ========================================================= --}}
        {{-- FORM --}}
        {{-- ========================================================= --}}

        <form
            action="{{ route(
                'community.update',
                $community
            ) }}"
            method="POST"
            enctype="multipart/form-data"
            class="bg-white
                   rounded-2xl
                   border border-slate-200
                   shadow-sm
                   overflow-hidden"
        >

            @csrf
            @method('PUT')



            {{-- ===================================================== --}}
            {{-- HEADER FORM --}}
            {{-- ===================================================== --}}

            <div
                class="px-6 py-5
                       bg-slate-50
                       border-b border-slate-200"
            >

                <h2
                    class="text-lg
                           font-semibold
                           text-slate-900"
                >
                    Informasi Komunitas
                </h2>


                <p
                    class="text-sm
                           text-slate-500
                           mt-1"
                >
                    Anda hanya dapat mengubah komunitas milik Anda sendiri.
                </p>

            </div>



            <div class="p-6 md:p-7">


                {{-- ================================================= --}}
                {{-- NAME --}}
                {{-- ================================================= --}}

                <div class="mb-6">

                    <label
                        for="name"
                        class="block
                               text-sm
                               font-semibold
                               text-slate-700
                               mb-2"
                    >
                        Nama Komunitas

                        <span class="text-red-500">
                            *
                        </span>
                    </label>


                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old(
                            'name',
                            $community->name
                        ) }}"
                        required
                        class="w-full
                               rounded-lg
                               border border-slate-300
                               px-4 py-3
                               text-slate-900
                               outline-none
                               transition
                               focus:border-orange-500
                               focus:ring-2
                               focus:ring-orange-100"
                    >


                    @error('name')

                        <p
                            class="mt-1.5
                                   text-sm
                                   text-red-600"
                        >
                            {{ $message }}
                        </p>

                    @enderror

                </div>



                {{-- ================================================= --}}
                {{-- DESCRIPTION --}}
                {{-- ================================================= --}}

                <div class="mb-6">

                    <label
                        for="description"
                        class="block
                               text-sm
                               font-semibold
                               text-slate-700
                               mb-2"
                    >
                        Deskripsi

                        <span class="text-red-500">
                            *
                        </span>
                    </label>


                    <textarea
                        id="description"
                        name="description"
                        rows="7"
                        required
                        class="w-full
                               rounded-lg
                               border border-slate-300
                               px-4 py-3
                               text-slate-900
                               outline-none
                               resize-y
                               transition
                               focus:border-orange-500
                               focus:ring-2
                               focus:ring-orange-100"
                    >{{ old(
                        'description',
                        $community->description
                    ) }}</textarea>


                    @error('description')

                        <p
                            class="mt-1.5
                                   text-sm
                                   text-red-600"
                        >
                            {{ $message }}
                        </p>

                    @enderror

                </div>



                {{-- ================================================= --}}
                {{-- CURRENT IMAGE --}}
                {{-- ================================================= --}}

                @if($communityImageUrl)

                    <div class="mb-6">

                        <label
                            class="block
                                   text-sm
                                   font-semibold
                                   text-slate-700
                                   mb-2"
                        >
                            Icon/Cover Saat Ini
                        </label>


                        <div
                            class="rounded-xl
                                   border border-slate-200
                                   bg-slate-50
                                   overflow-hidden"
                        >

                            <img
                                src="{{ $communityImageUrl }}"
                                alt="{{ $community->name }}"
                                class="w-full
                                       max-h-72
                                       object-cover"
                            >

                        </div>

                    </div>

                @endif



                {{-- ================================================= --}}
                {{-- NEW IMAGE --}}
                {{-- ================================================= --}}

                <div class="mb-6">

                    <label
                        for="icon"
                        class="block
                               text-sm
                               font-semibold
                               text-slate-700
                               mb-2"
                    >
                        Ganti Icon/Cover Komunitas
                    </label>


                    <input
                        type="file"
                        id="icon"
                        name="icon"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="block
                               w-full
                               rounded-lg
                               border border-slate-300
                               bg-white
                               px-4 py-3
                               text-sm
                               text-slate-600"
                    >


                    <p
                        class="text-xs
                               text-slate-500
                               mt-2"
                    >
                        Kosongkan jika gambar lama tetap digunakan.
                        Format JPG, JPEG, PNG atau WEBP. Maksimal 2 MB.
                    </p>


                    @error('icon')

                        <p
                            class="mt-1.5
                                   text-sm
                                   text-red-600"
                        >
                            {{ $message }}
                        </p>

                    @enderror

                </div>



                {{-- ================================================= --}}
                {{-- STATUS --}}
                {{-- ================================================= --}}

                <div
                    class="bg-slate-50
                           border border-slate-200
                           rounded-xl
                           px-4 py-4"
                >

                    <div
                        class="text-sm
                               font-semibold
                               text-slate-700"
                    >
                        Status Komunitas
                    </div>


                    <div class="mt-2">

                        @if($community->status === 'approved')

                            <span
                                class="inline-flex
                                       px-3 py-1
                                       bg-green-100
                                       text-green-700
                                       rounded-full
                                       text-xs
                                       font-semibold"
                            >
                                Disetujui
                            </span>


                        @elseif($community->status === 'pending')

                            <span
                                class="inline-flex
                                       px-3 py-1
                                       bg-yellow-100
                                       text-yellow-700
                                       rounded-full
                                       text-xs
                                       font-semibold"
                            >
                                Menunggu Persetujuan
                            </span>


                        @else

                            <span
                                class="inline-flex
                                       px-3 py-1
                                       bg-red-100
                                       text-red-700
                                       rounded-full
                                       text-xs
                                       font-semibold"
                            >
                                Ditolak
                            </span>

                        @endif

                    </div>


                    <p
                        class="text-xs
                               text-slate-500
                               mt-2"
                    >
                        Status persetujuan hanya dapat diubah oleh admin.
                    </p>

                </div>

            </div>



            {{-- ===================================================== --}}
            {{-- FOOTER --}}
            {{-- ===================================================== --}}

            <div
                class="px-6 py-4
                       bg-slate-50
                       border-t border-slate-200
                       flex
                       flex-col-reverse
                       sm:flex-row
                       justify-end
                       gap-3"
            >

                <a
                    href="{{ route(
                        'community.show',
                        $community
                    ) }}"
                    class="inline-flex
                           items-center
                           justify-center
                           px-5 py-2.5
                           bg-white
                           border border-slate-300
                           hover:bg-slate-100
                           text-slate-700
                           text-sm
                           font-semibold
                           rounded-lg
                           transition"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    class="inline-flex
                           items-center
                           justify-center
                           px-6 py-2.5
                           bg-orange-600
                           hover:bg-orange-700
                           text-white
                           text-sm
                           font-semibold
                           rounded-lg
                           shadow-sm
                           transition"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection