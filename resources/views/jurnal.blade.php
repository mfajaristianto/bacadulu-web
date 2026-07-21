<!DOCTYPE html>
<html>
<head>
    <title>Daftar Jurnal</title>
</head>
<body>
    <h1>Daftar Jurnal</h1>

    @foreach($jurnals as $jurnal)
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
            <h3>{{ $jurnal->judul }}</h3>
            <p>{{ $jurnal->deskripsi }}</p>

            @if($jurnal->file_pdf)
                <a href="{{ asset('storage/' . $jurnal->file_pdf) }}" target="_blank">Download PDF</a>
            @endif
        </div>
    @endforeach
</body>
</html>