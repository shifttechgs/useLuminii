<x-crm::layout title="New Job">

<div class="crm-page-header">
    <div>
        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
            <a href="{{ route('crm.jobs.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Jobs</a>
            <span style="color:var(--color-ink-3);">/</span>
            <span style="font-size:0.875rem;color:var(--color-ink-2);">New Job</span>
        </div>
        <h1 class="crm-page-title">New Job</h1>
    </div>
</div>

<div x-data="jobForm()" x-init="init()">
<form method="POST" action="{{ route('crm.jobs.store') }}">
@csrf

<input type="hidden" name="request_id" :value="selectedRequest?.request_id ?? ''">

<div style="display:grid;grid-template-columns:1fr 320px;gap:1.25rem;align-items:start;">

    {{-- ── LEFT ── --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        {{-- Client & Request selector --}}
        <div class="crm-card">
            <div class="crm-card-header">
                <span class="crm-card-title">Client &amp; Request</span>
                <span x-show="selectedRequest" x-cloak
                    style="font-size:0.75rem;background:#ecfdf3;color:#027a48;padding:2px 10px;border-radius:99px;font-weight:600;"
                    x-text="'Linked: ' + (selectedRequest?.request_id ?? '')"></span>
            </div>
            <div class="crm-card-body" style="display:flex;flex-direction:column;gap:1rem;">

                <div>
                    <label class="crm-label">Client <span style="color:var(--color-danger);">*</span></label>
                    <select name="client_id" class="crm-select" x-model="clientId" @change="onClientChange()" required>
                        <option value="">— Select Client —</option>
                        @foreach($clients as $c)
                        <option value="{{ $c->client_id }}" {{ (old('client_id', $selectedClient?->client_id) == $c->client_id) ? 'selected' : '' }}>
                            {{ $c->company ? $c->company.' — ' : '' }}{{ $c->firstname }} {{ $c->lastname }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div x-show="clientId" x-cloak>
                    <label class="crm-label">
                        Linked Client Request
                        <span style="font-size:0.75rem;color:var(--color-ink-3);font-weight:400;margin-left:4px;">(optional — auto-fills the form below)</span>
                    </label>

                    <template x-if="loadingRequests">
                        <div style="height:40px;background:var(--color-surface-2);border:1px solid var(--color-border);border-radius:var(--radius-sm);display:flex;align-items:center;padding:0 0.75rem;gap:0.5rem;color:var(--color-ink-3);font-size:0.875rem;">
                            <svg style="width:14px;height:14px;animation:crm-spin 1s linear infinite;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Loading requests…
                        </div>
                    </template>

                    <template x-if="!loadingRequests && requests.length === 0">
                        <p style="font-size:0.8125rem;color:var(--color-ink-3);padding:0.375rem 0;">No open requests for this client.</p>
                    </template>

                    <template x-if="!loadingRequests && requests.length > 0">
                        <div style="display:flex;flex-direction:column;gap:0.375rem;margin-top:0.25rem;">
                            <template x-for="req in requests" :key="req.request_id">
                                <button type="button" @click="selectRequest(req)"
                                    :style="selectedRequest?.request_id === req.request_id
                                        ? 'border:2px solid #2e90fa;background:#eff8ff;'
                                        : 'border:1px solid var(--color-border);background:var(--color-surface);'"
                                    style="display:flex;align-items:flex-start;gap:0.75rem;padding:0.75rem 1rem;border-radius:var(--radius-sm);text-align:left;width:100%;cursor:pointer;transition:all 150ms;">
                                    <div style="margin-top:3px;flex-shrink:0;">
                                        <div style="width:14px;height:14px;border-radius:50%;display:flex;align-items:center;justify-content:center;"
                                            :style="selectedRequest?.request_id === req.request_id ? 'background:#2e90fa;' : 'background:#d1d5db;'">
                                            <svg x-show="selectedRequest?.request_id === req.request_id" fill="white" viewBox="0 0 20 20" style="width:9px;height:9px;"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        </div>
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;">
                                            <span style="font-size:0.875rem;font-weight:600;color:var(--color-ink-1);" x-text="req.title"></span>
                                            <span style="font-size:0.6875rem;font-family:monospace;color:var(--color-ink-3);" x-text="req.request_id"></span>
                                            <template x-if="req.service">
                                                <span style="font-size:0.6875rem;background:#eff8ff;color:#2e90fa;padding:1px 7px;border-radius:99px;font-weight:500;" x-text="req.service.name + ' — R ' + req.service.unit_price.toFixed(2)"></span>
                                            </template>
                                        </div>
                                        <p x-show="req.description" style="font-size:0.8125rem;color:var(--color-ink-3);margin-top:2px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" x-text="req.description"></p>
                                    </div>
                                </button>
                            </template>
                            <button type="button" x-show="selectedRequest" @click="clearRequest()"
                                style="font-size:0.8125rem;color:var(--color-ink-3);text-align:left;padding:0.25rem 0.5rem;border:none;background:none;cursor:pointer;">✕ Clear selection</button>
                        </div>
                    </template>
                </div>

            </div>
        </div>

        {{-- Job Details --}}
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Job Details</span></div>
            <div class="crm-card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">

                <div style="grid-column:1/-1;">
                    <label class="crm-label">Job Title <span style="color:var(--color-danger);">*</span></label>
                    <input type="text" name="job_title" class="crm-input"
                        :value="jobTitle" @input="jobTitle = $event.target.value"
                        placeholder="e.g. Website Maintenance" required>
                </div>

                <div>
                    <label class="crm-label">Linked Quote</label>
                    <select name="quote_id" class="crm-select">
                        <option value="">— None —</option>
                        @foreach($quotes as $q)
                        <option value="{{ $q->quote_id }}" {{ old('quote_id')==$q->quote_id?'selected':'' }}>{{ $q->quote_id }} — {{ $q->job_title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="crm-label">Assign To</label>
                    <select name="team_member_assigned_id" class="crm-select">
                        <option value="">— Unassigned —</option>
                        @foreach($team as $member)
                        <option value="{{ $member->id }}" {{ old('team_member_assigned_id')==$member->id?'selected':'' }}>{{ $member->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="crm-label">Scheduled Date / Time</label>
                    <input type="datetime-local" name="job_date_time" value="{{ old('job_date_time') }}" class="crm-input">
                </div>

                <div>
                    <label class="crm-label">Status</label>
                    <select name="job_status" class="crm-select">
                        @foreach(['New','Scheduled','InProgress','Completed','Cancelled'] as $s)
                        <option value="{{ $s }}" {{ old('job_status','New')==$s?'selected':'' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="grid-column:1/-1;">
                    <label class="crm-label">Instructions <span class="crm-label-hint">(visible to team)</span></label>
                    <textarea name="instructions" class="crm-textarea" rows="3"
                        :value="instructions" @input="instructions = $event.target.value"></textarea>
                </div>

                <div style="grid-column:1/-1;">
                    <label class="crm-label">Internal Notes</label>
                    <textarea name="job_notes" class="crm-textarea" rows="2"
                        :value="jobNotes" @input="jobNotes = $event.target.value"></textarea>
                </div>
            </div>
        </div>

        {{-- Line Items --}}
        <div x-data="lineItems(@json(old('items', [])))" class="crm-card" style="overflow:visible;">
            <div class="crm-card-header">
                <span class="crm-card-title">Line Items</span>
                <button type="button" @click="addRow()" class="crm-btn crm-btn-secondary crm-btn-sm">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Item
                </button>
            </div>
            <div class="crm-table-wrap" style="border:none;border-radius:0;box-shadow:none;overflow:auto;">
                <table class="crm-table" style="min-width:540px;">
                    <thead><tr>
                        <th style="width:48%;">Service / Description</th>
                        <th style="width:13%;">Qty</th>
                        <th style="width:18%;">Unit Price</th>
                        <th style="width:15%;">Total</th>
                        <th style="width:6%;"></th>
                    </tr></thead>
                    <tbody>
                    <template x-for="(row, idx) in rows" :key="idx">
                        <tr>
                            <td><input type="text" class="crm-input" :name="`items[${idx}][description]`" x-model="row.description" placeholder="Item description" required></td>
                            <td><input type="number" class="crm-input" :name="`items[${idx}][quantity]`" x-model.number="row.quantity" @input="calc(row)" min="0" step="0.01" required></td>
                            <td><input type="number" class="crm-input" :name="`items[${idx}][unit_price]`" x-model.number="row.unit_price" @input="calc(row)" min="0" step="0.01" required></td>
                            <td style="font-weight:500;" x-text="'{{ \App\Models\BusinessSetup::currencySymbol() }} ' + row.line_total.toFixed(2)"></td>
                            <td><button type="button" @click="rows.splice(idx,1)" class="crm-icon-btn" style="color:var(--color-danger);"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1rem;height:1rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button></td>
                        </tr>
                    </template>
                    <template x-if="rows.length === 0">
                        <tr><td colspan="5"><div class="crm-empty" style="padding:1.5rem;"><p class="crm-empty-text">No items yet — pick from the catalogue →</p></div></td></tr>
                    </template>
                    </tbody>
                </table>
            </div>
            <div class="crm-card-footer" style="display:flex;justify-content:flex-end;">
                <div style="min-width:220px;">
                    <div class="crm-detail-row"><span class="crm-detail-label">Subtotal</span><span class="crm-detail-value" x-text="'{{ \App\Models\BusinessSetup::currencySymbol() }} ' + subtotal().toFixed(2)"></span></div>
                    <div class="crm-detail-row" style="font-size:1rem;font-weight:700;"><span class="crm-detail-label" style="color:var(--color-ink-1);font-weight:700;">Total</span><span class="crm-detail-value" x-text="'{{ \App\Models\BusinessSetup::currencySymbol() }} ' + subtotal().toFixed(2)"></span></div>
                </div>
            </div>
            {{-- Listen for events from jobForm --}}
            <span x-init="window.addEventListener('add-line-item', e => { rows.push({ description: e.detail.description, quantity: 1, unit_price: e.detail.unit_price, line_total: e.detail.unit_price }); })"></span>
        </div>

    </div>

    {{-- ── RIGHT ── --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:72px;">

        <button type="submit" class="crm-btn crm-btn-primary crm-btn-lg" style="width:100%;">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1rem;height:1rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Create Job
        </button>
        <a href="{{ route('crm.jobs.index') }}" class="crm-btn crm-btn-ghost" style="width:100%;justify-content:center;">Cancel</a>

        {{-- Linked request badge --}}
        <div x-show="selectedRequest" x-cloak class="crm-card" style="border:1.5px solid #2e90fa;overflow:hidden;">
            <div class="crm-card-header" style="background:#eff8ff;border-bottom:1px solid #bae6fd;">
                <span class="crm-card-title" style="color:#0369a1;font-size:0.875rem;">Linked Request</span>
                <span style="font-size:0.6875rem;background:#bae6fd;color:#0369a1;padding:2px 7px;border-radius:99px;font-weight:600;" x-text="selectedRequest?.request_id"></span>
            </div>
            <div style="padding:0.875rem 1rem;font-size:0.8125rem;color:var(--color-ink-2);">
                <p style="font-weight:600;color:var(--color-ink-1);margin-bottom:4px;" x-text="selectedRequest?.title"></p>
                <p x-show="selectedRequest?.service" style="color:#0284c7;font-size:0.8125rem;">
                    🏷 <span x-text="selectedRequest?.service?.name"></span>
                    — <span x-text="selectedRequest?.service ? '{{ \App\Models\BusinessSetup::currencySymbol() }} ' + selectedRequest.service.unit_price.toFixed(2) : ''"></span>
                </p>
                <p style="font-size:0.75rem;color:#0369a1;font-weight:500;margin-top:8px;background:#e0f2fe;border-radius:4px;padding:4px 8px;">
                    ✅ Will be set to <strong>Quoted</strong> on save
                </p>
            </div>
        </div>

        {{-- Services Catalogue --}}
        <div class="crm-card">
            <div class="crm-card-header">
                <span class="crm-card-title">Services Catalogue</span>
                <span style="font-size:0.6875rem;color:var(--color-ink-3);">Click to add line item</span>
            </div>
            <div style="padding:0.625rem;">
                <input type="text" x-model="serviceSearch" placeholder="Search services…"
                    class="crm-input" style="margin-bottom:0.5rem;font-size:0.8125rem;">

                <template x-if="loadingServices">
                    <p style="font-size:0.8125rem;color:var(--color-ink-3);padding:0.5rem 0;">Loading…</p>
                </template>
                <template x-if="!loadingServices">
                    <div style="display:flex;flex-direction:column;gap:2px;max-height:380px;overflow-y:auto;">
                        <template x-for="svc in filteredServices()" :key="svc.service_id">
                            <button type="button" @click="addServiceToItems(svc)"
                                style="display:flex;align-items:center;justify-content:space-between;gap:0.5rem;padding:0.5rem 0.625rem;border-radius:var(--radius-sm);border:1px solid transparent;background:transparent;text-align:left;width:100%;cursor:pointer;transition:background 120ms,border 120ms;"
                                onmouseover="this.style.background='var(--color-surface-2)';this.style.borderColor='var(--color-border)'"
                                onmouseout="this.style.background='transparent';this.style.borderColor='transparent'">
                                <div style="min-width:0;flex:1;">
                                    <p style="font-size:0.8125rem;font-weight:500;color:var(--color-ink-1);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" x-text="svc.name"></p>
                                    <p x-show="svc.category" style="font-size:0.6875rem;color:var(--color-ink-3);" x-text="svc.category"></p>
                                </div>
                                <div style="flex-shrink:0;text-align:right;">
                                    <p style="font-size:0.8125rem;font-weight:600;color:var(--color-ink-1);" x-text="'{{ \App\Models\BusinessSetup::currencySymbol() }} ' + svc.unit_price.toFixed(2)"></p>
                                    <div style="width:20px;height:20px;background:#eff8ff;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-left:auto;margin-top:2px;">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="#2e90fa" style="width:11px;height:11px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                    </div>
                                </div>
                            </button>
                        </template>
                        <template x-if="filteredServices().length === 0">
                            <p style="font-size:0.8125rem;color:var(--color-ink-3);padding:0.5rem 0;">No services found.</p>
                        </template>
                    </div>
                </template>
            </div>
        </div>

    </div>
</div>

</form>
</div>

@push('scripts')
<script>
function jobForm() {
    return {
        clientId: @json(old('client_id', $selectedClient?->client_id ?? '')),
        requests: @json($selectedClientRequests->map(fn($r) => [
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
        ])),
        loadingRequests: false,
        selectedRequest: null,

        services: [],
        loadingServices: false,
        serviceSearch: '',

        jobTitle: @json(old('job_title', '')),
        instructions: @json(old('instructions', '')),
        jobNotes: @json(old('job_notes', '')),

        async init() {
            await this.fetchServices();
        },

        async onClientChange() {
            this.requests = [];
            this.selectedRequest = null;
            if (!this.clientId) return;
            this.loadingRequests = true;
            try {
                const res = await fetch(`{{ route('crm.jobs.ajax.requests') }}?client_id=${encodeURIComponent(this.clientId)}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                this.requests = await res.json();
            } catch(e) { console.error(e); }
            this.loadingRequests = false;
        },

        selectRequest(req) {
            this.selectedRequest = req;
            if (req.title)            this.jobTitle      = req.title;
            if (req.description)      this.instructions  = req.description;
            if (req.assessment_notes) this.jobNotes       = req.assessment_notes;
            if (req.service) {
                window.dispatchEvent(new CustomEvent('add-line-item', {
                    detail: { description: req.service.name, unit_price: req.service.unit_price }
                }));
            }
        },

        clearRequest() { this.selectedRequest = null; },

        async fetchServices() {
            this.loadingServices = true;
            try {
                const res = await fetch(`{{ route('crm.jobs.ajax.services') }}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                this.services = await res.json();
            } catch(e) { console.error(e); }
            this.loadingServices = false;
        },

        filteredServices() {
            const q = this.serviceSearch.toLowerCase();
            if (!q) return this.services;
            return this.services.filter(s =>
                s.name.toLowerCase().includes(q) ||
                (s.category && s.category.toLowerCase().includes(q))
            );
        },

        addServiceToItems(svc) {
            window.dispatchEvent(new CustomEvent('add-line-item', {
                detail: { description: svc.name, unit_price: svc.unit_price }
            }));
        },
    };
}

function lineItems(existing) {
    return {
        rows: existing.length > 0 ? existing.map(i => ({
            description: i.description || '',
            quantity:    parseFloat(i.quantity) || 1,
            unit_price:  parseFloat(i.unit_price) || 0,
            line_total:  parseFloat(i.line_total) || 0,
        })) : [],
        addRow() { this.rows.push({ description: '', quantity: 1, unit_price: 0, line_total: 0 }); },
        calc(row) { row.line_total = row.quantity * row.unit_price; },
        subtotal() { return this.rows.reduce((s, r) => s + r.line_total, 0); },
    };
}
</script>
<style>
@keyframes crm-spin { to { transform: rotate(360deg); } }
[x-cloak] { display: none !important; }
</style>
@endpush

</x-crm::layout>


