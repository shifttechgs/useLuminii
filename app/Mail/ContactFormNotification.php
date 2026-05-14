<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ContactFormNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $formData;
    public $savedToApi;

    /**
     * Create a new message instance.
     */
    public function __construct(array $formData, bool $savedToApi = false)
    {
        $this->formData = $formData;
        $this->savedToApi = $savedToApi;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: 'New Contact Form Submission - ' . $this->formData['name'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact-form',
            with: [
                'formData' => $this->formData,
                'savedToApi' => $this->savedToApi,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
