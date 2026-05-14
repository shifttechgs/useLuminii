<x-crm::layout title="Edit Client">

<div class="crm-page-header">
    <div>
        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
            <a href="{{ route('crm.clients.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Clients</a>
            <span style="color:var(--color-ink-3);">/</span>
            <a href="{{ route('crm.clients.show', $client) }}" style="color:var(--color-ink-3);font-size:0.875rem;">{{ $client->full_name }}</a>
            <span style="color:var(--color-ink-3);">/</span>
            <span style="font-size:0.875rem;">Edit</span>
        </div>
        <h1 class="crm-page-title">Edit {{ $client->full_name }}</h1>
    </div>
    <a href="{{ route('crm.clients.show', $client) }}" class="crm-btn crm-btn-secondary">View Profile</a>
</div>

<form method="POST" action="{{ route('crm.clients.update', $client) }}">
@csrf @method('PUT')
<div style="display:grid;grid-template-columns:1fr 360px;gap:1.25rem;">

    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Personal Information</span></div>
            <div class="crm-card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div>
                    <label class="crm-label">First Name <span style="color:var(--color-danger);">*</span></label>
                    <input type="text" name="firstname" value="{{ old('firstname', $client->firstname) }}" class="crm-input" required>
                </div>
                <div>
                    <label class="crm-label">Last Name <span style="color:var(--color-danger);">*</span></label>
                    <input type="text" name="lastname" value="{{ old('lastname', $client->lastname) }}" class="crm-input" required>
                </div>
                <div>
                    <label class="crm-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $client->email) }}" class="crm-input">
                </div>
                <div>
                    <label class="crm-label">Phone</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', $client->phone_number) }}" class="crm-input">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Company</label>
                    <input type="text" name="company" value="{{ old('company', $client->company) }}" class="crm-input">
                </div>
                <div>
                    <label class="crm-label">Communication Preference</label>
                    <select name="communication_preference" class="crm-select">
                        <option value="">— Select —</option>
                        @foreach(['Email','WhatsApp','Phone'] as $pref)
                        <option value="{{ $pref }}" {{ old('communication_preference', $client->communication_preference)==$pref?'selected':'' }}>{{ $pref }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Assigned Rep</label>
                    <select name="user_id" class="crm-select">
                        <option value="">— Unassigned —</option>
                        @foreach($reps as $rep)
                        <option value="{{ $rep->id }}" {{ old('user_id', $client->user_id)==$rep->id?'selected':'' }}>{{ $rep->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Notes</label>
                    <textarea name="notes" class="crm-textarea" rows="3">{{ old('notes', $client->notes) }}</textarea>
                </div>
            </div>
        </div>
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Address</span></div>
            <div class="crm-card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div style="grid-column:1/-1;"><label class="crm-label">Street</label><input type="text" name="street" value="{{ old('street', $client->street) }}" class="crm-input"></div>
                <div><label class="crm-label">City</label><input type="text" name="city" value="{{ old('city', $client->city) }}" class="crm-input"></div>
                <div><label class="crm-label">Province</label><input type="text" name="province" value="{{ old('province', $client->province) }}" class="crm-input"></div>
                <div><label class="crm-label">Postal Code</label><input type="text" name="postal_code" value="{{ old('postal_code', $client->postal_code) }}" class="crm-input"></div>
                <div><label class="crm-label">Country</label><input type="text" name="country" value="{{ old('country', $client->country) }}" class="crm-input"></div>
            </div>
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Classification</span></div>
            <div class="crm-card-body" style="display:flex;flex-direction:column;gap:1rem;">
                <div>
                    <label class="crm-label">Client Type</label>
                    <select name="client_type" class="crm-select">
                        @foreach(['Lead','Client','Inactive'] as $t)
                        <option value="{{ $t }}" {{ old('client_type', $client->client_type)==$t?'selected':'' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Lead Source</label>
                    <select name="lead_source" class="crm-select">
                        <option value="">— Select —</option>
                        @foreach(['Website','Referral','Social Media','Cold Call','Walk-in','Other'] as $src)
                        <option value="{{ $src }}" {{ old('lead_source', $client->lead_source)==$src?'selected':'' }}>{{ $src }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div style="display:flex;flex-direction:column;gap:0.5rem;">
            <button type="submit" class="crm-btn crm-btn-primary crm-btn-lg" style="width:100%;">Save Changes</button>
            <a href="{{ route('crm.clients.show', $client) }}" class="crm-btn crm-btn-ghost" style="width:100%;justify-content:center;">Cancel</a>
        </div>
    </div>

</div>
</form>

</x-crm::layout>

