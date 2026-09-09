<?php

$callCenter = env(
    'BACA_CALL_CENTER',
    '+62 851-3946-1070'
);

/*
|--------------------------------------------------------------------------
| FORMAT NOMOR WHATSAPP
|--------------------------------------------------------------------------
|
| Nomor pada .env boleh ditulis:
|
| +62 851-3946-1070
| 6285139461070
| 085139461070
|
| Semua akan otomatis diubah menjadi:
|
| 6285139461070
|
| supaya bisa digunakan untuk wa.me
|
*/

$whatsappNumber = preg_replace(
    '/[^0-9]/',
    '',
    $callCenter
);

/*
|--------------------------------------------------------------------------
| NORMALISASI NOMOR INDONESIA
|--------------------------------------------------------------------------
*/

if (
    str_starts_with(
        $whatsappNumber,
        '0'
    )
) {
    $whatsappNumber =
        '62' .
        substr(
            $whatsappNumber,
            1
        );
}

return [

    /*
    |--------------------------------------------------------------------------
    | NOMOR YANG DITAMPILKAN
    |--------------------------------------------------------------------------
    */

    'call_center' =>
        $callCenter,

    /*
    |--------------------------------------------------------------------------
    | NOMOR UNTUK LINK WHATSAPP
    |--------------------------------------------------------------------------
    */

    'call_center_wa' =>
        $whatsappNumber,

];