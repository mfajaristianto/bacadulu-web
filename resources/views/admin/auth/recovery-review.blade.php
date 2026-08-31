<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Review Permohonan Admin - Baca Dulu</title>

    <style>
        *{box-sizing:border-box}
        body{
            margin:0;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;
            background:#f4f5f8;
            font-family:Arial,Helvetica,sans-serif;
            color:#241B52
        }
        .card{
            width:min(100%,560px);
            overflow:hidden;
            border-radius:22px;
            background:#fff;
            box-shadow:0 24px 70px rgba(36,27,82,.12)
        }
        .header{
            padding:30px;
            background:#241B52;
            color:#fff
        }
        .header span{
            color:#EF5843;
            font-size:11px;
            font-weight:800;
            text-transform:uppercase
        }
        .header h1{
            margin:8px 0 0;
            font-size:26px
        }
        .body{padding:30px}
        .info{
            padding:18px;
            border-radius:14px;
            background:#f7f7fa
        }
        .row{
            display:flex;
            justify-content:space-between;
            gap:20px;
            padding:9px 0;
            border-bottom:1px solid #e7e7ed;
            font-size:12px
        }
        .row:last-child{border-bottom:0}
        .row span{color:#888}
        .reason{
            margin-top:18px;
            padding:16px;
            border-left:4px solid #F7AA35;
            border-radius:9px;
            background:#fff8ed;
            font-size:13px;
            line-height:1.7
        }
        .notice{
            margin-top:18px;
            padding:14px;
            border-radius:10px;
            background:#eff6ff;
            color:#1e40af;
            font-size:12px;
            line-height:1.6
        }
        .button{
            width:100%;
            min-height:50px;
            margin-top:22px;
            border:0;
            border-radius:12px;
            color:#fff;
            font-size:13px;
            font-weight:800;
            cursor:pointer
        }
        .approve{background:#241B52}
        .reject{background:#b42323}
    </style>
</head>

<body>

<div class="card">

    <div class="header">
        <span>Baca Dulu Security</span>

        <h1>
            {{ $decision === 'approve'
                ? 'Setujui Permohonan'
                : 'Tolak Permohonan' }}
        </h1>
    </div>

    <div class="body">

        <div class="info">

            <div class="row">
                <span>Nomor</span>
                <strong>#{{ $recovery->id }}</strong>
            </div>

            <div class="row">
                <span>Nama</span>
                <strong>{{ $recovery->requester_name }}</strong>
            </div>

            <div class="row">
                <span>Jabatan</span>
                <strong>{{ $recovery->requester_position }}</strong>
            </div>

            <div class="row">
                <span>Email</span>
                <strong>{{ $recovery->requester_email }}</strong>
            </div>

            <div class="row">
                <span>Status</span>
                <strong>{{ strtoupper($recovery->status) }}</strong>
            </div>

        </div>

        <div class="reason">
            <strong>Alasan permohonan</strong><br>
            {{ $recovery->reason }}
        </div>

        @if($alreadyProcessed)

            <div class="notice">
                Permohonan ini sudah diproses dengan status
                <strong>{{ strtoupper($recovery->status) }}</strong>.
            </div>

        @elseif($actionUrl)

            <form
                method="POST"
                action="{{ $actionUrl }}"
            >
                @csrf

                <button
                    type="submit"
                    class="button {{ $decision === 'approve' ? 'approve' : 'reject' }}"
                >
                    {{ $decision === 'approve'
                        ? 'Ya, Setujui Permohonan'
                        : 'Ya, Tolak Permohonan' }}
                </button>
            </form>

        @endif

    </div>

</div>

</body>
</html>