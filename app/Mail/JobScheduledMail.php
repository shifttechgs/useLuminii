<?php

namespace App\Mail;

use App\Models\Job;
use App\Models\BusinessSetup;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobScheduledMail extends Mailable
{
    use Queueable, SerializesModels;

    public BusinessSetup $business;

    public function __construct(public Job $job)
    {
        $this->business = BusinessSetup::current();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your project is confirmed — {$this->job->job_title}",
            replyTo: [
                new \Illuminate\Mail\Mailables\Address(
                    $this->business->email ?? config('mail.from.address'),
                    $this->business->business_name
                ),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.job-scheduled',
            with: [
                'job'      => $this->job,
                'business' => $this->business,
                'logoUrl'  => $this->logoUrl(),
            ],
        );
    }

    public function attachments(): array { return []; }

    private function logoUrl(): ?string
    {
        if ($this->business->logo_path) {
            return asset('storage/' . $this->business->logo_path);
        }
        return asset('assets/images/logo/shifttech.png');
    }
}
