<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Google OAuth
    |--------------------------------------------------------------------------
    |
    | Digunakan untuk login user/penulis dan verifikasi Google admin.
    |
    */

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Authentication
    |--------------------------------------------------------------------------
    |
    | ADMIN_EMAIL
    | Email akun admin utama website.
    |
    | ADMIN_OTP_EMAIL
    | Email keamanan yang menerima OTP login admin.
    |
    | ADMIN_RECOVERY_APPROVER_EMAIL
    | Email pihak yang berhak menyetujui / menolak permohonan
    | password akses tambahan.
    |
    */

    'admin_auth' => [
        'email' => env('ADMIN_EMAIL'),
        'otp_email' => env('ADMIN_OTP_EMAIL'),
        'recovery_approver_email' => env('ADMIN_RECOVERY_APPROVER_EMAIL'),
    ],

];