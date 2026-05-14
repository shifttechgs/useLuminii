<x-crm::layout title="Business Settings">
<div class="crm-page-header">
    <div><h1 class="crm-page-title">Business Settings</h1><p class="crm-page-subtitle">Profile, banking and invoice preferences</p></div>
</div>

<form method="POST" action="{{ route('crm.settings.update') }}" enctype="multipart/form-data">
@csrf
<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">

    {{-- Business Profile --}}
    <div class="crm-card">
        <div class="crm-card-header"><span class="crm-card-title">Business Profile</span></div>
        <div class="crm-card-body" style="display:flex;flex-direction:column;gap:1rem;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div style="grid-column:1/-1;"><label class="crm-label">Business Name <span style="color:var(--color-danger);">*</span></label><input type="text" name="business_name" value="{{ old('business_name', $setup->business_name) }}" class="crm-input" required></div>
                <div><label class="crm-label">Registration Number</label><input type="text" name="registration_number" value="{{ old('registration_number', $setup->registration_number) }}" class="crm-input"></div>
                <div><label class="crm-label">VAT Number <span class="crm-label-hint">(when registered)</span></label><input type="text" name="vat_number" value="{{ old('vat_number', $setup->vat_number) }}" class="crm-input" placeholder="Not yet registered"></div>
                <div><label class="crm-label">Email <span style="color:var(--color-danger);">*</span></label><input type="email" name="email" value="{{ old('email', $setup->email) }}" class="crm-input" required></div>
                <div><label class="crm-label">Phone</label><input type="text" name="phone" value="{{ old('phone', $setup->phone) }}" class="crm-input"></div>
                <div style="grid-column:1/-1;"><label class="crm-label">Website</label><input type="text" name="website" value="{{ old('website', $setup->website ?? 'https://shifttechgs.com') }}" class="crm-input"></div>
            </div>
            <div>
                <label class="crm-label">Logo</label>
                @if($setup->logo_path)<div style="margin-bottom:0.5rem;"><img src="{{ \Illuminate\Support\Facades\Storage::url($setup->logo_path) }}" style="height:48px;object-fit:contain;"></div>@endif
                <input type="file" name="logo" class="crm-input" accept=".jpg,.jpeg,.png,.svg" style="padding:0.375rem;">
            </div>
        </div>
    </div>

    {{-- Address --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Address</span></div>
            <div class="crm-card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div style="grid-column:1/-1;"><label class="crm-label">Street</label><input type="text" name="street" value="{{ old('street', $setup->street) }}" class="crm-input"></div>
                <div><label class="crm-label">City</label><input type="text" name="city" value="{{ old('city', $setup->city) }}" class="crm-input"></div>
                <div><label class="crm-label">Province</label><input type="text" name="province" value="{{ old('province', $setup->province) }}" class="crm-input"></div>
                <div><label class="crm-label">Postal Code</label><input type="text" name="postal_code" value="{{ old('postal_code', $setup->postal_code) }}" class="crm-input"></div>
                <div><label class="crm-label">Country</label><input type="text" name="country" value="{{ old('country', $setup->country ?? 'South Africa') }}" class="crm-input"></div>
            </div>
        </div>

        {{-- Banking --}}
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Banking Details</span><span class="crm-badge crm-badge-warning">Printed on invoices</span></div>
            <div class="crm-card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div><label class="crm-label">Bank Name</label><input type="text" name="bank_name" value="{{ old('bank_name', $setup->bank_name) }}" class="crm-input"></div>
                <div><label class="crm-label">Account Name</label><input type="text" name="bank_account_name" value="{{ old('bank_account_name', $setup->bank_account_name) }}" class="crm-input"></div>
                <div><label class="crm-label">Account Number</label><input type="text" name="bank_account_number" value="{{ old('bank_account_number', $setup->bank_account_number) }}" class="crm-input"></div>
                <div><label class="crm-label">Branch Code</label><input type="text" name="bank_branch_code" value="{{ old('bank_branch_code', $setup->bank_branch_code) }}" class="crm-input"></div>
                <div style="grid-column:1/-1;"><label class="crm-label">Account Type</label><input type="text" name="bank_account_type" value="{{ old('bank_account_type', $setup->bank_account_type) }}" class="crm-input" placeholder="Current / Savings / Cheque"></div>
                <div style="grid-column:1/-1;"><label class="crm-label">Payment Instructions</label><textarea name="payment_instructions" class="crm-textarea" rows="3">{{ old('payment_instructions', $setup->payment_instructions) }}</textarea></div>
            </div>
        </div>
    </div>

    {{-- VAT Note --}}
    <div class="crm-card" style="grid-column:1/-1;border-color:#fedf89;background:#fffaeb;">
        <div class="crm-card-body" style="display:flex;align-items:flex-start;gap:0.75rem;">
            <svg fill="none" viewBox="0 0 24 24" stroke="#f79009" style="width:1.25rem;height:1.25rem;flex-shrink:0;margin-top:2px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
            <div>
                <p style="font-size:0.875rem;font-weight:600;color:#b54708;">VAT — Not Yet Registered</p>
                <p style="font-size:0.8125rem;color:#b54708;margin-top:0.125rem;">ShiftTech is not currently VAT registered with SARS. All quotes and invoices are issued excluding VAT.</p>
            </div>
        </div>
    </div>

</div>

<div style="margin-top:1.25rem;display:flex;justify-content:flex-end;gap:0.5rem;">
    <button type="submit" class="crm-btn crm-btn-primary crm-btn-lg">Save Settings</button>
</div>
</form>
</x-crm::layout>

@push('head')
@php use Illuminate\Support\Facades\Storage; @endphp
@endpush

