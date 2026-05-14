<?php

namespace App\Mail;

use App\Models\Invoice;
use App\Models\BusinessSetup;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public BusinessSetup $business;

    public function __construct(public Invoice $invoice)
    {
        $this->business = BusinessSetup::current();

        // Heal stale totals — items may have been added after the invoice was created
        $this->invoice->loadMissing('items');
        if ($this->invoice->items->isNotEmpty() && (float) $this->invoice->total_amount === 0.0) {
            $this->invoice->recalculateTotals();
            $this->invoice->refresh()->load(['client', 'items']);
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Invoice {$this->invoice->invoice_id} from {$this->business->business_name}",
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
            view: 'emails.invoice',
            with: [
                'invoice'  => $this->invoice,
                'business' => $this->business,
                'logoUrl'  => $this->logoUrl(),
            ],
        );
    }

    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.invoice', [
            'invoice'    => $this->invoice->load(['client', 'items']),
            'business'   => $this->business,
            'logoBase64' => $this->logoDataUri(),
        ])->setPaper('a4');

        return [
            Attachment::fromData(
                fn () => $pdf->output(),
                "Invoice-{$this->invoice->invoice_id}.pdf"
            )->withMime('application/pdf'),
        ];
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
}
