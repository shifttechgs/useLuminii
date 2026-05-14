<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\BusinessSetup;
use Barryvdh\DomPDF\Facade\Pdf;

class QuotePdfController extends Controller
{
    public function download(string $quoteId)
    {
        $pdf = $this->build($quoteId);
        return $pdf['pdf']->download("Quote-{$pdf['quote']->quote_id}.pdf");
    }

    public function preview(string $quoteId)
    {
        $pdf = $this->build($quoteId);
        return $pdf['pdf']->stream("Quote-{$pdf['quote']->quote_id}.pdf");
    }

    private function build(string $quoteId): array
    {
        $quote      = Quote::with(['client', 'items', 'salesRep'])->where('quote_id', $quoteId)->firstOrFail();
        $business   = BusinessSetup::current();
        $logoBase64 = $this->logoDataUri($business);

        $pdf = Pdf::loadView('pdf.quote', compact('quote', 'business', 'logoBase64'))->setPaper('a4');

        return compact('pdf', 'quote');
    }

    private function logoDataUri(BusinessSetup $business): ?string
    {
        // Prefer the logo stored in Business Settings (uploaded via admin)
        if ($business->logo_path) {
            $path = storage_path('app/public/' . $business->logo_path);
            if (file_exists($path)) {
                return 'data:image/' . pathinfo($path, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($path));
            }
        }

        // Fall back to the website logo
        $fallback = public_path('assets/images/logo/shifttech.png');
        if (file_exists($fallback)) {
            return 'data:image/png;base64,' . base64_encode(file_get_contents($fallback));
        }

        return null;
    }
}

