<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Branded HTML (table layout, inline styles) with a plain-text alternative.
        $mail = $this->view('mail.contact_form')
            ->text('mail.contact_form_text')
            ->with('data', $this->data)
            // demo bookings set their own subject, e.g. "New Demo Booking - Plumbing (2-5 people)"
            ->subject($this->data['subject'] ?? 'New Contact Form Submission');

        // Replying goes straight to the prospect, not back to our own address.
        if (! empty($this->data['email'])) {
            $mail->replyTo($this->data['email'], $this->data['fullname'] ?? null);
        }

        return $mail;

    }
}
