<x-crm::layout title="New Quote">

<div class="crm-page-header">
    <div>
        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
            <a href="{{ route('crm.quotes.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Quotes</a>
            <span style="color:var(--color-ink-3);">/</span>
            <span style="font-size:0.875rem;color:var(--color-ink-2);">New Quote</span>
        </div>
        <h1 class="crm-page-title">New Quote</h1>
        <p class="crm-page-subtitle">Select a client to load their open requests, or build a quote from scratch.</p>
    </div>
</div>

{{--
    SINGLE Alpine component — no cross-component events, no timing bugs.
    Rows live inside quoteForm state: { service_id, description, quantity, unit_price, line_total }
--}}
<div x-data="quoteForm()" x-init="init()">
<form id="quote-form" method="POST" action="{{ route('crm.quotes.store') }}">
@csrf

<input type="hidden" name="source_request_id" :value="selectedRequest?.id ?? ''">
<input type="hidden" name="send_immediately"   :value="sendImmediately ? '1' : '0'">

<div style="display:grid;grid-template-columns:1fr 320px;gap:1.25rem;align-items:start;">

    {{-- ════ LEFT ════ --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        {{-- ── STEP 1: Client & Request ── --}}
        <div class="crm-card">
            <div class="crm-card-header">
                <span class="crm-card-title">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:1.375rem;height:1.375rem;background:var(--color-ink-1);color:#fff;border-radius:50%;font-size:0.625rem;font-weight:700;margin-right:0.5rem;">1</span>
                    Client &amp; Request
                </span>
                <span x-show="selectedRequest" x-cloak
                    style="font-size:0.75rem;background:#ecfdf3;color:#027a48;padding:2px 10px;border-radius:99px;font-weight:600;"
                    x-text="'Linked: ' + (selectedRequest?.request_id ?? '')"></span>
            </div>
            <div class="crm-card-body" style="display:flex;flex-direction:column;gap:1rem;">

                <div>
                    <label class="crm-label">Client <span style="color:var(--color-danger);">*</span></label>
                    <select name="client_id" class="crm-select" x-model="clientId" @change="onClientChange()" required>
                        <option value="">— Select a client —</option>
                        @foreach($clients as $c)
                        <option value="{{ $c->client_id }}" {{ (old('client_id', $selectedClient?->client_id)==$c->client_id) ? 'selected' : '' }}>
                            {{ $c->company ? $c->company.' — ' : '' }}{{ $c->full_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Request picker — only shown once a client is selected --}}
                <div x-show="clientId" x-cloak>
                    <label class="crm-label">
                        Linked Request
                        <span style="font-size:0.75rem;color:var(--color-ink-3);font-weight:400;margin-left:4px;">(optional — auto-fills everything below)</span>
                    </label>

                    <template x-if="loadingRequests">
                        <div style="height:40px;background:var(--color-surface-2);border:1px solid var(--color-border);border-radius:var(--radius-sm);display:flex;align-items:center;padding:0 0.75rem;gap:0.5rem;color:var(--color-ink-3);font-size:0.875rem;">
                            <svg style="width:14px;height:14px;animation:crm-spin 1s linear infinite;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Fetching open requests…
                        </div>
                    </template>

                    <template x-if="!loadingRequests && requests.length === 0">
                        <div style="background:#fffaeb;border:1px solid #fde68a;border-radius:var(--radius-sm);padding:0.625rem 0.875rem;font-size:0.8125rem;color:#92400e;">
                            No open requests — build a manual quote using the services catalogue →
                        </div>
                    </template>

                    <template x-if="!loadingRequests && requests.length > 0">
                        <div style="display:flex;flex-direction:column;gap:0.375rem;margin-top:0.25rem;">
                            <template x-for="req in requests" :key="req.id">
                                <button type="button" @click="selectRequest(req)"
                                    :style="selectedRequest?.id === req.id
                                        ? 'border:2px solid #2e90fa;background:#eff8ff;'
                                        : 'border:1px solid var(--color-border);background:var(--color-surface);'"
                                    style="display:flex;align-items:flex-start;gap:0.75rem;padding:0.75rem 1rem;border-radius:var(--radius-sm);text-align:left;width:100%;cursor:pointer;transition:all 150ms;">
                                    <div style="margin-top:3px;flex-shrink:0;">
                                        <div style="width:14px;height:14px;border-radius:50%;display:flex;align-items:center;justify-content:center;"
                                            :style="selectedRequest?.id === req.id ? 'background:#2e90fa;' : 'background:#d1d5db;'">
                                            <svg x-show="selectedRequest?.id === req.id" fill="white" viewBox="0 0 20 20" style="width:9px;height:9px;"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        </div>
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;margin-bottom:2px;">
                                            <span style="font-size:0.875rem;font-weight:600;color:var(--color-ink-1);" x-text="req.title"></span>
                                            <span style="font-size:0.6875rem;font-family:monospace;color:var(--color-ink-3);" x-text="req.request_id"></span>
                                            <template x-if="req.priority">
                                                <span :style="req.priority==='Urgent'?'background:#fef3f2;color:#b42318':req.priority==='High'?'background:#fffaeb;color:#b54708':'background:#f1f3f7;color:#5a6a7e'"
                                                    style="font-size:0.6875rem;font-weight:600;padding:1px 6px;border-radius:99px;" x-text="req.priority"></span>
                                            </template>
                                            <template x-if="req.service">
                                                <span style="font-size:0.6875rem;background:#eff8ff;color:#2e90fa;padding:1px 7px;border-radius:99px;font-weight:500;"
                                                    x-text="req.service.name + ' — ' + currencySymbol + ' ' + req.service.unit_price.toFixed(2)"></span>
                                            </template>
                                        </div>
                                        <p x-show="req.description" style="font-size:0.8125rem;color:var(--color-ink-3);margin:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" x-text="req.description"></p>
                                    </div>
                                </button>
                            </template>
                            <button type="button" @click="clearRequest()"
                                :style="!selectedRequest ? 'border:1.5px dashed #2e90fa;background:#f0f7ff;color:#1d4ed8;' : 'border:1.5px dashed var(--color-border);color:var(--color-ink-3);'"
                                style="padding:0.5rem 1rem;border-radius:var(--radius-sm);font-size:0.8125rem;cursor:pointer;background:transparent;text-align:left;width:100%;transition:all 150ms;">
                                <span x-text="!selectedRequest ? '✎ Build quote manually (no linked request)' : '✕ Clear — build manually'"></span>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- ── STEP 2: Quote Details ── --}}
        <div class="crm-card">
            <div class="crm-card-header">
                <span class="crm-card-title">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:1.375rem;height:1.375rem;background:var(--color-ink-1);color:#fff;border-radius:50%;font-size:0.625rem;font-weight:700;margin-right:0.5rem;">2</span>
                    Quote Details
                </span>
                <span x-show="selectedRequest" x-cloak
                    style="font-size:0.75rem;background:#ecfdf3;color:#027a48;padding:2px 8px;border-radius:99px;font-weight:600;">✓ Auto-filled</span>
            </div>
            <div class="crm-card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Title / Scope of Work <span style="color:var(--color-danger);">*</span></label>
                    <input type="text" name="job_title" class="crm-input"
                        :value="jobTitle" @input="jobTitle = $event.target.value"
                        placeholder="e.g. Website Redesign &amp; SEO Package" required>
                </div>
                <div>
                    <label class="crm-label">Quote Date <span style="color:var(--color-danger);">*</span></label>
                    <input type="date" name="quote_date" value="{{ old('quote_date', now()->format('Y-m-d')) }}" class="crm-input" required>
                </div>
                <div>
                    <label class="crm-label">Expiry Date</label>
                    <input type="date" name="expiry_date" value="{{ old('expiry_date', now()->addDays(30)->format('Y-m-d')) }}" class="crm-input">
                </div>
                <div>
                    <label class="crm-label">Currency</label>
                    <select name="currency" class="crm-select" x-model="currency">
                        <option value="ZAR">ZAR – South African Rand</option>
                        <option value="USD">USD – US Dollar</option>
                        <option value="EUR">EUR – Euro</option>
                        <option value="GBP">GBP – British Pound</option>
                    </select>
                </div>
                <div>
                    <label class="crm-label">Required Deposit</label>
                    <input type="number" name="required_deposit" value="{{ old('required_deposit', 0) }}" class="crm-input" min="0" step="0.01">
                </div>
                <div>
                    <label class="crm-label">Discount</label>
                    <input type="number" name="discount" value="{{ old('discount', 0) }}" class="crm-input" min="0" step="0.01">
                </div>
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Message to Client <span class="crm-label-hint">(in email body)</span></label>
                    <textarea name="client_notes" class="crm-textarea" rows="3"
                        :value="clientNotes" @input="clientNotes = $event.target.value"
                        placeholder="Thank you for your enquiry. Please find attached your quotation…"></textarea>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Internal Notes <span class="crm-label-hint">(not sent to client)</span></label>
                    <textarea name="internal_notes" class="crm-textarea" rows="2"
                        :value="internalNotes" @input="internalNotes = $event.target.value"></textarea>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Status</label>
                    <select name="status" class="crm-select" x-model="status">
                        @foreach(['Draft','Sent','Accepted','Declined','Expired'] as $s)
                        <option value="{{ $s }}" {{ old('status','Draft')==$s?'selected':'' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    <p x-show="sendImmediately" x-cloak style="font-size:0.75rem;color:#0369a1;margin-top:4px;">Status will be set to <strong>Sent</strong> automatically.</p>
                </div>
            </div>
        </div>

        {{-- ── STEP 3: Line Items ── --}}
        <div class="crm-card" style="overflow:visible;">
            <div class="crm-card-header">
                <span class="crm-card-title">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:1.375rem;height:1.375rem;background:var(--color-ink-1);color:#fff;border-radius:50%;font-size:0.625rem;font-weight:700;margin-right:0.5rem;">3</span>
                    Line Items
                </span>
                <button type="button" @click="addBlankRow()" class="crm-btn crm-btn-secondary crm-btn-sm">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Item
                </button>
            </div>

            {{-- Info strip when auto-filled --}}
            <div x-show="selectedRequest && rows.length > 0" x-cloak
                style="background:#f0f9ff;border-bottom:1px solid #bae6fd;padding:0.5rem 1rem;font-size:0.8125rem;color:#0369a1;display:flex;align-items:center;gap:0.5rem;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Service pre-filled from linked request. Change the service below or adjust the price.
            </div>

            <div style="overflow-x:auto;">
                <table class="crm-table" style="min-width:600px;">
                    <thead>
                        <tr>
                            <th style="width:42%;">Service</th>
                            <th style="width:13%;">Qty</th>
                            <th style="width:18%;" x-text="'Unit Price (' + currencySymbol + ')'">Unit Price</th>
                            <th style="width:13%;">Total</th>
                            <th style="width:14%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <template x-for="(row, idx) in rows" :key="idx">
                        <tr>
                            {{-- Description --}}
                            <td style="min-width:200px;">
                                <input type="text"
                                    class="crm-input"
                                    :name="`items[${idx}][description]`"
                                    x-model="row.description"
                                    placeholder="Service or custom description"
                                    required>
                            </td>
                            {{-- Qty --}}
                            <td>
                                <input type="number" class="crm-input"
                                    :name="`items[${idx}][quantity]`"
                                    x-model.number="row.quantity"
                                    @input="calcRow(row)"
                                    min="0" step="0.01" required>
                            </td>
                            {{-- Unit Price --}}
                            <td>
                                <input type="number" class="crm-input"
                                    :name="`items[${idx}][unit_price]`"
                                    x-model.number="row.unit_price"
                                    @input="calcRow(row)"
                                    min="0" step="0.01" required>
                            </td>
                            {{-- Total --}}
                            <td style="font-weight:600;font-size:0.875rem;white-space:nowrap;"
                                x-text="currencySymbol + ' ' + row.line_total.toFixed(2)"></td>
                            {{-- Remove --}}
                            <td>
                                <button type="button" @click="rows.splice(idx,1)"
                                    class="crm-icon-btn" style="color:var(--color-danger);" title="Remove row">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1rem;height:1rem;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                    <template x-if="rows.length === 0">
                        <tr>
                            <td colspan="5">
                                <div class="crm-empty" style="padding:2rem;">
                                    <p class="crm-empty-text">No items yet — select a request above or click a service in the catalogue →</p>
                                </div>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>

            {{-- Totals --}}
            <div class="crm-card-footer" style="display:flex;justify-content:flex-end;">
                <div style="min-width:240px;">
                    <div class="crm-detail-row">
                        <span class="crm-detail-label">Subtotal</span>
                        <span class="crm-detail-value" x-text="currencySymbol + ' ' + subtotal().toFixed(2)"></span>
                    </div>
                    <div class="crm-detail-row" style="font-size:1rem;font-weight:700;border-top:1px solid var(--color-border);padding-top:0.5rem;margin-top:0.25rem;">
                        <span class="crm-detail-label" style="color:var(--color-ink-1);font-weight:700;">Grand Total</span>
                        <span class="crm-detail-value" style="font-size:1.125rem;" x-text="currencySymbol + ' ' + subtotal().toFixed(2)"></span>
                    </div>
                </div>
            </div>
        </div>

    </div>{{-- /LEFT --}}

    {{-- ════ RIGHT SIDEBAR ════ --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:72px;">

        {{-- CTA --}}
        <div class="crm-card" style="overflow:hidden;">
            <div style="padding:1rem;display:flex;flex-direction:column;gap:0.5rem;">
                <button type="button"
                    @click="sendImmediately = true; $nextTick(() => document.getElementById('quote-form').requestSubmit())"
                    class="crm-btn crm-btn-primary crm-btn-lg" style="width:100%;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1rem;height:1rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Save &amp; Send to Client
                </button>
                <button type="button"
                    @click="sendImmediately = false; $nextTick(() => document.getElementById('quote-form').requestSubmit())"
                    class="crm-btn crm-btn-secondary" style="width:100%;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1rem;height:1rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                    Save as Draft
                </button>
                <a href="{{ route('crm.quotes.index') }}" class="crm-btn crm-btn-ghost" style="width:100%;justify-content:center;">Cancel</a>
            </div>
            <div x-show="sendImmediately" x-cloak
                style="background:#ecfdf3;border-top:1px solid #a7f3d0;padding:0.625rem 1rem;font-size:0.75rem;color:#027a48;display:flex;align-items:flex-start;gap:0.5rem;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                PDF quote will be emailed. Status → <strong>Sent</strong>.
            </div>
        </div>

        {{-- Linked request summary --}}
        <div x-show="selectedRequest" x-cloak class="crm-card" style="border:1.5px solid #2e90fa;overflow:hidden;">
            <div class="crm-card-header" style="background:#eff8ff;border-bottom:1px solid #bae6fd;">
                <span class="crm-card-title" style="color:#0369a1;font-size:0.875rem;">Linked Request</span>
                <span style="font-size:0.6875rem;background:#bae6fd;color:#0369a1;padding:2px 7px;border-radius:99px;font-weight:600;"
                    x-text="selectedRequest?.request_id"></span>
            </div>
            <div style="padding:0.875rem 1rem;font-size:0.8125rem;">
                <p style="font-weight:600;color:var(--color-ink-1);margin-bottom:4px;" x-text="selectedRequest?.title"></p>
                <template x-if="selectedRequest?.service">
                    <p style="color:#0284c7;margin-bottom:4px;">
                        🏷 <span x-text="selectedRequest.service.name"></span>
                        — <strong x-text="currencySymbol + ' ' + selectedRequest.service.unit_price.toFixed(2)"></strong>
                    </p>
                </template>
                <p style="font-size:0.75rem;color:#0369a1;background:#e0f2fe;border-radius:4px;padding:4px 8px;margin-top:6px;">
                    ✅ Request → <strong>Quoted</strong> on save
                </p>
            </div>
        </div>

        {{-- Live summary --}}
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Quote Summary</span></div>
            <div style="padding:0.875rem 1rem;display:flex;flex-direction:column;gap:0.5rem;">
                <div style="display:flex;justify-content:space-between;font-size:0.8125rem;">
                    <span style="color:var(--color-ink-3);">Items</span>
                    <span style="font-weight:500;" x-text="rows.length"></span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:0.8125rem;">
                    <span style="color:var(--color-ink-3);">Title</span>
                    <span style="font-weight:500;color:var(--color-ink-1);max-width:160px;text-align:right;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"
                        x-text="jobTitle || '—'"></span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:0.8125rem;">
                    <span style="color:var(--color-ink-3);">Expires</span>
                    <span style="font-weight:500;">{{ now()->addDays(30)->format('d M Y') }}</span>
                </div>
                <div style="border-top:1px solid var(--color-border);margin-top:4px;padding-top:8px;display:flex;justify-content:space-between;align-items:baseline;">
                    <span style="font-size:0.8125rem;color:var(--color-ink-3);">Total</span>
                    <span style="font-size:1.25rem;font-weight:700;color:var(--color-ink-1);"
                        x-text="currencySymbol + ' ' + subtotal().toFixed(2)">R 0.00</span>
                </div>
            </div>
        </div>

        {{-- Services Catalogue --}}
        <div class="crm-card">
            <div class="crm-card-header">
                <span class="crm-card-title">Services Catalogue</span>
                <span style="font-size:0.6875rem;color:var(--color-ink-3);">Click to add row</span>
            </div>
            <div style="padding:0.625rem;">
                <input type="text" x-model="serviceSearch"
                    placeholder="Search services…"
                    class="crm-input" style="margin-bottom:0.5rem;font-size:0.8125rem;">
                <div style="display:flex;flex-direction:column;gap:2px;max-height:360px;overflow-y:auto;">
                    <template x-for="grp in filteredServiceGroups()" :key="grp.category">
                        <div>
                            <p x-show="grp.category"
                                style="font-size:0.625rem;font-weight:700;color:var(--color-ink-3);text-transform:uppercase;letter-spacing:0.07em;padding:6px 4px 2px;"
                                x-text="grp.category"></p>
                            <template x-for="svc in grp.items" :key="svc.service_id">
                                <button type="button" @click="addServiceRow(svc)"
                                    style="display:flex;align-items:center;justify-content:space-between;gap:0.5rem;padding:0.5rem 0.625rem;border-radius:var(--radius-sm);border:1px solid transparent;background:transparent;text-align:left;width:100%;cursor:pointer;transition:background 120ms,border 120ms;"
                                    onmouseover="this.style.background='var(--color-surface-2)';this.style.borderColor='var(--color-border)'"
                                    onmouseout="this.style.background='transparent';this.style.borderColor='transparent'">
                                    <div style="min-width:0;flex:1;">
                                        <p style="font-size:0.8125rem;font-weight:500;color:var(--color-ink-1);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"
                                            x-text="svc.name"></p>
                                        <p x-show="svc.unit_type" style="font-size:0.6875rem;color:var(--color-ink-3);"
                                            x-text="svc.unit_type"></p>
                                    </div>
                                    <div style="flex-shrink:0;text-align:right;">
                                        <p style="font-size:0.8125rem;font-weight:600;color:var(--color-ink-1);"
                                            x-text="currencySymbol + ' ' + svc.unit_price.toFixed(2)"></p>
                                        <div style="width:20px;height:20px;background:#eff8ff;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-left:auto;margin-top:2px;">
                                            <svg fill="none" viewBox="0 0 24 24" stroke="#2e90fa" style="width:11px;height:11px;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </div>
                                    </div>
                                </button>
                            </template>
                        </div>
                    </template>
                    <template x-if="filteredServiceGroups().length === 0">
                        <p style="font-size:0.8125rem;color:var(--color-ink-3);padding:0.5rem 0;">No services found.</p>
                    </template>
                </div>
            </div>
        </div>

    </div>{{-- /RIGHT --}}

</div>{{-- /grid --}}
</form>
</div>

@php
    $servicesForJs = $services->map(fn($s) => [
        'service_id'  => $s->service_id,
        'name'        => $s->name,
        'description' => $s->description,
        'category'    => $s->category ?? '',
        'unit_price'  => (float) $s->unit_price,
        'unit_type'   => $s->unit_type ?? '',
    ]);
    $requestsForJs = $selectedClientRequests->map(fn($r) => [
        'id'               => $r->id,
        'request_id'       => $r->request_id,
        'title'            => $r->title,
        'description'      => $r->description,
        'assessment_notes' => $r->assessment_notes,
        'priority'         => $r->priority,
        'service'          => $r->service ? [
            'service_id'  => $r->service->service_id,
            'name'        => $r->service->name,
            'unit_price'  => (float) $r->service->unit_price,
            'unit_type'   => $r->service->unit_type ?? '',
        ] : null,
    ]);
    $rowsForJs = count(old('items', [])) > 0
        ? collect(old('items'))->map(fn($i) => [
            'description' => $i['description'] ?? '',
            'quantity'    => $i['quantity'] ?? 1,
            'unit_price'  => $i['unit_price'] ?? 0,
            'line_total'  => ($i['quantity'] ?? 1) * ($i['unit_price'] ?? 0),
        ])->toArray()
        : [];
@endphp
@push('scripts')
<script>
function quoteForm() {
    // All services from server — used for the dropdown inside each row
    const ALL_SERVICES = @json($servicesForJs);

    // Build grouped structure once
    function buildGroups(services, filter) {
        const q = (filter || '').toLowerCase();
        const list = q
            ? services.filter(s => s.name.toLowerCase().includes(q) || s.category.toLowerCase().includes(q))
            : services;
        const map = {};
        list.forEach(s => { (map[s.category] = map[s.category] || []).push(s); });
        return Object.entries(map).map(([category, items]) => ({ category, items }));
    }

    function makeRow(svc) {
        return {
            description: svc.name + (svc.unit_type ? ' (' + svc.unit_type + ')' : ''),
            quantity:    1,
            unit_price:  svc.unit_price,
            line_total:  svc.unit_price,
        };
    }

    function blankRow() {
        return { description: '', quantity: 1, unit_price: 0, line_total: 0 };
    }

    return {
        // ── Client / Request state ──
        clientId: @json(old('client_id', $selectedClient?->client_id ?? '')),
        requests: @json($requestsForJs),
        loadingRequests: false,
        selectedRequest: null,

        // ── Services ──
        serviceSearch: '',
        get serviceGroups() { return buildGroups(ALL_SERVICES, ''); },
        filteredServiceGroups() { return buildGroups(ALL_SERVICES, this.serviceSearch); },

        // ── Form fields ──
        jobTitle:      @json(old('job_title', '')),
        clientNotes:   @json(old('client_notes', '')),
        internalNotes: @json(old('internal_notes', '')),
        status:        @json(old('status', 'Draft')),
        currency:      @json(old('currency', 'ZAR')),
        get currencySymbol() {
            return { ZAR: 'R', USD: '$', EUR: '€', GBP: '£' }[this.currency] || 'R';
        },
        sendImmediately: false,

        // ── Line item rows ──
        rows: @json($rowsForJs),

        // ── Init ──
        init() {
            // If only one request pre-loaded, auto-select it immediately (no timing issue
            // because rows live right here in the same component)
            if (this.requests.length === 1) {
                this.selectRequest(this.requests[0]);
            }
        },

        // ── Client changed → AJAX ──
        async onClientChange() {
            this.requests        = [];
            this.selectedRequest = null;
            this.rows            = [];
            this.jobTitle = this.clientNotes = this.internalNotes = '';
            if (!this.clientId) return;

            this.loadingRequests = true;
            try {
                const res = await fetch(
                    `{{ route('crm.quotes.ajax.requests') }}?client_id=${encodeURIComponent(this.clientId)}`,
                    { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } }
                );
                this.requests = await res.json();
                if (this.requests.length === 1) this.selectRequest(this.requests[0]);
            } catch(e) { console.error(e); }
            this.loadingRequests = false;
        },

        // ── Select request → auto-fill everything ──
        selectRequest(req) {
            this.selectedRequest = req;
            if (req.title)            this.jobTitle      = req.title;
            if (req.description)      this.clientNotes   = req.description;
            if (req.assessment_notes) this.internalNotes = req.assessment_notes;

            // Pre-populate line items with the request's linked service
            if (req.service) {
                const svc = ALL_SERVICES.find(s => s.service_id === req.service.service_id) || req.service;
                this.rows = [ makeRow(svc) ];
            }
        },

        clearRequest() {
            this.selectedRequest = null;
            this.rows            = [];
        },

        // ── Row helpers ──
        addServiceRow(svc) {
            this.rows.push(makeRow(svc));
        },

        addBlankRow() {
            this.rows.push(blankRow());
        },

        calcRow(row) {
            row.line_total = row.quantity * row.unit_price;
        },

        subtotal() {
            return this.rows.reduce((s, r) => s + r.line_total, 0);
        },
    };
}
</script>
<style>
@keyframes crm-spin { to { transform: rotate(360deg); } }
[x-cloak] { display: none !important; }
</style>
@endpush

</x-crm::layout>

