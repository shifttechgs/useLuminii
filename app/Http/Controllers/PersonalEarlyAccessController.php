<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Early-access sign-ups from the Personal page's quote/invoice builder.
 *
 * Sending and PDF downloads aren't open to the public yet, so when a visitor
 * finishes a draft and tries to send it we capture their email as a CRM lead.
 * Only a summary of the draft is stored; the client's details and line items
 * stay in the visitor's browser.
 */
class PersonalEarlyAccessController extends Controller
{
    /** "What should we build first?" choices on the Send step. Stored on the lead as "Wants: <label>". */
    private const WANTS = [
        'accept' => 'Client accepts the quote online',
        'pay'    => 'Pay button (card or mobile money)',
        'remind' => 'Automatic payment reminders',
        'track'  => 'Know when the client opens it',
    ];

    public function store(Request $request): JsonResponse
    {
        // Honeypot: real visitors never see or fill this field.
        if (filled($request->input('website'))) {
            return response()->json(['success' => true]);
        }

        $data = $request->validate([
            'email'    => 'required|email:rfc|max:255',
            'name'     => 'nullable|string|max:120',
            'business' => 'nullable|string|max:120',
            'doc_type' => 'required|in:quote,invoice',
            'currency' => ['required', 'regex:/^[A-Z]{3}$/'],
            'lines'    => 'nullable|integer|min:0|max:200',
            'total'    => 'nullable|numeric|min:0|max:1000000000',
            'timezone' => 'nullable|string|max:64',
            'wants'    => 'nullable|in:' . implode(',', array_keys(self::WANTS)),
        ]);

        $wants = ! empty($data['wants']) ? 'Wants: ' . self::WANTS[$data['wants']] : null;

        try {
            // One lead per email per day is enough; a repeat only updates the vote.
            $recent = Lead::where('email', $data['email'])
                ->where('created_at', '>', now()->subDay())
                ->latest()
                ->first();

            if ($recent) {
                if ($wants) {
                    $services = array_values(array_filter(
                        (array) $recent->services_interested,
                        fn ($s) => ! str_starts_with((string) $s, 'Wants: ')
                    ));
                    $services[] = $wants;
                    $recent->update(['services_interested' => $services]);
                }
            } else {
                $summary = sprintf(
                    'Personal early access. Built a %s draft: %d line item(s), total %s %s.',
                    $data['doc_type'],
                    (int) ($data['lines'] ?? 0),
                    $data['currency'],
                    number_format((float) ($data['total'] ?? 0), 2)
                );
                if (! empty($data['timezone'])) {
                    $summary .= ' Timezone: ' . $data['timezone'] . '.';
                }
                if ($wants) {
                    $summary .= ' ' . $wants . '.';
                }

                Lead::create([
                    'source'              => 'website',
                    'name'                => ($data['name'] ?? null) ?: (($data['business'] ?? null) ?: $data['email']),
                    'email'               => $data['email'],
                    'company'             => $data['business'] ?? null,
                    'services_interested' => array_values(array_filter(['Personal: quotes and invoices', $wants])),
                    'message'             => $summary,
                    'status'              => 'New',
                    'priority'            => 'Normal',
                    'ip_address'          => $request->ip(),
                ]);

                // Funnel count: one per new early-access lead (anonymous; the lead itself is the record)
                PersonalMetricsController::record('email_left', $data['doc_type']);
            }
        } catch (\Throwable $e) {
            Log::error('Failed to save Personal early-access lead', [
                'error' => $e->getMessage(),
                'email' => $data['email'],
            ]);

            return response()->json([
                'message' => 'Something went wrong on our side. Please try again in a moment.',
            ], 500);
        }

        return response()->json(['success' => true]);
    }
}
