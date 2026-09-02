@extends('layouts.admin')

@section('title', 'Edit Conference')

@section('content')

<style>
.bd-conf-edit {
    --navy:#241B52;
    --orange:#EF5843;
    --line:#E5E7EB;
    --muted:#7A808A;

    padding:32px 0 55px;

    font-family:'Inter',sans-serif;
}

.bd-conf-edit-shell {
    width:min(calc(100% - 40px),1100px);

    margin:auto;
}

.bd-conf-edit-header {
    display:flex;
    justify-content:space-between;
    align-items:flex-end;

    gap:20px;

    margin-bottom:24px;
}

.bd-conf-edit-header h1 {
    margin:0;

    color:var(--navy);

    font-family:'Poppins',sans-serif;
    font-size:32px;
}

.bd-conf-edit-header p {
    margin:5px 0 0;

    color:var(--muted);

    font-size:11px;
}

.bd-conf-edit-back {
    padding:11px 15px;

    border:1px solid var(--line);
    border-radius:9px;

    color:var(--navy)!important;

    text-decoration:none!important;

    font-size:11px;
    font-weight:700;
}

.bd-conf-edit-grid {
    display:grid;

    grid-template-columns:minmax(0,1fr) 320px;

    gap:20px;
}

.bd-conf-edit-panel {
    overflow:hidden;

    border:1px solid var(--line);
    border-radius:14px;

    background:white;
}

.bd-conf-edit-panel + .bd-conf-edit-panel {
    margin-top:18px;
}

.bd-conf-edit-head {
    padding:17px 19px;

    border-bottom:1px solid var(--line);
}

.bd-conf-edit-head h2 {
    margin:0;

    color:var(--navy);

    font-family:'Poppins',sans-serif;
    font-size:14px;
}

.bd-conf-edit-body {
    padding:19px;
}

.bd-conf-edit-field + .bd-conf-edit-field {
    margin-top:18px;
}

.bd-conf-edit-label {
    display:block;

    margin-bottom:7px;

    color:#343840;

    font-size:11px;
    font-weight:700;
}

.bd-conf-edit-input {
    width:100%;
    min-height:44px;

    padding:0 13px;

    border:1px solid #DDE0E5;
    border-radius:9px;

    outline:0;

    font-size:12px;
}

.bd-conf-edit-input:focus {
    border-color:var(--navy);

    box-shadow:0 0 0 3px rgba(36,27,82,.07);
}

.bd-conf-edit-date-time {
    display:grid;

    grid-template-columns:1fr 1fr;

    gap:12px;
}

.bd-conf-current-poster {
    width:100%;

    overflow:hidden;

    border-radius:11px;

    background:#F5F6F8;
}

.bd-conf-current-poster img {
    display:block;

    width:100%;
    max-height:360px;

    object-fit:cover;
}

.bd-conf-poster-change {
    margin-top:13px;
}

.bd-conf-poster-change input {
    width:100%;

    padding:10px;

    border:1px dashed #CBD0D7;
    border-radius:9px;

    font-size:10px;
}

.bd-conf-edit-actions {
    grid-column:1 / -1;

    display:flex;
    justify-content:flex-end;

    gap:10px;

    padding-top:18px;

    border-top:1px solid var(--line);
}

.bd-conf-edit-actions a,
.bd-conf-edit-actions button {
    min-height:43px;

    display:inline-flex;
    align-items:center;
    justify-content:center;

    padding:0 18px;

    border-radius:9px;

    font-size:11px;
    font-weight:700;
}

.bd-conf-edit-cancel {
    border:1px solid var(--line);

    color:#626771!important;

    text-decoration:none!important;
}

.bd-conf-edit-save {
    border:0;

    background:var(--orange);

    color:#FFF;

    cursor:pointer;
}

@media(max-width:800px) {
    .bd-conf-edit-grid {
        grid-template-columns:1fr;
    }
}

@media(max-width:600px) {
    .bd-conf-edit-date-time {
        grid-template-columns:1fr;
    }

    .bd-conf-edit-header {
        flex-direction:column;
        align-items:flex-start;
    }
}
</style>


<div class="bd-conf-edit">

    <div class="bd-conf-edit-shell">


        <header class="bd-conf-edit-header">

            <div>

                <h1>
                    Edit Conference
                </h1>

                <p>
                    Perbarui jadwal dan informasi conference.
                </p>

            </div>


            <a
                href="{{ route('admin.conferences.index') }}"
                class="bd-conf-edit-back"
            >
                ← Daftar Conference
            </a>

        </header>


        <form
            method="POST"
            action="{{ route('admin.conferences.update', $conference) }}"
            enctype="multipart/form-data"
            class="bd-conf-edit-grid"
        >

            @csrf
            @method('PUT')


            <div>

                <section class="bd-conf-edit-panel">

                    <div class="bd-conf-edit-head">

                        <h2>
                            Informasi Conference
                        </h2>

                    </div>


                    <div class="bd-conf-edit-body">


                        <div class="bd-conf-edit-field">

                            <label class="bd-conf-edit-label">
                                Judul Conference *
                            </label>

                            <input
                                type="text"
                                name="title"
                                value="{{ old('title', $conference->title) }}"
                                class="bd-conf-edit-input"
                                required
                            >

                        </div>



                        {{-- DATE + TIME --}}

                        <div class="bd-conf-edit-field">

                            <div class="bd-conf-edit-date-time">

                                <div>

                                    <label class="bd-conf-edit-label">
                                        Tanggal
                                    </label>

                                    <input
                                        type="date"
                                        name="event_date"
                                        value="{{ old(
                                            'event_date',
                                            $conference->event_date
                                                ? \Carbon\Carbon::parse($conference->event_date)->format('Y-m-d')
                                                : ''
                                        ) }}"
                                        class="bd-conf-edit-input"
                                    >

                                </div>


                                <div>

                                    <label class="bd-conf-edit-label">
                                        Waktu
                                    </label>

                                    <input
                                        type="time"
                                        name="event_time"
                                        value="{{ old(
                                            'event_time',
                                            $conference->event_time
                                                ? \Carbon\Carbon::parse($conference->event_time)->format('H:i')
                                                : ''
                                        ) }}"
                                        class="bd-conf-edit-input"
                                    >

                                </div>

                            </div>

                        </div>



                        {{-- LOCATION --}}

                        <div class="bd-conf-edit-field">

                            <label class="bd-conf-edit-label">
                                Tempat / Lokasi
                            </label>

                            <input
                                type="text"
                                name="location"
                                value="{{ old(
                                    'location',
                                    $conference->location
                                ) }}"
                                class="bd-conf-edit-input"
                            >

                        </div>

                    </div>

                </section>



                <section class="bd-conf-edit-panel">

                    <div class="bd-conf-edit-head">

                        <h2>
                            Deskripsi
                        </h2>

                    </div>


                    <div class="bd-conf-edit-body">

                        @include(
                            'admin.partials.rich-text-editor',
                            [
                                'name' => 'description',
                                'label' => '',
                                'value' => old(
                                    'description',
                                    $conference->description
                                )
                            ]
                        )

                    </div>

                </section>

            </div>



            {{-- POSTER --}}

            <aside>

                <section class="bd-conf-edit-panel">

                    <div class="bd-conf-edit-head">

                        <h2>
                            Poster Conference
                        </h2>

                    </div>


                    <div class="bd-conf-edit-body">


                        @if($conference->poster)

                            <div class="bd-conf-current-poster">

                                <img
                                    src="{{ asset('storage/' . $conference->poster) }}"
                                    alt="{{ $conference->title }}"
                                >

                            </div>

                        @endif


                        <div class="bd-conf-poster-change">

                            <input
                                type="file"
                                name="poster"
                                accept="image/jpeg,image/png,image/webp"
                            >

                        </div>

                    </div>

                </section>

            </aside>



            <div class="bd-conf-edit-actions">

                <a
                    href="{{ route('admin.conferences.index') }}"
                    class="bd-conf-edit-cancel"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="bd-conf-edit-save"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection