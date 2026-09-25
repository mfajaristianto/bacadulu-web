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

    /*
    |--------------------------------------------------------------------------
    | BATAS MAKSIMAL KEMIRIPAN INTERNAL ARTIKEL
    |--------------------------------------------------------------------------
    |
    | Nilai ini adalah batas similarity internal BacaDulu, bukan skor
    | Turnitin/iThenticate. Default 20%. Bisa diubah melalui .env:
    |
    | BACA_ORIGINALITY_MAX_SIMILARITY=20
    |
    */

    'originality' => [
        /*
        | Di atas batas ini artikel wajib Originality Review manual.
        | Tepat 20% masih tidak otomatis dikunci.
        */
        'max_similarity' => (float) env(
            'BACA_ORIGINALITY_MAX_SIMILARITY',
            20
        ),

        /*
        | Di atas batas ini CMS menampilkan peringatan kuning.
        */
        'warning_similarity' => (float) env(
            'BACA_ORIGINALITY_WARNING_SIMILARITY',
            10
        ),

        /*
        | Maksimal sumber teratas yang ditampilkan ke admin.
        */
        'top_sources' => (int) env(
            'BACA_ORIGINALITY_TOP_SOURCES',
            5
        ),

        /*
        | Maksimal artikel terdahulu yang diperiksa per scan.
        */
        'candidate_limit' => (int) env(
            'BACA_ORIGINALITY_CANDIDATE_LIMIT',
            1000
        ),
    ],

];