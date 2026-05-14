<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\BusinessClient;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = BusinessClient::with('assignedRep')
            ->orderBy('created_at', 'desc');

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%$search%")
                  ->orWhere('lastname', 'like', "%$search%")
                  ->orWhere('company', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('client_id', 'like', "%$search%");
            });
        }
        if ($type = $request->get('type')) {
            $query->where('client_type', $type);
        }
        if ($source = $request->get('source')) {
            $query->where('lead_source', $source);
        }

        $clients = $query->paginate(25)->withQueryString();

        $stats = [
            'total'    => BusinessClient::count(),
            'clients'  => BusinessClient::where('client_type', 'Client')->count(),
            'leads'    => BusinessClient::where('client_type', 'Lead')->count(),
            'inactive' => BusinessClient::where('client_type', 'Inactive')->count(),
        ];

        return view('crm.clients.index', compact('clients', 'stats'));
    }

    public function show(BusinessClient $client)
    {
        $client->load(['quotes', 'jobs.scheduledJob', 'invoices', 'requests', 'assignedRep']);

        $stats = [
            'total_invoiced' => $client->invoices->whereIn('status', ['Paid', 'PartiallyPaid', 'Sent', 'Overdue'])->sum('total_amount'),
            'total_paid'     => $client->invoices->where('status', 'Paid')->sum('total_amount'),
            'open_quotes'    => $client->quotes->whereIn('status', ['Draft', 'Sent'])->count(),
            'active_jobs'    => $client->jobs->whereIn('job_status', ['New', 'Scheduled', 'InProgress'])->count(),
        ];

        return view('crm.clients.show', compact('client', 'stats'));
    }

    public function create()
    {
        $reps = User::where('is_active', true)->orderBy('name')->get();
        return view('crm.clients.create', compact('reps'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'firstname'              => 'required|string|max:100',
            'lastname'               => 'required|string|max:100',
            'email'                  => 'nullable|email|max:255',
            'phone_number'           => 'nullable|string|max:30',
            'company'                => 'nullable|string|max:200',
            'client_type'            => 'required|in:Lead,Client,Inactive',
            'lead_source'            => 'nullable|string|max:100',
            'communication_preference' => 'nullable|string|max:50',
            'street'                 => 'nullable|string|max:200',
            'city'                   => 'nullable|string|max:100',
            'province'               => 'nullable|string|max:100',
            'postal_code'            => 'nullable|string|max:20',
            'country'                => 'nullable|string|max:100',
            'notes'                  => 'nullable|string',
            'user_id'                => 'nullable|exists:users,id',
        ]);

        $client = BusinessClient::create($data);

        ActivityLog::record('created', 'BusinessClient', $client->id, "Client {$client->full_name} created");

        return redirect()->route('crm.clients.show', $client)
            ->with('success', "Client {$client->full_name} created successfully.");
    }

    public function edit(BusinessClient $client)
    {
        $reps = User::where('is_active', true)->orderBy('name')->get();
        return view('crm.clients.edit', compact('client', 'reps'));
    }

    public function update(Request $request, BusinessClient $client)
    {
        $data = $request->validate([
            'firstname'              => 'required|string|max:100',
            'lastname'               => 'required|string|max:100',
            'email'                  => 'nullable|email|max:255',
            'phone_number'           => 'nullable|string|max:30',
            'company'                => 'nullable|string|max:200',
            'client_type'            => 'required|in:Lead,Client,Inactive',
            'lead_source'            => 'nullable|string|max:100',
            'communication_preference' => 'nullable|string|max:50',
            'street'                 => 'nullable|string|max:200',
            'city'                   => 'nullable|string|max:100',
            'province'               => 'nullable|string|max:100',
            'postal_code'            => 'nullable|string|max:20',
            'country'                => 'nullable|string|max:100',
            'notes'                  => 'nullable|string',
            'user_id'                => 'nullable|exists:users,id',
        ]);

        $client->update($data);

        return redirect()->route('crm.clients.show', $client)
            ->with('success', 'Client updated successfully.');
    }

    public function destroy(BusinessClient $client)
    {
        $name = $client->full_name;
        $client->delete();

        return redirect()->route('crm.clients.index')
            ->with('success', "$name has been removed.");
    }
}
