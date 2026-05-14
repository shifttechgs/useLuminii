<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TeamMemberInvite extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $inviteeName,
        public string $businessName,
        public string $role,
        public string $tempPassword,
        public string $loginUrl,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: "You've been invited to join {$this->businessName} on Luminii CRM");
    }

    public function content(): Content
    {
        return new Content(view: 'emails.team-member-invite');
    }
}

