<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Permohonan Akses Admin</title>
</head>

<body style="margin:0;padding:0;background:#f4f5f8;font-family:Arial,Helvetica,sans-serif;color:#252533;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:35px 15px;background:#f4f5f8;">
    <tr>
        <td align="center">

            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:580px;background:#ffffff;border-radius:18px;overflow:hidden;">

                <tr>
                    <td style="padding:30px;background:#241B52;color:#ffffff;text-align:center;">

                        <div style="font-size:12px;font-weight:700;color:#EF5843;text-transform:uppercase;letter-spacing:1px;">
                            Baca Dulu Security
                        </div>

                        @if($recovery->status === 'approved')
                            <h1 style="margin:10px 0 0;font-size:25px;">
                                Permohonan Disetujui
                            </h1>
                        @else
                            <h1 style="margin:10px 0 0;font-size:25px;">
                                Permohonan Ditolak
                            </h1>
                        @endif

                    </td>
                </tr>

                <tr>
                    <td style="padding:32px;text-align:center;">

                        <p style="margin:0;color:#555563;font-size:14px;line-height:1.8;">
                            Halo <strong>{{ $recovery->requester_name }}</strong>,
                        </p>

                        @if($recovery->status === 'approved')

                            <p style="margin:14px 0 0;color:#555563;font-size:14px;line-height:1.8;">
                                Permohonan akses Admin Baca Dulu Anda telah disetujui.
                                Silakan buat password akses pribadi melalui tombol di bawah.
                            </p>

                            <div style="margin-top:22px;padding:16px;background:#f7f7f9;border-radius:10px;font-size:12px;color:#555563;">
                                Nomor Permohonan:
                                <strong>#{{ $recovery->id }}</strong>
                            </div>

                            @if($createPasswordUrl)

                                <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:28px;">
                                    <tr>
                                        <td align="center">

                                            <a
                                                href="{{ $createPasswordUrl }}"
                                                style="display:inline-block;padding:15px 28px;background:#241B52;color:#ffffff;text-decoration:none;border-radius:10px;font-size:13px;font-weight:700;"
                                            >
                                                Buat Password Akses
                                            </a>

                                        </td>
                                    </tr>
                                </table>

                                <p style="margin:20px 0 0;color:#92929b;font-size:11px;line-height:1.7;">
                                    Link pembuatan password berlaku selama 60 menit.
                                    Jangan membagikan link ini kepada orang lain.
                                </p>

                            @else

                                <div style="margin-top:22px;padding:14px;background:#fff1f1;border-radius:10px;color:#b42323;font-size:12px;line-height:1.6;">
                                    Link pembuatan password tidak tersedia.
                                    Silakan hubungi administrator.
                                </div>

                            @endif

                        @else

                            <p style="margin:14px 0 0;color:#555563;font-size:14px;line-height:1.8;">
                                Permohonan akses Admin Baca Dulu Anda belum dapat disetujui.
                                Silakan hubungi pihak yang bertanggung jawab apabila diperlukan.
                            </p>

                            <div style="margin-top:22px;padding:16px;background:#f7f7f9;border-radius:10px;font-size:12px;color:#555563;">
                                Nomor Permohonan:
                                <strong>#{{ $recovery->id }}</strong>
                            </div>

                        @endif

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>