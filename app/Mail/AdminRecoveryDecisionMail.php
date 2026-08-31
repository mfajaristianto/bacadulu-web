<?php

namespace App\Mail;

use App\Models\AdminRecoveryRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminRecoveryDecisionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public AdminRecoveryRequest $recovery,
        public ?string $createPasswordUrl = null
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->recovery->status === 'approved'
            ? 'Permohonan Akses Admin Disetujui'
            : 'Permohonan Akses Admin Ditolak';

        return new Envelope(
            subject: $subject
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-recovery-decision'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}