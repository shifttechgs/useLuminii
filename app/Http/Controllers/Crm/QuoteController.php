<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Mail\QuoteMail;
use App\Models\ActivityLog;
use App\Models\BusinessClient;
use App\Models\BusinessService;
use App\Models\ClientRequest;
use App\Models\Job;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Quote::with('client')->orderBy('created_at', 'desc');

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('quote_id', 'like', "%$search%")
                  ->orWhere('job_title', 'like', "%$search%")
                  ->orWhereHas('client', fn($c) => $c->where('firstname', 'like', "%$search%")
                      ->orWhere('lastname', 'like', "%$search%")
                      ->orWhere('company', 'like', "%$search%"));
            });
        }
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $quotes = $query->paginate(25)->withQueryString();

        $stats = [
            'total'    => Quote::count(),
            'draft'    => Quote::where('status', 'Draft')->count(),
            'sent'     => Quote::where('status', 'Sent')->count(),
            'accepted' => Quote::where('status', 'Accepted')->count(),
            'pipeline' => Quote::whereIn('status', ['Draft','Sent'])->sum('grand_total'),
        ];

        return view('crm.quotes.index', compact('quotes', 'stats'));
    }

    public function show(Quote $quote)
    {
        $quote->load(['client', 'items', 'salesRep']);
        return view('crm.quotes.show', compact('quote'));
    }

    public function create(Request $request)
    {
        $clients = BusinessClient::where('client_type', '!=', 'Inactive')->orderBy('firstname')->get();
        $services = BusinessService::where('is_active', true)->orderBy('category')->orderBy('name')->get();
        $selectedClient = $request->get('client_id')
            ? BusinessClient::find($request->get('client_id'))
            : null;
        // Pre-load selected client's open requests for initial render
        $selectedClientRequests = $selectedClient
            ? ClientRequest::with('service')
                ->where('client_id', $selectedClient->client_id)
                ->whereIn('status', ['New', 'InReview'])
                ->orderBy('created_at', 'desc')
                ->get()
            : collect();
        return view('crm.quotes.create', compact('clients', 'services', 'selectedClient', 'selectedClientRequests'));
    }

    // ── AJAX: fetch open requests for a client ──────────────────────────────
    public function clientRequests(Request $request)
    {
        $clientId = $request->get('client_id');
        $requests = ClientRequest::with('service')
            ->where('client_id', $clientId)
            ->whereIn('status', ['New', 'InReview'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($r) => [
                'id'               => $r->id,
                'request_id'       => $r->request_id,
                'title'            => $r->title,
                'description'      => $r->description,
                'assessment_notes' => $r->assessment_notes,
                'priority'         => $r->priority,
                'service'          => $r->service ? [
                    'service_id'  => $r->service->service_id,
                    'name'        => $r->service->name,
                    'description' => $r->service->description,
                    'unit_price'  => (float) $r->service->unit_price,
                    'unit_type'   => $r->service->unit_type,
                ] : null,
            ]);
        return response()->json($requests);
    }

    // ── AJAX: all active services catalogue ─────────────────────────────────
    public function services()
    {
        $services = BusinessService::where('is_active', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->map(fn($s) => [
                'service_id'  => $s->service_id,
                'name'        => $s->name,
                'description' => $s->description,
                'category'    => $s->category,
                'unit_price'  => (float) $s->unit_price,
                'unit_type'   => $s->unit_type,
            ]);
        return response()->json($services);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'          => 'required|string',
            'source_request_id'  => 'nullable|exists:client_requests,id',
            'job_title'          => 'required|string|max:255',
            'status'             => 'required|in:Draft,Sent,Accepted,Declined,Expired',
            'quote_date'         => 'required|date',
            'expiry_date'        => 'nullable|date',
            'required_deposit'   => 'nullable|numeric|min:0',
            'discount'           => 'nullable|numeric|min:0',
            'discount_type'      => 'nullable|in:Fixed,Percent',
            'internal_notes'     => 'nullable|string',
            'client_notes'       => 'nullable|string',
            'send_immediately'   => 'nullable|boolean',
            'currency'           => 'nullable|in:ZAR,USD,EUR,GBP',
            'items'              => 'array',
            'items.*.description'=> 'required|string',
            'items.*.quantity'   => 'required|numeric|min:0',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $sendNow = !empty($data['send_immediately']);

        $quote = Quote::create([
            'client_id'        => $data['client_id'],
            'user_id'          => auth()->id(),
            'job_title'        => $data['job_title'],
            'status'           => $sendNow ? 'Sent' : $data['status'],
            'quote_date'       => $data['quote_date'],
            'expiry_date'      => $data['expiry_date'] ?? null,
            'required_deposit' => $data['required_deposit'] ?? 0,
            'discount'         => $data['discount'] ?? 0,
            'discount_type'    => $data['discount_type'] ?? 'Fixed',
            'internal_notes'   => $data['internal_notes'] ?? null,
            'client_notes'     => $data['client_notes'] ?? null,
            'currency'         => $data['currency'] ?? 'ZAR',
            'sub_total'        => 0,
            'total_tax'        => 0,
            'grand_total'      => 0,
        ]);

        if (!empty($data['items'])) {
            foreach ($data['items'] as $i => $item) {
                $lineTotal = $item['quantity'] * $item['unit_price'];
                QuoteItem::create([
                    'quote_id'    => $quote->quote_id,
                    'description' => $item['description'],
                    'quantity'    => $item['quantity'],
                    'unit_price'  => $item['unit_price'],
                    'tax_rate'    => 0,
                    'line_total'  => $lineTotal,
                    'sort_order'  => $i,
                ]);
            }
        }

        $quote->refresh()->load(['items', 'client']);
        $quote->recalculateTotals();

        // ── Auto-advance the linked client request to Quoted ──
        if (!empty($data['source_request_id'])) {
            ClientRequest::where('id', $data['source_request_id'])
                ->update(['status' => 'Quoted']);
            ActivityLog::record('status_changed', 'ClientRequest', $data['source_request_id'], "Auto-moved to Quoted — quote {$quote->quote_id} created");
        }

        ActivityLog::record('created', 'Quote', $quote->quote_id, "Quote {$quote->quote_id} created");
        NotificationService::info('New Quote Created', "Quote {$quote->quote_id} for {$quote->client->full_name}", route('crm.quotes.show', $quote));

        // ── Send immediately if requested ──
        if ($sendNow) {
            if (!$quote->client->email) {
                return redirect()->route('crm.quotes.show', $quote)
                    ->with('warning', 'Quote created but client has no email address — could not send.');
            }
            try {
                Mail::to($quote->client->email)->send(new QuoteMail($quote));
                ActivityLog::record('sent', 'Quote', $quote->quote_id, "Quote emailed to {$quote->client->email}");
                return redirect()->route('crm.quotes.show', $quote)
                    ->with('success', "Quote created and sent to {$quote->client->email} ✓");
            } catch (\Exception $e) {
                return redirect()->route('crm.quotes.show', $quote)
                    ->with('warning', 'Quote created but email failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('crm.quotes.show', $quote)->with('success', 'Quote created as draft.');
    }

    public function edit(Quote $quote)
    {
        $quote->load(['client', 'items']);
        $clients = BusinessClient::where('client_type', '!=', 'Inactive')->orderBy('firstname')->get();
        return view('crm.quotes.edit', compact('quote', 'clients'));
    }

    public function update(Request $request, Quote $quote)
    {
        $data = $request->validate([
            'job_title'          => 'required|string|max:255',
            'status'             => 'required|in:Draft,Sent,Accepted,Declined,Expired',
            'quote_date'         => 'required|date',
            'expiry_date'        => 'nullable|date',
            'required_deposit'   => 'nullable|numeric|min:0',
            'discount'           => 'nullable|numeric|min:0',
            'discount_type'      => 'nullable|in:Fixed,Percent',
            'internal_notes'     => 'nullable|string',
            'client_notes'       => 'nullable|string',
            'currency'           => 'nullable|in:ZAR,USD,EUR,GBP',
            'items'              => 'array',
            'items.*.description'=> 'required|string',
            'items.*.quantity'   => 'required|numeric|min:0',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $quote->update([
            'job_title'        => $data['job_title'],
            'status'           => $data['status'],
            'quote_date'       => $data['quote_date'],
            'expiry_date'      => $data['expiry_date'] ?? null,
            'required_deposit' => $data['required_deposit'] ?? 0,
            'discount'         => $data['discount'] ?? 0,
            'discount_type'    => $data['discount_type'] ?? 'Fixed',
            'internal_notes'   => $data['internal_notes'] ?? null,
            'client_notes'     => $data['client_notes'] ?? null,
            'currency'         => $data['currency'] ?? $quote->currency,
        ]);

        // Replace line items
        $quote->items()->delete();
        if (!empty($data['items'])) {
            foreach ($data['items'] as $i => $item) {
                $lineTotal = $item['quantity'] * $item['unit_price'];
                QuoteItem::create([
                    'quote_id'    => $quote->quote_id,
                    'description' => $item['description'],
                    'quantity'    => $item['quantity'],
                    'unit_price'  => $item['unit_price'],
                    'tax_rate'    => 0,
                    'line_total'  => $lineTotal,
                    'sort_order'  => $i,
                ]);
            }
        }

        $quote->refresh()->load('items');
        $quote->recalculateTotals();

        return redirect()->route('crm.quotes.show', $quote)->with('success', 'Quote updated.');
    }

    public function destroy(Quote $quote)
    {
        $quote->delete();
        return redirect()->route('crm.quotes.index')->with('success', 'Quote deleted.');
    }

    public function send(Quote $quote)
    {
        $quote->load(['client', 'items']);

        if (!$quote->client->email) {
            return back()->with('error', 'Client has no email address.');
        }

        Mail::to($quote->client->email)->send(new QuoteMail($quote));

        $quote->update(['status' => 'Sent']);
        ActivityLog::record('sent', 'Quote', $quote->quote_id, "Quote {$quote->quote_id} emailed to {$quote->client->email}");

        return back()->with('success', 'Quote sent to ' . $quote->client->email);
    }

    public function convertToJob(Quote $quote)
    {
        $quote->load('items');

        $job = Job::create([
            'client_id'        => $quote->client_id,
            'quote_id'         => $quote->quote_id,
            'request_id'       => $quote->request_id,
            'user_id'          => auth()->id(),
            'job_title'        => $quote->job_title,
            'job_status'       => 'New',
            'scheduled_status' => 'Unscheduled',
            'assigned_status'  => 'Unassigned',
        ]);

        foreach ($quote->items as $item) {
            $job->items()->create([
                'description' => $item->description,
                'quantity'    => $item->quantity,
                'unit_price'  => $item->unit_price,
                'tax_rate'    => $item->tax_rate ?? 0,
                'line_total'  => $item->line_total,
                'sort_order'  => $item->sort_order,
            ]);
        }

        ActivityLog::record('converted', 'Quote', $quote->quote_id, "Quote converted to job {$job->job_id}");

        return redirect()->route('crm.jobs.show', $job)->with('success', 'Job created from quote.');
    }
}





