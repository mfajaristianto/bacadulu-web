<?php

namespace App\Mail;

use App\Models\AdminRecoveryRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminRecoveryApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public AdminRecoveryRequest $recovery,
        public string $approveUrl,
        public string $rejectUrl
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Permohonan Akses Admin Baca Dulu'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-recovery-approval'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}