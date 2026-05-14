<?php

namespace App\Mail;

use App\Models\Quote;
use App\Models\BusinessSetup;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class QuoteMail extends Mailable
{
    use Queueable, SerializesModels;

    public BusinessSetup $business;

    public function __construct(public Quote $quote)
    {
        $this->business = BusinessSetup::current();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Quotation {$this->quote->quote_id} from {$this->business->business_name}",
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
            view: 'emails.quote',
            with: [
                'quote'    => $this->quote,
                'business' => $this->business,
                'logoUrl'  => $this->logoUrl(),
            ],
        );
    }

    private function logoUrl(): ?string
    {
        if ($this->business->logo_path) {
            return asset('storage/' . $this->business->logo_path);
        }
        return asset('assets/images/logo/shifttech.png');
    }

    private function logoDataUri(): ?string
    {
        if ($this->business->logo_path) {
            $path = storage_path('app/public/' . $this->business->logo_path);
            if (file_exists($path)) {
                return 'data:image/' . pathinfo($path, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($path));
            }
        }
        $fallback = public_path('assets/images/logo/shifttech.png');
        if (file_exists($fallback)) {
            return 'data:image/png;base64,' . base64_encode(file_get_contents($fallback));
        }
        return null;
    }

    public function attachments(): array
    {
        $logoBase64 = $this->logoDataUri();
        $pdf  = Pdf::loadView('pdf.quote', [
            'quote'       => $this->quote->load(['client', 'items']),
            'business'    => $this->business,
            'logoBase64'  => $logoBase64,
        ])->setPaper('a4');

        return [
            Attachment::fromData(
                fn () => $pdf->output(),
                "Quote-{$this->quote->quote_id}.pdf"
            )->withMime('application/pdf'),
        ];
    }
}

