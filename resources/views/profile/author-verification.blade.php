@extends('layouts.app')

@section('title', 'Verifikasi Penulis - Baca Dulu')

@section('content')

@php

    $status =
        $verification?->status ?? 'unverified';

    $statusLabel = match($status) {

        'approved' =>
            'Penulis Terverifikasi',

        'pending' =>
            'Menunggu Review',

        'rejected' =>
            'Perlu Diperbaiki',

        default =>
            'Belum Diverifikasi',

    };


    $statusClass = match($status) {

        'approved' =>
            'border-emerald-200 bg-emerald-50 text-emerald-700',

        'pending' =>
            'border-amber-200 bg-amber-50 text-amber-700',

        'rejected' =>
            'border-red-200 bg-red-50 text-red-700',

        default =>
            'border-slate-200 bg-slate-50 text-slate-600',

    };

@endphp


<div class="min-h-[calc(100vh-80px)] bg-slate-50 py-10">

    <div class="mx-auto w-full max-w-3xl px-5">

        <a
            href="{{ route('profile.edit') }}"
            class="bd-verification-back mb-6 inline-flex items-center gap-2 text-sm font-bold text-slate-500 transition hover:text-orange-600"
        >
            <span aria-hidden="true">←</span>
            Kembali ke Profil
        </a>


        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div
            class="
                mb-7
                flex
                flex-col
                gap-4
                sm:flex-row
                sm:items-end
                sm:justify-between
            "
        >

            <div>

                <div class="mb-2 flex items-center gap-2">

                    <span
                        class="
                            h-[3px]
                            w-7
                            rounded-full
                            bg-orange-500
                        "
                    ></span>

                    <span
                        class="
                            text-[11px]
                            font-bold
                            uppercase
                            tracking-[.16em]
                            text-orange-600
                        "
                    >
                        BacaDulu
                    </span>

                </div>


                <h1
                    class="
                        text-3xl
                        font-extrabold
                        text-slate-900
                    "
                >
                    Verifikasi Penulis
                </h1>


                <p
                    class="
                        mt-2
                        max-w-2xl
                        text-sm
                        leading-relaxed
                        text-slate-500
                    "
                >
                    Verifikasi membantu membedakan pengguna biasa
                    dengan penulis yang bukti kepenulisannya telah
                    diperiksa oleh admin BacaDulu.
                </p>

            </div>


            <span
                class="
                    inline-flex
                    w-fit
                    rounded-full
                    border
                    px-3
                    py-1.5
                    text-xs
                    font-bold

                    {{ $statusClass }}
                "
            >
                {{ $statusLabel }}
            </span>

        </div>



        {{-- =====================================================
             SUCCESS
        ====================================================== --}}

        @if(session('verification_success'))

            <div
                class="
                    mb-5
                    rounded-xl
                    border
                    border-emerald-200
                    bg-emerald-50
                    px-4
                    py-3
                    text-sm
                    font-semibold
                    text-emerald-700
                "
            >
                {{ session('verification_success') }}
            </div>

        @endif



        {{-- =====================================================
             ERRORS
        ====================================================== --}}

        @if($errors->any())

            <div
                class="
                    mb-5
                    rounded-xl
                    border
                    border-red-200
                    bg-red-50
                    px-4
                    py-3
                    text-sm
                    text-red-700
                "
            >

                <ul class="list-disc space-y-1 pl-5">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif



        {{-- =====================================================
             INFO
        ====================================================== --}}

        <section
            class="
                mb-6
                rounded-2xl
                border
                border-slate-200
                bg-white
                p-6
                shadow-sm
            "
        >

            <div class="flex items-start gap-4">

                <div
                    class="
                        grid
                        h-11
                        w-11
                        shrink-0
                        place-items-center
                        rounded-xl
                        bg-orange-50
                        text-orange-600
                    "
                >

                    <svg
                        width="22"
                        height="22"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 3l7 3v5c0 4.5-2.9 8.1-7 10-4.1-1.9-7-5.5-7-10V6l7-3z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12l2 2 4-4"
                        />

                    </svg>

                </div>


                <div>

                    <h2 class="font-bold text-slate-900">
                        Bukti apa yang bisa digunakan?
                    </h2>

                    <p
                        class="
                            mt-1
                            text-sm
                            leading-relaxed
                            text-slate-500
                        "
                    >
                        LoA, halaman artikel atau jurnal yang
                        mencantumkan nama Anda, sertifikat penulis,
                        atau dokumen publikasi lain yang dapat
                        menunjukkan kepenulisan.
                    </p>


                    <p
                        class="
                            mt-3
                            text-xs
                            font-semibold
                            text-slate-400
                        "
                    >
                        Dokumen disimpan secara private dan tidak
                        ditampilkan kepada publik.
                    </p>

                </div>

            </div>

        </section>



        {{-- =====================================================
             APPROVED
        ====================================================== --}}

        @if($status === 'approved')

            <section
                class="
                    rounded-2xl
                    border
                    border-emerald-200
                    bg-white
                    p-6
                    shadow-sm
                "
            >

                <div class="flex items-start gap-4">

                    <div
                        class="
                            grid
                            h-12
                            w-12
                            shrink-0
                            place-items-center
                            rounded-full
                            bg-emerald-100
                            text-xl
                            font-extrabold
                            text-emerald-700
                        "
                    >
                        ✓
                    </div>


                    <div>

                        <h2
                            class="
                                text-lg
                                font-extrabold
                                text-slate-900
                            "
                        >
                            Penulis Terverifikasi
                        </h2>


                        <p
                            class="
                                mt-1
                                text-sm
                                leading-relaxed
                                text-slate-500
                            "
                        >
                            Bukti kepenulisan Anda telah diperiksa
                            dan disetujui oleh admin BacaDulu.
                        </p>


                        @if($verification?->reviewed_at)

                            <p
                                class="
                                    mt-3
                                    text-xs
                                    font-semibold
                                    text-slate-400
                                "
                            >
                                Diverifikasi pada
                                {{ $verification->reviewed_at->format('d-m-Y H:i') }}
                            </p>

                        @endif

                    </div>

                </div>

            </section>



        {{-- =====================================================
             PENDING
        ====================================================== --}}

        @elseif($status === 'pending')

            <section
                class="
                    rounded-2xl
                    border
                    border-amber-200
                    bg-white
                    p-6
                    shadow-sm
                "
            >

                <div class="flex items-start gap-4">

                    <div
                        class="
                            grid
                            h-12
                            w-12
                            shrink-0
                            place-items-center
                            rounded-full
                            bg-amber-100
                            text-amber-700
                        "
                    >
                        ⏳
                    </div>


                    <div>

                        <h2
                            class="
                                font-extrabold
                                text-slate-900
                            "
                        >
                            Pengajuan sedang diperiksa
                        </h2>


                        <p
                            class="
                                mt-2
                                text-sm
                                leading-relaxed
                                text-slate-500
                            "
                        >
                            Anda tidak perlu mengirim ulang.
                            Admin akan memeriksa bukti yang sudah
                            Anda kirimkan.
                        </p>

                    </div>

                </div>

            </section>



        {{-- =====================================================
             FORM
        ====================================================== --}}

        @else


            {{-- REJECTED --}}

            @if($status === 'rejected')

                <section
                    class="
                        mb-6
                        rounded-2xl
                        border
                        border-red-200
                        bg-red-50
                        p-5
                    "
                >

                    <p
                        class="
                            text-xs
                            font-bold
                            uppercase
                            tracking-[.12em]
                            text-red-600
                        "
                    >
                        Catatan Admin
                    </p>


                    <p
                        class="
                            mt-2
                            text-sm
                            leading-relaxed
                            text-red-800
                        "
                    >
                        {{
                            $verification?->admin_note
                            ?: 'Silakan perbaiki data atau bukti lalu kirim ulang.'
                        }}
                    </p>

                </section>

            @endif



            <form
                action="{{ route('profile.author-verification.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="
                    rounded-2xl
                    border
                    border-slate-200
                    bg-white
                    p-6
                    shadow-sm
                "
            >

                @csrf


                <div class="grid gap-5 sm:grid-cols-2">


                    {{-- INSTITUTION --}}

                    <div class="sm:col-span-2">

                        <label
                            class="
                                mb-2
                                block
                                text-sm
                                font-bold
                                text-slate-800
                            "
                        >
                            Institusi / Afiliasi
                            <span class="text-orange-600">*</span>
                        </label>


                        <input
                            type="text"
                            name="institution"
                            value="{{ old('institution', $verification?->institution) }}"
                            maxlength="255"
                            required
                            placeholder="Contoh: Universitas Mercu Buana"
                            class="
                                w-full
                                rounded-xl
                                border
                                border-slate-300
                                px-4
                                py-3
                                text-sm
                                outline-none
                                transition
                                focus:border-orange-400
                                focus:ring-4
                                focus:ring-orange-50
                            "
                        >

                    </div>



                    {{-- ORCID --}}

                    <div>

                        <label
                            class="
                                mb-2
                                block
                                text-sm
                                font-bold
                                text-slate-800
                            "
                        >
                            ORCID
                        </label>


                        <input
                            type="text"
                            name="orcid_url"
                            value="{{ old('orcid_url', $verification?->orcid_url) }}"
                            placeholder="0000-0000-0000-000X"
                            class="
                                w-full
                                rounded-xl
                                border
                                border-slate-300
                                px-4
                                py-3
                                text-sm
                                outline-none
                                transition
                                focus:border-orange-400
                                focus:ring-4
                                focus:ring-orange-50
                            "
                        >

                    </div>



                    {{-- GOOGLE SCHOLAR --}}

                    <div>

                        <label
                            class="
                                mb-2
                                block
                                text-sm
                                font-bold
                                text-slate-800
                            "
                        >
                            Google Scholar
                        </label>


                        <input
                            type="url"
                            name="google_scholar_url"
                            value="{{ old('google_scholar_url', $verification?->google_scholar_url) }}"
                            placeholder="https://scholar.google.com/..."
                            class="
                                w-full
                                rounded-xl
                                border
                                border-slate-300
                                px-4
                                py-3
                                text-sm
                                outline-none
                                transition
                                focus:border-orange-400
                                focus:ring-4
                                focus:ring-orange-50
                            "
                        >

                    </div>



                    {{-- PUBLICATION URL --}}

                    <div class="sm:col-span-2">

                        <label
                            class="
                                mb-2
                                block
                                text-sm
                                font-bold
                                text-slate-800
                            "
                        >
                            Link Publikasi / DOI
                        </label>


                        <input
                            type="url"
                            name="publication_url"
                            value="{{ old('publication_url', $verification?->publication_url) }}"
                            placeholder="https://doi.org/..."
                            class="
                                w-full
                                rounded-xl
                                border
                                border-slate-300
                                px-4
                                py-3
                                text-sm
                                outline-none
                                transition
                                focus:border-orange-400
                                focus:ring-4
                                focus:ring-orange-50
                            "
                        >

                    </div>



                    {{-- EVIDENCE --}}

                    <div class="sm:col-span-2">

                        <label
                            class="
                                mb-2
                                block
                                text-sm
                                font-bold
                                text-slate-800
                            "
                        >
                            Bukti Kepenulisan

                            @if(!$verification?->evidence_path)
                                <span class="text-orange-600">*</span>
                            @endif

                        </label>


                        <input
                            type="file"
                            name="evidence"
                            accept="
                                application/pdf,
                                image/jpeg,
                                image/png,
                                image/webp
                            "
                            {{ !$verification?->evidence_path ? 'required' : '' }}
                            class="
                                block
                                w-full
                                rounded-xl
                                border
                                border-dashed
                                border-slate-300
                                bg-slate-50
                                px-4
                                py-4
                                text-sm
                                text-slate-500

                                file:mr-3
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


                        <p
                            class="
                                mt-2
                                text-xs
                                leading-relaxed
                                text-slate-400
                            "
                        >
                            PDF, JPG, PNG, atau WEBP.
                            Maksimal 10 MB.
                        </p>


                        @if($verification?->evidence_original_name)

                            <p
                                class="
                                    mt-2
                                    text-xs
                                    font-semibold
                                    text-slate-500
                                "
                            >
                                Bukti sebelumnya:
                                {{ $verification->evidence_original_name }}
                            </p>

                        @endif

                    </div>

                </div>



                {{-- DECLARATION --}}

                <label
                    class="
                        mt-6
                        flex
                        items-start
                        gap-3
                        rounded-xl
                        border
                        border-slate-200
                        bg-slate-50
                        p-4
                        text-sm
                        leading-relaxed
                        text-slate-600
                    "
                >

                    <input
                        type="checkbox"
                        name="declaration"
                        value="1"
                        required
                        class="
                            mt-1
                            rounded
                            border-slate-300
                            text-orange-600
                            focus:ring-orange-500
                        "
                    >


                    <span>
                        Saya menyatakan bahwa data dan bukti yang
                        dikirim adalah benar serta berkaitan dengan
                        identitas kepenulisan saya.
                    </span>

                </label>



                {{-- BUTTONS --}}

                <div
                    class="
                        mt-6
                        flex
                        flex-wrap
                        items-center
                        justify-between
                        gap-3
                    "
                >

                    <a
                        href="{{ route('profile.edit') }}"
                        class="
                            text-sm
                            font-semibold
                            text-slate-500
                            hover:text-orange-600
                        "
                    >
                        ← Kembali ke Profil
                    </a>


                    <button
                        type="submit"
                        class="
                            rounded-xl
                            bg-orange-600
                            px-5
                            py-3
                            text-sm
                            font-bold
                            text-white
                            transition
                            hover:bg-orange-700
                        "
                    >
                        Kirim untuk Review Admin
                    </button>

                </div>

            </form>

        @endif


    </div>

</div>

@endsection