<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\BusinessClient;
use App\Models\RecurringInvoice;
use App\Models\RecurringInvoiceItem;
use Illuminate\Http\Request;

class RecurringInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = RecurringInvoice::with('client')->orderBy('created_at', 'desc');

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $recurring = $query->paginate(25)->withQueryString();

        $stats = [
            'active'   => RecurringInvoice::where('status', 'Active')->count(),
            'paused'   => RecurringInvoice::where('status', 'Paused')->count(),
            'monthly'  => RecurringInvoice::where('status', 'Active')->where('frequency', 'Monthly')->sum('total_amount'),
        ];

        return view('crm.recurring.index', compact('recurring', 'stats'));
    }

    public function create()
    {
        $clients = BusinessClient::orderBy('firstname')->get();
        return view('crm.recurring.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'           => 'required|string',
            'frequency'           => 'required|in:Weekly,Monthly,Quarterly,Annually',
            'status'              => 'required|in:Active,Paused,Cancelled',
            'start_date'          => 'required|date',
            'end_date'            => 'nullable|date',
            'internal_notes'      => 'nullable|string',
            'client_message'      => 'nullable|string',
            'items'               => 'array',
            'items.*.description' => 'required|string',
            'items.*.quantity'    => 'required|numeric|min:0',
            'items.*.unit_price'  => 'required|numeric|min:0',
        ]);

        $subTotal = collect($data['items'] ?? [])->sum(fn($i) => $i['quantity'] * $i['unit_price']);

        $rec = RecurringInvoice::create([
            'client_id'       => $data['client_id'],
            'frequency'       => $data['frequency'],
            'status'          => $data['status'],
            'start_date'      => $data['start_date'],
            'end_date'        => $data['end_date'] ?? null,
            'next_invoice_date' => $data['start_date'],
            'total_amount'    => $subTotal,
            'internal_notes'  => $data['internal_notes'] ?? null,
            'client_message'  => $data['client_message'] ?? null,
        ]);

        foreach (($data['items'] ?? []) as $i => $item) {
            RecurringInvoiceItem::create([
                'recurring_invoice_id' => $rec->recurring_invoice_id,
                'description'          => $item['description'],
                'quantity'             => $item['quantity'],
                'unit_price'           => $item['unit_price'],
                'total'                => $item['quantity'] * $item['unit_price'],
                'sort_order'           => $i,
            ]);
        }

        ActivityLog::record('created', 'RecurringInvoice', $rec->recurring_invoice_id, "Recurring invoice created");

        return redirect()->route('crm.recurring.index')->with('success', 'Recurring invoice created.');
    }

    public function edit(RecurringInvoice $recurringInvoice)
    {
        $recurringInvoice->load('items', 'client');
        $clients = BusinessClient::orderBy('firstname')->get();
        return view('crm.recurring.edit', compact('recurringInvoice', 'clients'));
    }

    public function update(Request $request, RecurringInvoice $recurringInvoice)
    {
        $data = $request->validate([
            'frequency'           => 'required|in:Weekly,Monthly,Quarterly,Annually',
            'status'              => 'required|in:Active,Paused,Cancelled',
            'start_date'          => 'required|date',
            'end_date'            => 'nullable|date',
            'internal_notes'      => 'nullable|string',
            'client_message'      => 'nullable|string',
            'items'               => 'array',
            'items.*.description' => 'required|string',
            'items.*.quantity'    => 'required|numeric|min:0',
            'items.*.unit_price'  => 'required|numeric|min:0',
        ]);

        $subTotal = collect($data['items'] ?? [])->sum(fn($i) => $i['quantity'] * $i['unit_price']);

        $recurringInvoice->update([
            'frequency'       => $data['frequency'],
            'status'          => $data['status'],
            'start_date'      => $data['start_date'],
            'end_date'        => $data['end_date'] ?? null,
            'total_amount'    => $subTotal,
            'internal_notes'  => $data['internal_notes'] ?? null,
            'client_message'  => $data['client_message'] ?? null,
        ]);

        $recurringInvoice->items()->delete();
        foreach (($data['items'] ?? []) as $i => $item) {
            RecurringInvoiceItem::create([
                'recurring_invoice_id' => $recurringInvoice->recurring_invoice_id,
                'description'          => $item['description'],
                'quantity'             => $item['quantity'],
                'unit_price'           => $item['unit_price'],
                'total'                => $item['quantity'] * $item['unit_price'],
                'sort_order'           => $i,
            ]);
        }

        return redirect()->route('crm.recurring.index')->with('success', 'Recurring invoice updated.');
    }

    public function destroy(RecurringInvoice $recurringInvoice)
    {
        $recurringInvoice->delete();
        return redirect()->route('crm.recurring.index')->with('success', 'Recurring invoice deleted.');
    }

    public function show(RecurringInvoice $recurringInvoice)
    {
        $recurringInvoice->load(['client', 'items']);
        return view('crm.recurring.show', compact('recurringInvoice'));
    }
}

