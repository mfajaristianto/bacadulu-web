<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $otp;

    public array $loginInfo;

    public function __construct(
        string $otp,
        array $loginInfo = []
    ) {
        $this->otp = $otp;

        $this->loginInfo = $loginInfo;
    }

    public function build()
    {
        $googleEmail =
            $this->loginInfo[
                'google_email'
            ]
            ?? 'Akun Google';

        return $this
            ->subject(
                'Kode OTP Admin Baca Dulu — ' .
                $googleEmail
            )
            ->view(
                'emails.admin-otp'
            );
    }
}