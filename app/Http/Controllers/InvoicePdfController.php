<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\BusinessSetup;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoicePdfController extends Controller
{
    public function download(string $invoiceId)
    {
        $invoice  = Invoice::with(['client', 'items'])->where('invoice_id', $invoiceId)->firstOrFail();
        $business = BusinessSetup::current();

        // Heal stale totals — items may have been added after the invoice was first saved
        if ($invoice->items->isNotEmpty() && (float) $invoice->total_amount === 0.0) {
            $invoice->recalculateTotals();
            $invoice->refresh()->load(['client', 'items']);
        }

        $pdf = Pdf::loadView('pdf.invoice', [
            'invoice'    => $invoice,
            'business'   => $business,
            'logoBase64' => $this->logoDataUri($business),
        ])->setPaper('a4');

        return $pdf->download("Invoice-{$invoice->invoice_id}.pdf");
    }

    private function logoDataUri(BusinessSetup $business): ?string
    {
        if ($business->logo_path) {
            $path = storage_path('app/public/' . $business->logo_path);
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
