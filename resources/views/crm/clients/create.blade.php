<x-crm::layout title="New Client">

<div class="crm-page-header">
    <div>
        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
            <a href="{{ route('crm.clients.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Clients</a>
            <span style="color:var(--color-ink-3);">/</span>
            <span style="font-size:0.875rem;">New Client</span>
        </div>
        <h1 class="crm-page-title">New Client</h1>
    </div>
</div>

<form method="POST" action="{{ route('crm.clients.store') }}">
@csrf
<div style="display:grid;grid-template-columns:1fr 360px;gap:1.25rem;">

    {{-- Main --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Personal Information</span></div>
            <div class="crm-card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div>
                    <label class="crm-label">First Name <span style="color:var(--color-danger);">*</span></label>
                    <input type="text" name="firstname" value="{{ old('firstname') }}" class="crm-input @error('firstname') crm-input-error @enderror" required>
                    @error('firstname')<p class="crm-error-msg">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="crm-label">Last Name <span style="color:var(--color-danger);">*</span></label>
                    <input type="text" name="lastname" value="{{ old('lastname') }}" class="crm-input @error('lastname') crm-input-error @enderror" required>
                    @error('lastname')<p class="crm-error-msg">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="crm-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="crm-input" placeholder="client@company.com">
                </div>
                <div>
                    <label class="crm-label">Phone</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number') }}" class="crm-input" placeholder="+27 82 000 0000">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Company</label>
                    <input type="text" name="company" value="{{ old('company') }}" class="crm-input" placeholder="Company or trading name">
                </div>
                <div>
                    <label class="crm-label">Communication Preference</label>
                    <select name="communication_preference" class="crm-select">
                        <option value="">— Select —</option>
                        <option value="Email">Email</option>
                        <option value="WhatsApp">WhatsApp</option>
                        <option value="Phone">Phone</option>
                    </select>
                </div>
                <div>
                    <label class="crm-label">Assigned Rep</label>
                    <select name="user_id" class="crm-select">
                        <option value="">— Unassigned —</option>
                        @foreach($reps as $rep)
                        <option value="{{ $rep->id }}">{{ $rep->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Notes <span class="crm-label-hint">(internal only)</span></label>
                    <textarea name="notes" class="crm-textarea" rows="3" placeholder="Internal notes about this client…">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Address</span></div>
            <div class="crm-card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Street Address</label>
                    <input type="text" name="street" value="{{ old('street') }}" class="crm-input">
                </div>
                <div><label class="crm-label">City</label><input type="text" name="city" value="{{ old('city') }}" class="crm-input"></div>
                <div><label class="crm-label">Province</label><input type="text" name="province" value="{{ old('province') }}" class="crm-input"></div>
                <div><label class="crm-label">Postal Code</label><input type="text" name="postal_code" value="{{ old('postal_code') }}" class="crm-input"></div>
                <div><label class="crm-label">Country</label><input type="text" name="country" value="{{ old('country') }}" class="crm-input" value="South Africa"></div>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Classification</span></div>
            <div class="crm-card-body" style="display:flex;flex-direction:column;gap:1rem;">
                <div>
                    <label class="crm-label">Client Type <span style="color:var(--color-danger);">*</span></label>
                    <select name="client_type" class="crm-select" required>
                        <option value="Lead" {{ old('client_type','Lead')=='Lead'?'selected':'' }}>Lead</option>
                        <option value="Client" {{ old('client_type')=='Client'?'selected':'' }}>Client</option>
                        <option value="Inactive" {{ old('client_type')=='Inactive'?'selected':'' }}>Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="crm-label">Lead Source</label>
                    <select name="lead_source" class="crm-select">
                        <option value="">— Select —</option>
                        @foreach(['Website','Referral','Social Media','Cold Call','Walk-in','Other'] as $src)
                        <option value="{{ $src }}" {{ old('lead_source')==$src?'selected':'' }}>{{ $src }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:0.5rem;">
            <button type="submit" class="crm-btn crm-btn-primary crm-btn-lg" style="width:100%;">Create Client</button>
            <a href="{{ route('crm.clients.index') }}" class="crm-btn crm-btn-ghost" style="width:100%;justify-content:center;">Cancel</a>
        </div>
    </div>

</div>
</form>

</x-crm::layout>

