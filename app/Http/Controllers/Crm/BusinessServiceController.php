<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\BusinessService;
use Illuminate\Http\Request;

class BusinessServiceController extends Controller
{
    public function index()
    {
        $services = BusinessService::orderBy('category')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total'    => BusinessService::count(),
            'active'   => BusinessService::where('is_active', true)->count(),
            'inactive' => BusinessService::where('is_active', false)->count(),
        ];

        return view('crm.services.index', compact('services', 'stats'));
    }

    public function create()
    {
        return view('crm.services.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'nullable|string|max:100',
            'unit_type'   => 'required|string|max:50',
            'unit_price'  => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        BusinessService::create($data);

        return redirect()->route('crm.services.index')->with('success', 'Service created.');
    }

    public function edit(BusinessService $service)
    {
        return view('crm.services.edit', compact('service'));
    }

    public function update(Request $request, BusinessService $service)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'nullable|string|max:100',
            'unit_type'   => 'required|string|max:50',
            'unit_price'  => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $service->update($data);

        return redirect()->route('crm.services.index')->with('success', 'Service updated.');
    }

    public function destroy(BusinessService $service)
    {
        $service->delete();
        return back()->with('success', 'Service deleted.');
    }
}
