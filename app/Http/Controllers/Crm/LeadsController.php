<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\BusinessClient;
use App\Models\BusinessService;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;

class LeadsController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::orderByRaw("FIELD(priority, 'Urgent', 'High', 'Normal', 'Low')")
            ->orderBy('created_at', 'asc');

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%")
                  ->orWhere('company', 'like', "%$search%");
            });
        }
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($source = $request->get('source')) {
            $query->where('source', $source);
        }

        $leads = $query->paginate(25)->withQueryString();

        $stats = [
            'total'         => Lead::count(),
            'new'           => Lead::where('status', 'New')->count(),
            'contacted'     => Lead::where('status', 'Contacted')->count(),
            'qualified'     => Lead::where('status', 'Qualified')->count(),
            'converted'     => Lead::where('status', 'Converted')->count(),
        ];

        return view('crm.leads.index', compact('leads', 'stats'));
    }

    public function create()
    {
        $services = BusinessService::where('is_active', true)->orderBy('category')->orderBy('name')->get();
        $users    = User::orderBy('name')->get();
        return view('crm.leads.create', compact('services', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:191',
            'email'               => 'nullable|email|max:191',
            'phone'               => 'nullable|string|max:30',
            'company'             => 'nullable|string|max:191',
            'source'              => 'required|in:website,call,referral,email,social,manual',
            'status'              => 'required|in:New,Contacted,Qualified,Proposal Sent,Converted,Closed',
            'priority'            => 'nullable|in:Low,Normal,High,Urgent',
            'budget'              => 'nullable|numeric|min:0',
            'services_interested' => 'nullable|array',
            'services_interested.*'=> 'string',
            'message'             => 'nullable|string',
            'admin_notes'         => 'nullable|string',
            'assigned_to'         => 'nullable|exists:users,id',
        ]);

        $data['priority'] = $data['priority'] ?? 'Normal';

        $lead = Lead::create($data);

        ActivityLog::record('created', 'Lead', $lead->id, "Lead '{$lead->name}' captured via {$lead->source}");

        return redirect()->route('crm.leads.show', $lead)
            ->with('success', 'Lead captured successfully.');
    }

    public function show(Lead $lead)
    {
        $lead->load('assignedTo');
        return view('crm.leads.show', compact('lead'));
    }

    public function convert(Lead $lead)
    {
        $nameParts = explode(' ', trim($lead->name), 2);
        $client = BusinessClient::create([
            'firstname'    => $nameParts[0],
            'lastname'     => $nameParts[1] ?? '-',
            'email'        => $lead->email,
            'phone_number' => $lead->phone,
            'company'      => $lead->company,
            'client_type'  => 'Client',
            'lead_source'  => ucfirst($lead->source),
            'notes'        => $lead->message,
            'user_id'      => auth()->id(),
        ]);

        $lead->update([
            'status'               => 'Converted',
            'converted_client_id'  => $client->id,
        ]);

        ActivityLog::record('converted', 'Lead', $lead->id, "Lead converted to client {$client->client_id}");

        return redirect()->route('crm.clients.show', $client)
            ->with('success', 'Lead converted to client. You can now create a request.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('crm.leads.index')->with('success', 'Lead removed.');
    }
}
