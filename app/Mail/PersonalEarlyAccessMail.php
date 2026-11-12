<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Confirmation for someone who joined early access from the Personal quote/invoice maker.
 */
class PersonalEarlyAccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ?string $name = null,
        public ?string $vote = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: "You're on the useLuminii early-access list");
    }

    public function content(): Content
    {
        return new Content(markdown: 'mail.personal-early-access', with: [
            'name'       => $this->name,
            'vote'       => $this->vote,
            'builderUrl' => url('/personal'),
            'privacyUrl' => url('/privacy-policy'),
            'logoUrl'    => asset('assets/images/logo/useluminii_logos/useluminii_dark.png'),
        ]);
    }
}
