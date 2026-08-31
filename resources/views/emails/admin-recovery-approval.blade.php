<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Permohonan Akses Admin</title>
</head>

<body style="margin:0;padding:0;background:#f4f5f8;font-family:Arial,Helvetica,sans-serif;color:#252533;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:35px 15px;background:#f4f5f8;">
    <tr>
        <td align="center">

            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:620px;background:#ffffff;border-radius:18px;overflow:hidden;">

                <tr>
                    <td style="padding:30px;background:#241B52;color:#ffffff;">
                        <div style="font-size:12px;font-weight:700;color:#EF5843;text-transform:uppercase;letter-spacing:1px;">
                            Baca Dulu Security
                        </div>

                        <h1 style="margin:9px 0 0;font-size:25px;">
                            Permohonan Akses Admin
                        </h1>

                        <p style="margin:10px 0 0;color:#c9c5dc;font-size:13px;line-height:1.6;">
                            Seseorang mengajukan permohonan untuk membuat akses baru ke Admin CMS Baca Dulu.
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:30px;">

                        <p style="margin:0 0 20px;font-size:14px;line-height:1.7;">
                            Silakan periksa identitas pemohon berikut sebelum memberikan persetujuan.
                        </p>

                        <table width="100%" cellpadding="10" cellspacing="0" style="background:#f8f8fb;border-radius:12px;font-size:13px;">
                            <tr>
                                <td style="color:#777;">Nomor</td>
                                <td align="right"><strong>#{{ $recovery->id }}</strong></td>
                            </tr>

                            <tr>
                                <td style="color:#777;">Nama</td>
                                <td align="right"><strong>{{ $recovery->requester_name }}</strong></td>
                            </tr>

                            <tr>
                                <td style="color:#777;">Jabatan</td>
                                <td align="right"><strong>{{ $recovery->requester_position }}</strong></td>
                            </tr>

                            <tr>
                                <td style="color:#777;">Email</td>
                                <td align="right"><strong>{{ $recovery->requester_email }}</strong></td>
                            </tr>

                            <tr>
                                <td style="color:#777;">WhatsApp</td>
                                <td align="right"><strong>{{ $recovery->requester_phone }}</strong></td>
                            </tr>

                            <tr>
                                <td style="color:#777;">IP</td>
                                <td align="right"><strong>{{ $recovery->request_ip ?? '-' }}</strong></td>
                            </tr>
                        </table>

                        <div style="margin-top:20px;padding:16px;background:#fff8ee;border-left:4px solid #F7AA35;border-radius:8px;">
                            <div style="font-size:11px;font-weight:700;color:#8b641c;text-transform:uppercase;">
                                Alasan
                            </div>

                            <p style="margin:7px 0 0;font-size:13px;line-height:1.6;color:#59451f;">
                                {{ $recovery->reason }}
                            </p>
                        </div>

                        @if($recovery->notes)
                            <div style="margin-top:14px;padding:16px;background:#f7f7f9;border-radius:8px;">
                                <div style="font-size:11px;font-weight:700;color:#777;text-transform:uppercase;">
                                    Keterangan
                                </div>

                                <p style="margin:7px 0 0;font-size:13px;line-height:1.6;">
                                    {{ $recovery->notes }}
                                </p>
                            </div>
                        @endif

                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:28px;">
                            <tr>
                                <td width="49%" align="center">
                                    <a
                                        href="{{ $rejectUrl }}"
                                        style="display:block;padding:14px 15px;background:#fff1f1;color:#b42323;text-decoration:none;border-radius:10px;font-size:13px;font-weight:700;"
                                    >
                                        Tolak
                                    </a>
                                </td>

                                <td width="2%"></td>

                                <td width="49%" align="center">
                                    <a
                                        href="{{ $approveUrl }}"
                                        style="display:block;padding:14px 15px;background:#241B52;color:#ffffff;text-decoration:none;border-radius:10px;font-size:13px;font-weight:700;"
                                    >
                                        Ya, Setujui Permohonan
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <p style="margin:24px 0 0;color:#92929b;font-size:11px;line-height:1.7;text-align:center;">
                            Link persetujuan berlaku selama 60 menit.
                            Jangan meneruskan email ini kepada pihak lain.
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>