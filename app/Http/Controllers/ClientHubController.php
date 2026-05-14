<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Quote;
use App\Models\BusinessSetup;
use App\Models\ActivityLog;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class ClientHubController extends Controller
{
    // ── Quote Hub ────────────────────────────────────────────────────────

    public function viewQuote(string $token)
    {
        $quote    = Quote::with(['client', 'items', 'comments'])->where('accepted_token', $token)->firstOrFail();
        $business = BusinessSetup::current();
        $logoUrl  = $business->logo_path
            ? asset('storage/' . $business->logo_path)
            : asset('assets/images/logo/shifttech.png');
        return view('client-hub.quote', compact('quote', 'business', 'logoUrl'));
    }

    public function postComment(string $token, Request $request)
    {
        $quote = Quote::with('client')->where('accepted_token', $token)->firstOrFail();

        $request->validate(['message' => 'required|string|max:2000']);

        $authorName = optional($quote->client)->company
            ?: trim(optional($quote->client)->firstname . ' ' . optional($quote->client)->lastname);

        \App\Models\QuoteComment::create([
            'quote_id'    => $quote->quote_id,
            'author_type' => 'client',
            'author_name' => $authorName ?: 'Client',
            'message'     => $request->input('message'),
        ]);

        ActivityLog::record('commented', 'Quote', $quote->quote_id,
            "Client left a comment on quote {$quote->quote_id}");

        NotificationService::info(
            "New comment — {$authorName}",
            "Client commented on quote {$quote->quote_id}",
            '/useluminii/quotes/' . $quote->quote_id
        );

        return redirect()->back()->with('success_comment', 'Your message has been sent.');
    }

    public function acceptQuote(string $token, Request $request)
    {
        $quote = Quote::with('client')->where('accepted_token', $token)->firstOrFail();

        if ($quote->status === 'Sent') {
            $quote->update(['status' => 'Accepted', 'accepted_at' => now()]);

            $clientName = optional($quote->client)->company
                ?: trim(optional($quote->client)->firstname . ' ' . optional($quote->client)->lastname);

            $comment = trim($request->input('comment', ''));
            if ($comment) {
                \App\Models\QuoteComment::create([
                    'quote_id'    => $quote->quote_id,
                    'author_type' => 'client',
                    'author_name' => $clientName ?: 'Client',
                    'message'     => $comment,
                ]);
            }

            // Confirmation email to client
            if ($quote->client?->email) {
                \Illuminate\Support\Facades\Mail::to($quote->client->email)
                    ->send(new \App\Mail\QuoteAcceptedClientMail($quote->load('client')));
            }

            ActivityLog::record('updated', 'Quote', $quote->quote_id,
                "Client accepted quote {$quote->quote_id}" . ($comment ? " — Note: {$comment}" : ''));

            NotificationService::success(
                "Quote approved — {$clientName}",
                "{$quote->quote_id} · R " . number_format($quote->grand_total, 2) . ($comment ? " — \"{$comment}\"" : '') . ' · Ready to convert to a job.',
                '/useluminii/quotes/' . $quote->quote_id
            );
        }

        return redirect()->back();
    }

    public function declineQuote(string $token, Request $request)
    {
        $quote = Quote::with('client')->where('accepted_token', $token)->firstOrFail();

        if (in_array($quote->status, ['Sent', 'Accepted'])) {
            $quote->update(['status' => 'Declined']);

            $reason = trim($request->input('reason', ''));
            if ($reason) {
                $authorName = optional($quote->client)->company
                    ?: trim(optional($quote->client)->firstname . ' ' . optional($quote->client)->lastname);

                \App\Models\QuoteComment::create([
                    'quote_id'    => $quote->quote_id,
                    'author_type' => 'client',
                    'author_name' => $authorName ?: 'Client',
                    'message'     => $reason,
                ]);
            }

            ActivityLog::record('updated', 'Quote', $quote->quote_id,
                "Client declined quote {$quote->quote_id} via Client Hub" . ($reason ? " — Reason: {$reason}" : ''));

            $clientName = optional($quote->client)->company
                ?: trim(optional($quote->client)->firstname . ' ' . optional($quote->client)->lastname);

            NotificationService::warning(
                "Quote Declined — {$clientName}",
                $reason ?: "Client declined via Client Hub link",
                '/useluminii/quotes/' . $quote->quote_id
            );
        }

        return redirect()->back();
    }

    // ── Invoice Hub ──────────────────────────────────────────────────────

    public function viewInvoice(string $token)
    {
        $invoice  = Invoice::with(['client', 'items'])->where('view_token', $token)->firstOrFail();
        $business = BusinessSetup::current();
        $logoUrl  = $business->logo_path
            ? asset('storage/' . $business->logo_path)
            : asset('assets/images/logo/shifttech.png');

        // Heal stale totals if items exist but stored total is zero
        if ($invoice->items->isNotEmpty() && (float) $invoice->total_amount === 0.0) {
            $invoice->recalculateTotals();
            $invoice->refresh()->load('items');
        }

        return view('client-hub.invoice', compact('invoice', 'business', 'logoUrl'));
    }

    // ── PayPal: Create Order ─────────────────────────────────────────────

    public function paypalCheckout(string $token)
    {
        $invoice = Invoice::with('client')->where('view_token', $token)->firstOrFail();

        if ($invoice->status === 'Paid') {
            return redirect()->route('client-hub.invoice', $token)
                ->with('info', 'This invoice has already been paid.');
        }

        $provider = new PayPalClient(config('paypal'));
        $provider->getAccessToken();

        $amount     = number_format($invoice->balance ?? $invoice->total_amount, 2, '.', '');
        $invoiceRef = $invoice->invoice_id;
        $bizName    = optional(BusinessSetup::current())->business_name ?? config('app.name');

        $order = $provider->createOrder([
            'intent'         => 'CAPTURE',
            'purchase_units' => [[
                'reference_id' => $invoiceRef,
                'description'  => "Invoice {$invoiceRef} — {$bizName}",
                'amount'       => [
                    'currency_code' => 'USD',   // PayPal SA: use USD (ZAR not yet supported by PayPal checkout)
                    'value'         => $amount,
                ],
            ]],
            'application_context' => [
                'return_url' => route('client-hub.payment.success', $token),
                'cancel_url' => route('client-hub.invoice', $token),
                'brand_name' => $bizName,
                'user_action'=> 'PAY_NOW',
            ],
        ]);

        if (isset($order['id']) && $order['status'] === 'CREATED') {
            // Save order ID
            $invoice->update(['paypal_order_id' => $order['id']]);

            // Redirect to PayPal approval URL
            foreach ($order['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect($link['href']);
                }
            }
        }

        return redirect()->route('client-hub.invoice', $token)
            ->with('error', 'Could not connect to PayPal. Please try again or pay via EFT.');
    }

    // ── PayPal: Capture Payment ──────────────────────────────────────────

    public function paypalSuccess(string $token, Request $request)
    {
        $invoice = Invoice::where('view_token', $token)->firstOrFail();

        $provider = new PayPalClient(config('paypal'));
        $provider->getAccessToken();

        $orderId  = $request->get('token'); // PayPal passes ?token=ORDER_ID on return
        $capture  = $provider->capturePaymentOrder($orderId);

        if (isset($capture['status']) && $capture['status'] === 'COMPLETED') {
            $captureId = $capture['purchase_units'][0]['payments']['captures'][0]['id'] ?? null;

            $invoice->update([
                'status'           => 'Paid',
                'paid_at'          => now(),
                'balance'          => 0,
                'paypal_order_id'  => $orderId,
                'paypal_capture_id'=> $captureId,
                'payment_method'   => 'PayPal',
            ]);

            ActivityLog::record('paid', 'Invoice', $invoice->invoice_id,
                "Invoice {$invoice->invoice_id} paid via PayPal. Order: {$orderId}, Capture: {$captureId}");

            NotificationService::success(
                "Invoice Paid via PayPal! 💰 {$invoice->invoice_id}",
                "R " . number_format($invoice->total_amount, 2) . " received online.",
                '/useluminii/invoices'
            );

            return redirect()->route('client-hub.invoice', $token)
                ->with('success', '🎉 Payment successful! Thank you. Your invoice is now marked as paid.');
        }

        return redirect()->route('client-hub.invoice', $token)
            ->with('error', 'Payment could not be confirmed. Please contact us if you were charged.');
    }

    // ── PayPal: IPN / Webhook (optional but recommended) ────────────────

    public function paypalWebhook(Request $request)
    {
        // PayPal IPN / Webhook — basic handler
        $provider = new PayPalClient(config('paypal'));
        $provider->getAccessToken();

        $payload = $request->all();

        if (($payload['event_type'] ?? '') === 'CHECKOUT.ORDER.APPROVED') {
            $orderId = $payload['resource']['id'] ?? null;
            if ($orderId) {
                $invoice = Invoice::where('paypal_order_id', $orderId)->first();
                if ($invoice && $invoice->status !== 'Paid') {
                    $capture = $provider->capturePaymentOrder($orderId);
                    if (($capture['status'] ?? '') === 'COMPLETED') {
                        $captureId = $capture['purchase_units'][0]['payments']['captures'][0]['id'] ?? null;
                        $invoice->update([
                            'status'            => 'Paid',
                            'paid_at'           => now(),
                            'balance'           => 0,
                            'paypal_capture_id' => $captureId,
                            'payment_method'    => 'PayPal',
                        ]);
                        NotificationService::success(
                            "Invoice Paid (PayPal webhook): {$invoice->invoice_id}",
                            "Payment confirmed via webhook."
                        );
                    }
                }
            }
        }

        return response('OK', 200);
    }
}

