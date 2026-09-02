@extends('layouts.admin')

@section('title', 'Tambah Conference')

@section('content')

<style>
.bd-conf-form-page {
    --navy: #241B52;
    --orange: #EF5843;
    --line: #E5E7EB;
    --muted: #77808C;
    --soft: #F7F8FA;

    padding: 32px 0 55px;

    font-family: 'Inter', sans-serif;
}

.bd-conf-form-shell {
    width: min(calc(100% - 40px), 1100px);
    margin-inline: auto;
}

.bd-conf-form-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;

    gap: 24px;

    margin-bottom: 24px;
}

.bd-conf-form-header h1 {
    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;
    font-size: 32px;
    font-weight: 700;
}

.bd-conf-form-header p {
    margin: 6px 0 0;

    color: var(--muted);

    font-size: 12px;
}

.bd-conf-back {
    padding: 11px 15px;

    border: 1px solid var(--line);
    border-radius: 9px;

    background: #FFF;

    color: var(--navy) !important;

    font-size: 11px;
    font-weight: 700;

    text-decoration: none !important;
}

.bd-conf-grid {
    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        320px;

    gap: 20px;
}

.bd-conf-panel {
    overflow: hidden;

    border: 1px solid var(--line);
    border-radius: 14px;

    background: #FFF;
}

.bd-conf-panel + .bd-conf-panel {
    margin-top: 18px;
}

.bd-conf-panel-head {
    padding: 17px 19px;

    border-bottom: 1px solid var(--line);
}

.bd-conf-panel-head h2 {
    margin: 0;

    color: var(--navy);

    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    font-weight: 650;
}

.bd-conf-panel-head p {
    margin: 4px 0 0;

    color: #90959F;

    font-size: 10px;
}

.bd-conf-panel-body {
    padding: 19px;
}

.bd-conf-field + .bd-conf-field {
    margin-top: 18px;
}

.bd-conf-label {
    display: block;

    margin-bottom: 7px;

    color: #343840;

    font-size: 11px;
    font-weight: 700;
}

.bd-conf-input {
    width: 100%;
    min-height: 44px;

    padding: 0 13px;

    border: 1px solid #DDE0E5;
    border-radius: 9px;

    outline: 0;

    color: #30343B;

    font-size: 12px;
}

.bd-conf-input:focus {
    border-color: var(--navy);

    box-shadow:
        0 0 0 3px
        rgba(36,27,82,.07);
}

.bd-conf-date-time {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 12px;
}

.bd-conf-help {
    margin-top: 5px;

    color: #9A9FA8;

    font-size: 9px;
}

.bd-conf-error {
    margin-top: 5px;

    color: #C64030;

    font-size: 9px;
}


/* POSTER */

.bd-conf-upload {
    position: relative;

    overflow: hidden;

    border: 1px dashed #CBD0D7;
    border-radius: 11px;

    background: var(--soft);
}

.bd-conf-upload-label {
    min-height: 220px;

    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;

    padding: 20px;

    text-align: center;

    cursor: pointer;
}

.bd-conf-upload-label strong {
    color: var(--navy);

    font-size: 12px;
}

.bd-conf-upload-label span {
    margin-top: 5px;

    color: #969BA4;

    font-size: 9px;
}

.bd-conf-file {
    position: absolute;

    width: 1px;
    height: 1px;

    opacity: 0;
}

.bd-conf-preview {
    position: relative;

    display: none;

    aspect-ratio: 4 / 5;
}

.bd-conf-preview.is-visible {
    display: block;
}

.bd-conf-preview img {
    display: block;

    width: 100%;
    height: 100%;

    object-fit: cover;
}

.bd-conf-remove {
    position: absolute;

    top: 9px;
    right: 9px;

    width: 32px;
    height: 32px;

    border: 0;
    border-radius: 50%;

    background: rgba(0,0,0,.75);
    color: white;

    cursor: pointer;
}


/* ACTION */

.bd-conf-actions {
    grid-column: 1 / -1;

    display: flex;
    justify-content: flex-end;

    gap: 10px;

    padding-top: 18px;

    border-top: 1px solid var(--line);
}

.bd-conf-cancel,
.bd-conf-save {
    min-height: 43px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 0 18px;

    border-radius: 9px;

    font-size: 11px;
    font-weight: 700;

    text-decoration: none !important;
}

.bd-conf-cancel {
    border: 1px solid var(--line);

    color: #60656E !important;
}

.bd-conf-save {
    border: 0;

    background: var(--orange);

    color: #FFF;

    cursor: pointer;
}

@media(max-width:800px) {
    .bd-conf-grid {
        grid-template-columns: 1fr;
    }
}

@media(max-width:600px) {
    .bd-conf-form-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .bd-conf-date-time {
        grid-template-columns: 1fr;
    }
}
</style>


<div class="bd-conf-form-page">

    <div class="bd-conf-form-shell">

        <header class="bd-conf-form-header">

            <div>

                <h1>Tambah Conference</h1>

                <p>
                    Lengkapi informasi pelaksanaan conference.
                </p>

            </div>

            <a
                href="{{ route('admin.conferences.index') }}"
                class="bd-conf-back"
            >
                ← Daftar Conference
            </a>

        </header>


        @if($errors->any())

            <div
                style="
                    margin-bottom:18px;
                    padding:13px 15px;
                    border:1px solid #F2C5BD;
                    border-radius:9px;
                    background:#FFF7F5;
                    color:#A53D2E;
                    font-size:11px;
                "
            >

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        <form
            method="POST"
            action="{{ route('admin.conferences.store') }}"
            enctype="multipart/form-data"
            class="bd-conf-grid"
        >

            @csrf


            <div>

                <section class="bd-conf-panel">

                    <div class="bd-conf-panel-head">

                        <h2>
                            Informasi Conference
                        </h2>

                        <p>
                            Judul, tanggal, waktu dan lokasi pelaksanaan.
                        </p>

                    </div>


                    <div class="bd-conf-panel-body">


                        <div class="bd-conf-field">

                            <label
                                class="bd-conf-label"
                                for="title"
                            >
                                Judul Conference *
                            </label>

                            <input
                                id="title"
                                type="text"
                                name="title"
                                value="{{ old('title') }}"
                                class="bd-conf-input"
                                required
                            >

                            @error('title')
                                <div class="bd-conf-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>



                        {{-- DATE + TIME --}}

                        <div class="bd-conf-field">

                            <div class="bd-conf-date-time">


                                <div>

                                    <label
                                        class="bd-conf-label"
                                        for="event_date"
                                    >
                                        Tanggal
                                    </label>

                                    <input
                                        id="event_date"
                                        type="date"
                                        name="event_date"
                                        value="{{ old('event_date') }}"
                                        class="bd-conf-input"
                                    >

                                </div>


                                <div>

                                    <label
                                        class="bd-conf-label"
                                        for="event_time"
                                    >
                                        Waktu
                                    </label>

                                    <input
                                        id="event_time"
                                        type="time"
                                        name="event_time"
                                        value="{{ old('event_time') }}"
                                        class="bd-conf-input"
                                    >

                                    <div class="bd-conf-help">
                                        Waktu pelaksanaan conference.
                                    </div>

                                </div>

                            </div>

                            @error('event_date')
                                <div class="bd-conf-error">
                                    {{ $message }}
                                </div>
                            @enderror

                            @error('event_time')
                                <div class="bd-conf-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>



                        {{-- LOCATION --}}

                        <div class="bd-conf-field">

                            <label
                                class="bd-conf-label"
                                for="location"
                            >
                                Tempat / Lokasi
                            </label>

                            <input
                                id="location"
                                type="text"
                                name="location"
                                value="{{ old('location') }}"
                                class="bd-conf-input"
                                placeholder="Contoh: Jakarta, Zoom Meeting, Hybrid"
                            >

                            @error('location')
                                <div class="bd-conf-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </section>


                <section class="bd-conf-panel">

                    <div class="bd-conf-panel-head">

                        <h2>
                            Deskripsi Conference
                        </h2>

                    </div>

                    <div class="bd-conf-panel-body">

                        @include(
                            'admin.partials.rich-text-editor',
                            [
                                'name' => 'description',
                                'label' => '',
                                'value' => old('description')
                            ]
                        )

                    </div>

                </section>

            </div>



            {{-- POSTER --}}

            <aside>

                <section class="bd-conf-panel">

                    <div class="bd-conf-panel-head">

                        <h2>
                            Poster Conference
                        </h2>

                    </div>


                    <div class="bd-conf-panel-body">

                        <div class="bd-conf-upload">

                            <div
                                class="bd-conf-preview"
                                id="posterPreview"
                            >

                                <img
                                    src=""
                                    alt="Preview"
                                    id="posterImage"
                                >

                                <button
                                    type="button"
                                    class="bd-conf-remove"
                                    id="posterRemove"
                                >
                                    ×
                                </button>

                            </div>


                            <label
                                class="bd-conf-upload-label"
                                for="poster"
                                id="posterLabel"
                            >

                                <strong>
                                    Upload Poster
                                </strong>

                                <span>
                                    JPG, PNG atau WEBP
                                </span>

                            </label>


                            <input
                                id="poster"
                                type="file"
                                name="poster"
                                accept="image/jpeg,image/png,image/webp"
                                class="bd-conf-file"
                            >

                        </div>

                    </div>

                </section>

            </aside>



            <div class="bd-conf-actions">

                <a
                    href="{{ route('admin.conferences.index') }}"
                    class="bd-conf-cancel"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="bd-conf-save"
                >
                    Simpan Conference
                </button>

            </div>

        </form>

    </div>

</div>


<script>
(() => {

    const input = document.getElementById('poster');
    const preview = document.getElementById('posterPreview');
    const image = document.getElementById('posterImage');
    const label = document.getElementById('posterLabel');
    const remove = document.getElementById('posterRemove');

    input.addEventListener('change', event => {

        const file = event.target.files[0];

        if (!file) return;

        const reader = new FileReader();

        reader.onload = e => {

            image.src = e.target.result;

            preview.classList.add('is-visible');

            label.style.display = 'none';
        };

        reader.readAsDataURL(file);
    });


    remove.addEventListener('click', () => {

        input.value = '';

        image.src = '';

        preview.classList.remove('is-visible');

        label.style.display = 'flex';
    });

})();
</script>

@endsection