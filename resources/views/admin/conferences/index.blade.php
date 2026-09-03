@extends('layouts.admin')

@section('title', 'Kelola Conference')

@section('content')

<style>
.bd-conf-index {
    --navy:#241B52;
    --orange:#EF5843;
    --line:#E6E8EC;
    --muted:#858B95;

    padding:32px 0 55px;

    font-family:'Inter',sans-serif;
}

.bd-conf-index-shell {
    width:min(calc(100% - 40px),1250px);

    margin:auto;
}

.bd-conf-index-header {
    display:flex;
    align-items:flex-end;
    justify-content:space-between;

    gap:20px;

    margin-bottom:24px;
}

.bd-conf-index-header h1 {
    margin:0;

    color:var(--navy);

    font-family:'Poppins',sans-serif;
    font-size:32px;
}

.bd-conf-index-header p {
    margin:5px 0 0;

    color:var(--muted);

    font-size:11px;
}

.bd-conf-add {
    padding:12px 16px;

    border-radius:9px;

    background:var(--orange);

    color:#FFF!important;

    text-decoration:none!important;

    font-size:11px;
    font-weight:700;
}

.bd-conf-success {
    margin-bottom:18px;

    padding:12px 14px;

    border:1px solid #BCE2C9;
    border-radius:9px;

    background:#F1FBF5;

    color:#267647;

    font-size:11px;
}

.bd-conf-table-wrap {
    overflow-x:auto;

    border:1px solid var(--line);
    border-radius:14px;

    background:#FFF;
}

.bd-conf-table {
    width:100%;

    border-collapse:collapse;
}

.bd-conf-table th {
    padding:12px 14px;

    background:#F7F8FA;

    color:#737984;

    font-size:9px;
    font-weight:800;

    text-align:left;

    text-transform:uppercase;
}

.bd-conf-table td {
    padding:14px;

    border-top:1px solid var(--line);

    color:#555B64;

    font-size:11px;

    vertical-align:middle;
}

.bd-conf-item {
    display:flex;
    align-items:center;

    gap:12px;
}

.bd-conf-poster {
    width:56px;
    height:56px;

    flex-shrink:0;

    overflow:hidden;

    border-radius:8px;

    background:var(--navy);
}

.bd-conf-poster img {
    width:100%;
    height:100%;

    object-fit:cover;
}

.bd-conf-item-title {
    max-width:330px;

    color:var(--navy);

    font-family:'Poppins',sans-serif;

    font-size:12px;
    font-weight:600;

    line-height:1.4;
}

.bd-conf-time {
    color:var(--orange);

    font-weight:700;
}

.bd-conf-location {
    max-width:210px;

    line-height:1.45;
}

.bd-conf-actions {
    display:flex;

    gap:7px;
}

.bd-conf-edit,
.bd-conf-delete {
    padding:8px 10px;

    border-radius:7px;

    font-size:9px;
    font-weight:700;
}

.bd-conf-edit {
    border:1px solid var(--line);

    color:var(--navy)!important;

    text-decoration:none!important;
}

.bd-conf-delete {
    border:1px solid #F0D0CB;

    background:#FFF8F7;

    color:#BF4131;

    cursor:pointer;
}

@media(max-width:700px) {
    .bd-conf-index-header {
        flex-direction:column;
        align-items:flex-start;
    }

    .bd-conf-table {
        min-width:850px;
    }
}
</style>


<div class="bd-conf-index">

    <div class="bd-conf-index-shell">


        <header class="bd-conf-index-header">

            <div>

                <h1>
                    Kelola Conference
                </h1>

                <p>
                    Kelola jadwal, waktu, lokasi dan informasi conference.
                </p>

            </div>


            <a
                href="{{ route('admin.conferences.create') }}"
                class="bd-conf-add"
            >
                + Tambah Conference
            </a>

        </header>


        @if(session('success'))

            <div class="bd-conf-success">
                {{ session('success') }}
            </div>

        @endif


        <div class="bd-conf-table-wrap">

            <table class="bd-conf-table">

                <thead>

                    <tr>

                        <th>
                            Conference
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Waktu
                        </th>

                        <th>
                            Tempat / Lokasi
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($conferences as $conference)

                        <tr>

                            <td>

                                <div class="bd-conf-item">


                                    <div class="bd-conf-poster">

                                        @if($conference->poster)

                                            <img
                                                src="{{ asset('storage/' . $conference->poster) }}"
                                                alt="{{ $conference->title }}"
                                            >

                                        @endif

                                    </div>


                                    <div class="bd-conf-item-title">

                                        {{ $conference->title }}

                                    </div>

                                </div>

                            </td>



                            <td>

                                @if($conference->event_date)

                                    {{
                                        \Carbon\Carbon::parse(
                                            $conference->event_date
                                        )->translatedFormat('d M Y')
                                    }}

                                @else

                                    -

                                @endif

                            </td>



                            <td>

                                @if($conference->event_time)

                                    <span class="bd-conf-time">

                                        {{
                                            \Carbon\Carbon::parse(
                                                $conference->event_time
                                            )->format('H:i')
                                        }}
                                        WIB

                                    </span>

                                @else

                                    -

                                @endif

                            </td>



                            <td>

                                <div class="bd-conf-location">

                                    {{ $conference->location ?: '-' }}

                                </div>

                            </td>



                            <td>

                                <div class="bd-conf-actions">

                                    <a
                                        href="{{ route('admin.conferences.edit', $conference) }}"
                                        class="bd-conf-edit"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        method="POST"
                                        action="{{ route('admin.conferences.destroy', $conference) }}"
                                    >

                                        @csrf
                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="bd-conf-delete"
                                            onclick="return confirm('Hapus conference ini?')"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" style="text-align:center;padding:50px;">

                                Belum ada conference.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection