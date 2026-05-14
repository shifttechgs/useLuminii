<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Mail\InvoiceMail;
use App\Models\ActivityLog;
use App\Models\BusinessClient;
use App\Models\BusinessService;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Job;
use App\Models\RecurringInvoice;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('client')->orderBy('created_at', 'desc');

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('invoice_id', 'like', "%$search%")
                  ->orWhereHas('client', fn($c) => $c->where('firstname', 'like', "%$search%")
                      ->orWhere('lastname', 'like', "%$search%")
                      ->orWhere('company', 'like', "%$search%"));
            });
        }
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($type = $request->get('type')) {
            $query->where('invoice_type', $type);
        }

        $invoices = $query->paginate(25)->withQueryString();

        $stats = [
            'total'      => Invoice::count(),
            'draft'      => Invoice::where('status', 'Draft')->count(),
            'sent'       => Invoice::whereIn('status', ['Sent', 'PartiallyPaid'])->count(),
            'paid'       => Invoice::where('status', 'Paid')->count(),
            'overdue'    => Invoice::where('status', 'Overdue')->count(),
            'revenue'    => Invoice::where('status', 'Paid')->sum('total_amount'),
            'outstanding'=> Invoice::whereIn('status', ['Sent', 'PartiallyPaid', 'Overdue'])->sum('balance'),
        ];

        return view('crm.invoices.index', compact('invoices', 'stats'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['client', 'items', 'job', 'salesPerson']);
        return view('crm.invoices.show', compact('invoice'));
    }

    public function create(Request $request)
    {
        $clients  = BusinessClient::orderBy('company')->orderBy('firstname')->get();
        $services = BusinessService::where('is_active', true)->orderBy('category')->orderBy('name')->get();
        $jobs     = Job::with('items', 'quote')
                        ->orderBy('created_at', 'desc')
                        ->get();

        $prefilledJobId    = $request->get('job_id');
        $prefilledClientId = $request->get('client_id');

        return view('crm.invoices.create', compact('clients', 'services', 'jobs', 'prefilledJobId', 'prefilledClientId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'        => 'required|string',
            'job_id'           => 'nullable|string',
            'invoice_type'     => 'nullable|string',
            'invoice_date'     => 'required|date',
            'due_date'         => 'required|date',
            'status'           => 'required|in:Draft,Sent,PartiallyPaid,Paid,Overdue,Cancelled',
            'discount'         => 'nullable|numeric|min:0',
            'deposit_paid'     => 'nullable|numeric|min:0',
            'payment_method'   => 'nullable|string',
            'internal_notes'   => 'nullable|string',
            'client_message'   => 'nullable|string',
            'send_immediately' => 'nullable|boolean',
            'currency'         => 'nullable|in:ZAR,USD,EUR,GBP',
            'is_recurring'     => 'nullable|boolean',
            'recur_frequency'  => 'nullable|in:Weekly,Monthly,Quarterly,Annually',
            'recur_start_date' => 'nullable|date',
            'recur_end_date'   => 'nullable|date',
            'items'                => 'array',
            'items.*.description'  => 'required|string',
            'items.*.quantity'     => 'required|numeric|min:0',
            'items.*.unit_price'   => 'required|numeric|min:0',
        ]);

        $sendNow = (bool) ($data['send_immediately'] ?? false);
        $status  = $sendNow ? 'Sent' : ($data['status'] ?? 'Draft');

        $invoice = Invoice::create([
            'client_id'      => $data['client_id'],
            'job_id'         => $data['job_id'] ?? null,
            'invoice_type'   => $data['invoice_type'] ?? 'project',
            'created_by'     => auth()->id(),
            'invoice_date'   => $data['invoice_date'],
            'due_date'       => $data['due_date'],
            'status'         => $status,
            'currency'       => $data['currency'] ?? 'ZAR',
            'discount'       => $data['discount'] ?? 0,
            'deposit_paid'   => $data['deposit_paid'] ?? 0,
            'payment_method' => $data['payment_method'] ?? null,
            'internal_notes' => $data['internal_notes'] ?? null,
            'client_message' => $data['client_message'] ?? null,
            'sub_total'      => 0,
            'total_tax'      => 0,
            'total_amount'   => 0,
            'balance'        => 0,
        ]);

        foreach (($data['items'] ?? []) as $i => $item) {
            InvoiceItem::create([
                'invoice_id'  => $invoice->invoice_id,
                'description' => $item['description'],
                'quantity'    => $item['quantity'],
                'unit_price'  => $item['unit_price'],
                'line_total'  => $item['quantity'] * $item['unit_price'],
                'sort_order'  => $i,
            ]);
        }

        $invoice->refresh()->load('items');
        $invoice->recalculateTotals();

        // Create recurring schedule if requested
        if (!empty($data['is_recurring'])) {
            $startDate = $data['recur_start_date'] ?? now()->toDateString();
            $frequency = $data['recur_frequency'] ?? 'Monthly';
            $nextDate  = match ($frequency) {
                'Weekly'    => \Carbon\Carbon::parse($startDate)->addWeek()->toDateString(),
                'Quarterly' => \Carbon\Carbon::parse($startDate)->addMonths(3)->toDateString(),
                'Annually'  => \Carbon\Carbon::parse($startDate)->addYear()->toDateString(),
                default     => \Carbon\Carbon::parse($startDate)->addMonth()->toDateString(),
            };

            $rec = RecurringInvoice::create([
                'client_id'          => $invoice->client_id,
                'job_id'             => $invoice->job_id,
                'frequency'          => $frequency,
                'total_amount'       => $invoice->total_amount,
                'deposit_paid'       => $invoice->deposit_paid,
                'payment_due'        => $invoice->balance,
                'status'             => 'Active',
                'client_message'     => $invoice->client_message,
                'internal_notes'     => $invoice->internal_notes,
                'created_by'         => auth()->id(),
                'start_date'         => $startDate,
                'end_date'           => $data['recur_end_date'] ?? null,
                'next_invoice_date'  => $nextDate,
                'invoices_generated' => 1,
            ]);

            foreach ($invoice->items as $item) {
                $rec->items()->create([
                    'description' => $item->description,
                    'quantity'    => $item->quantity,
                    'unit_price'  => $item->unit_price,
                    'line_total'  => $item->line_total,
                ]);
            }

            $invoice->update(['recurring_invoice_id' => $rec->recurring_invoice_id]);
        }

        ActivityLog::record('created', 'Invoice', $invoice->invoice_id, "Invoice {$invoice->invoice_id} created");
        NotificationService::info('New Invoice', "Invoice {$invoice->invoice_id} created for {$invoice->client->full_name}", route('crm.invoices.show', $invoice));

        if ($sendNow && $invoice->client->email) {
            Mail::to($invoice->client->email)->send(new InvoiceMail($invoice));
            ActivityLog::record('sent', 'Invoice', $invoice->invoice_id, "Invoice emailed to {$invoice->client->email} on creation");
        }

        return redirect()->route('crm.invoices.show', $invoice)->with('success', $sendNow ? 'Invoice created and sent.' : 'Invoice saved as draft.');
    }

    public function edit(Invoice $invoice)
    {
        $invoice->load(['client', 'items']);
        $clients = BusinessClient::orderBy('firstname')->get();
        return view('crm.invoices.edit', compact('invoice', 'clients'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'invoice_date'   => 'required|date',
            'due_date'       => 'required|date',
            'status'         => 'required|in:Draft,Sent,PartiallyPaid,Paid,Overdue,Cancelled',
            'discount'       => 'nullable|numeric|min:0',
            'deposit_paid'   => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string',
            'currency'       => 'nullable|in:ZAR,USD,EUR,GBP',
            'internal_notes' => 'nullable|string',
            'client_message' => 'nullable|string',
            'items'              => 'array',
            'items.*.description'=> 'required|string',
            'items.*.quantity'   => 'required|numeric|min:0',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $invoice->update([
            'invoice_date'   => $data['invoice_date'],
            'due_date'       => $data['due_date'],
            'status'         => $data['status'],
            'currency'       => $data['currency'] ?? $invoice->currency,
            'discount'       => $data['discount'] ?? 0,
            'deposit_paid'   => $data['deposit_paid'] ?? 0,
            'payment_method' => $data['payment_method'] ?? 'EFT',
            'internal_notes' => $data['internal_notes'] ?? null,
            'client_message' => $data['client_message'] ?? null,
        ]);

        $invoice->items()->delete();
        if (!empty($data['items'])) {
            foreach ($data['items'] as $i => $item) {
                InvoiceItem::create([
                    'invoice_id'  => $invoice->invoice_id,
                    'description' => $item['description'],
                    'quantity'    => $item['quantity'],
                    'unit_price'  => $item['unit_price'],
                    'line_total'  => $item['quantity'] * $item['unit_price'],
                    'sort_order'  => $i,
                ]);
            }
        }

        $invoice->refresh()->load('items');
        $invoice->recalculateTotals();

        return redirect()->route('crm.invoices.show', $invoice)->with('success', 'Invoice updated.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('crm.invoices.index')->with('success', 'Invoice deleted.');
    }

    public function send(Invoice $invoice)
    {
        $invoice->load(['client', 'items']);

        if (!$invoice->client->email) {
            return back()->with('error', 'Client has no email address.');
        }

        Mail::to($invoice->client->email)->send(new InvoiceMail($invoice));
        $invoice->update(['status' => 'Sent']);

        ActivityLog::record('sent', 'Invoice', $invoice->invoice_id, "Invoice {$invoice->invoice_id} emailed to {$invoice->client->email}");

        return back()->with('success', 'Invoice sent to ' . $invoice->client->email);
    }

    public function recordPayment(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'amount'     => 'required|numeric|min:0.01',
            'method'     => 'required|string',
            'reference'  => 'nullable|string',
        ]);

        $newDeposit = ($invoice->deposit_paid ?? 0) + $data['amount'];
        $balance    = $invoice->total_amount - $newDeposit;

        $status = $balance <= 0 ? 'Paid' : 'PartiallyPaid';

        $invoice->update([
            'deposit_paid'       => $newDeposit,
            'balance'            => max(0, $balance),
            'status'             => $status,
            'payment_method'     => $data['method'],
            'payment_reference'  => $data['reference'] ?? null,
            'paid_at'            => $status === 'Paid' ? now() : $invoice->paid_at,
        ]);

        ActivityLog::record('payment', 'Invoice', $invoice->invoice_id, "Payment of R{$data['amount']} recorded ({$data['method']})");

        if ($status === 'Paid') {
            NotificationService::success('Invoice Paid', "Invoice {$invoice->invoice_id} fully paid", route('crm.invoices.show', $invoice));
        }

        return back()->with('success', 'Payment recorded.');
    }
}

