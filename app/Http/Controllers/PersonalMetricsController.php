<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Anonymous funnel counts from the Personal builder.
 *
 * The browser sends each event at most once per day; nothing identifies the visitor.
 * "email_left" is recorded server-side by PersonalEarlyAccessController instead.
 */
class PersonalMetricsController extends Controller
{
    public const CLIENT_EVENTS = ['visit', 'pdf_download', 'send_click'];

    public function store(Request $request): Response
    {
        $data = $request->validate([
            'event'    => 'required|in:' . implode(',', self::CLIENT_EVENTS),
            'doc_type' => 'nullable|in:quote,invoice',
        ]);

        self::record($data['event'], $data['doc_type'] ?? null);

        return response()->noContent();
    }

    /** Never let counting break the page or the lead form. */
    public static function record(string $event, ?string $docType = null): void
    {
        try {
            DB::table('personal_events')->insert([
                'event'      => $event,
                'doc_type'   => $docType,
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('Could not record Personal metric', ['event' => $event, 'error' => $e->getMessage()]);
        }
    }
}
