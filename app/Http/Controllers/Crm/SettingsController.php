<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $setup = BusinessSetup::first() ?? new BusinessSetup();
        return view('crm.settings.index', compact('setup'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'business_name'         => 'required|string|max:255',
            'email'                 => 'required|email',
            'phone'                 => 'nullable|string|max:30',
            'website'               => 'nullable|string|max:255',
            'vat_number'            => 'nullable|string|max:100',
            'registration_number'   => 'nullable|string|max:100',
            'street'                => 'nullable|string|max:255',
            'city'                  => 'nullable|string|max:100',
            'province'              => 'nullable|string|max:100',
            'postal_code'           => 'nullable|string|max:20',
            'country'               => 'nullable|string|max:100',
            'bank_name'             => 'nullable|string|max:100',
            'bank_account_name'     => 'nullable|string|max:255',
            'bank_account_number'   => 'nullable|string|max:50',
            'bank_branch_code'      => 'nullable|string|max:20',
            'bank_account_type'     => 'nullable|string|max:50',
            'payment_instructions'  => 'nullable|string',
            'logo'                  => 'nullable|image|max:2048',
        ]);

        $setup = BusinessSetup::firstOrNew([]);

        if ($request->hasFile('logo')) {
            if ($setup->logo_path) {
                Storage::disk('public')->delete($setup->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('business', 'public');
        }
        unset($data['logo']);

        $setup->fill($data)->save();

        return back()->with('success', 'Business settings saved.');
    }
}


