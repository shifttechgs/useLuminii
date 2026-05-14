<x-crm::layout title="New Invoice">

<div class="crm-page-header">
    <div>
        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.25rem;">
            <a href="{{ route('crm.invoices.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Invoices</a>
            <span style="color:var(--color-ink-3);">/</span>
            <span style="font-size:0.875rem;color:var(--color-ink-2);">New Invoice</span>
        </div>
        <h1 class="crm-page-title">New Invoice</h1>
        <p class="crm-page-subtitle">Select a client and optionally link a completed job, or build a standalone invoice from the services catalogue.</p>
    </div>
</div>

<div x-data="invoiceForm()" x-init="init()">
<form id="invoice-form" method="POST" action="{{ route('crm.invoices.store') }}">
@csrf

<input type="hidden" name="send_immediately" :value="sendImmediately ? '1' : '0'">
<input type="hidden" name="job_id"           :value="jobId">
<input type="hidden" name="invoice_type"     :value="invoiceType">

<div style="display:grid;grid-template-columns:1fr 320px;gap:1.25rem;align-items:start;">

    {{-- ════ LEFT ════ --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        {{-- ── STEP 1: Client & Job ── --}}
        <div class="crm-card">
            <div class="crm-card-header">
                <span class="crm-card-title">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:1.375rem;height:1.375rem;background:var(--color-ink-1);color:#fff;border-radius:50%;font-size:0.625rem;font-weight:700;margin-right:0.5rem;">1</span>
                    Client &amp; Job
                </span>
                <span x-show="selectedJob" x-cloak
                    style="font-size:0.75rem;background:#ecfdf3;color:#027a48;padding:2px 10px;border-radius:99px;font-weight:600;"
                    x-text="'Linked: ' + (selectedJob?.job_id ?? '')"></span>
            </div>
            <div class="crm-card-body" style="display:flex;flex-direction:column;gap:1rem;">

                <div>
                    <label class="crm-label">Client <span style="color:var(--color-danger);">*</span></label>
                    <select name="client_id" class="crm-select" x-model="clientId" @change="onClientChange()" required>
                        <option value="">— Select a client —</option>
                        @foreach($clients as $c)
                        <option value="{{ $c->client_id }}">
                            {{ $c->company ? $c->company.' — ' : '' }}{{ $c->full_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Invoice Type --}}
                <div>
                    <label class="crm-label">Invoice Type</label>
                    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-top:0.25rem;">
                        @foreach(['project'=>'Project / Job','hosting'=>'Hosting','consultation'=>'Consultation','domain'=>'Domain','maintenance'=>'Maintenance','other'=>'Other'] as $val=>$label)
                        <button type="button" @click="invoiceType = '{{ $val }}'"
                            :style="invoiceType === '{{ $val }}'
                                ? 'background:var(--color-ink-1);color:#fff;border-color:var(--color-ink-1);'
                                : 'background:var(--color-surface);color:var(--color-ink-2);border-color:var(--color-border);'"
                            style="padding:0.3rem 0.875rem;border-radius:99px;font-size:0.8rem;font-weight:500;border:1.5px solid;cursor:pointer;transition:all 150ms;">
                            {{ $label }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Job picker — only for project type --}}
                <div x-show="clientId && invoiceType === 'project'" x-cloak>
                    <label class="crm-label">
                        Linked Job
                        <span style="font-size:0.75rem;color:var(--color-ink-3);font-weight:400;margin-left:4px;">(optional — auto-fills line items &amp; deposit)</span>
                    </label>

                    <template x-if="clientJobs.length === 0">
                        <div style="background:#fffaeb;border:1px solid #fde68a;border-radius:var(--radius-sm);padding:0.625rem 0.875rem;font-size:0.8125rem;color:#92400e;">
                            No jobs found for this client — build line items manually using the services catalogue →
                        </div>
                    </template>

                    <template x-if="clientJobs.length > 0">
                        <div style="display:flex;flex-direction:column;gap:0.375rem;margin-top:0.25rem;">
                            <template x-for="job in clientJobs" :key="job.job_id">
                                <button type="button" @click="selectJob(job)"
                                    :style="selectedJob?.job_id === job.job_id
                                        ? 'border:2px solid #2e90fa;background:#eff8ff;'
                                        : 'border:1px solid var(--color-border);background:var(--color-surface);'"
                                    style="display:flex;align-items:flex-start;gap:0.75rem;padding:0.75rem 1rem;border-radius:var(--radius-sm);text-align:left;width:100%;cursor:pointer;transition:all 150ms;">
                                    <div style="margin-top:3px;flex-shrink:0;">
                                        <div style="width:14px;height:14px;border-radius:50%;display:flex;align-items:center;justify-content:center;"
                                            :style="selectedJob?.job_id === job.job_id ? 'background:#2e90fa;' : 'background:#d1d5db;'">
                                            <svg x-show="selectedJob?.job_id === job.job_id" fill="white" viewBox="0 0 20 20" style="width:9px;height:9px;"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        </div>
                                    </div>
                                    <div style="flex:1;min-width:0;">
                                        <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;margin-bottom:2px;">
                                            <span style="font-size:0.875rem;font-weight:600;color:var(--color-ink-1);" x-text="job.job_title"></span>
                                            <span style="font-size:0.6875rem;font-family:monospace;color:var(--color-ink-3);" x-text="job.job_id"></span>
                                            <span :style="job.job_status==='Completed'?'background:#ecfdf3;color:#027a48':job.job_status==='InProgress'?'background:#fffaeb;color:#b54708':'background:#f1f3f7;color:#5a6a7e'"
                                                style="font-size:0.6875rem;font-weight:600;padding:1px 6px;border-radius:99px;" x-text="job.job_status"></span>
                                            <template x-if="job.items.length > 0">
                                                <span style="font-size:0.6875rem;background:#eff8ff;color:#2e90fa;padding:1px 7px;border-radius:99px;font-weight:500;"
                                                    x-text="job.items.length + ' item' + (job.items.length !== 1 ? 's' : '')"></span>
                                            </template>
                                        </div>
                                        <p x-show="job.deposit > 0" style="font-size:0.8125rem;color:#027a48;margin:0;" x-text="'Deposit paid: ' + currencySymbol + ' ' + job.deposit.toFixed(2)"></p>
                                    </div>
                                </button>
                            </template>
                            <button type="button" @click="clearJob()"
                                :style="!selectedJob ? 'border:1.5px dashed #2e90fa;background:#f0f7ff;color:#1d4ed8;' : 'border:1.5px dashed var(--color-border);color:var(--color-ink-3);'"
                                style="padding:0.5rem 1rem;border-radius:var(--radius-sm);font-size:0.8125rem;cursor:pointer;background:transparent;text-align:left;width:100%;transition:all 150ms;">
                                <span x-text="!selectedJob ? '✎ Build invoice manually (no linked job)' : '✕ Clear — build manually'"></span>
                            </button>
                        </div>
                    </template>
                </div>

            </div>
        </div>

        {{-- ── STEP 2: Invoice Details ── --}}
        <div class="crm-card">
            <div class="crm-card-header">
                <span class="crm-card-title">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:1.375rem;height:1.375rem;background:var(--color-ink-1);color:#fff;border-radius:50%;font-size:0.625rem;font-weight:700;margin-right:0.5rem;">2</span>
                    Invoice Details
                </span>
                <span x-show="selectedJob" x-cloak
                    style="font-size:0.75rem;background:#ecfdf3;color:#027a48;padding:2px 8px;border-radius:99px;font-weight:600;">✓ Auto-filled</span>
            </div>
            <div class="crm-card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div>
                    <label class="crm-label">Invoice Date <span style="color:var(--color-danger);">*</span></label>
                    <input type="date" name="invoice_date" value="{{ now()->format('Y-m-d') }}" class="crm-input" required>
                </div>
                <div>
                    <label class="crm-label">Due Date <span style="color:var(--color-danger);">*</span></label>
                    <input type="date" name="due_date" value="{{ now()->addDays(14)->format('Y-m-d') }}" class="crm-input" required>
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
                    <label class="crm-label">Deposit Already Paid</label>
                    <input type="number" name="deposit_paid" class="crm-input" min="0" step="0.01"
                        :value="depositPaid" @input="depositPaid = parseFloat($event.target.value) || 0">
                </div>
                <div>
                    <label class="crm-label">Discount</label>
                    <input type="number" name="discount" class="crm-input" min="0" step="0.01"
                        :value="discount" @input="discount = parseFloat($event.target.value) || 0">
                </div>
                <div>
                    <label class="crm-label">Payment Method</label>
                    <select name="payment_method" class="crm-select">
                        @foreach(['EFT','Cash','Card','PayPal','Other'] as $m)
                        <option value="{{ $m }}">{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="crm-label">Status</label>
                    <select name="status" class="crm-select">
                        @foreach(['Draft','Sent','PartiallyPaid','Paid'] as $s)
                        <option value="{{ $s }}" {{ $s === 'Draft' ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                    <p x-show="sendImmediately" x-cloak style="font-size:0.75rem;color:#0369a1;margin-top:4px;">Status will be set to <strong>Sent</strong> automatically.</p>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Message to Client <span class="crm-label-hint">(shown in email)</span></label>
                    <textarea name="client_message" class="crm-textarea" rows="3"
                        placeholder="Thank you for your business. Please find your invoice attached…"></textarea>
                </div>
                <div style="grid-column:1/-1;">
                    <label class="crm-label">Internal Notes <span class="crm-label-hint">(not sent to client)</span></label>
                    <textarea name="internal_notes" class="crm-textarea" rows="2"></textarea>
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

            <div x-show="selectedJob && rows.length > 0" x-cloak
                style="background:#f0f9ff;border-bottom:1px solid #bae6fd;padding:0.5rem 1rem;font-size:0.8125rem;color:#0369a1;display:flex;align-items:center;gap:0.5rem;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Items imported from job. Adjust quantities or prices as needed.
            </div>

            <div style="overflow-x:auto;">
                <table class="crm-table" style="min-width:600px;">
                    <thead>
                        <tr>
                            <th style="width:45%;">Service / Description</th>
                            <th style="width:12%;">Qty</th>
                            <th style="width:18%;" x-text="'Unit Price (' + currencySymbol + ')'">Unit Price</th>
                            <th style="width:13%;">Total</th>
                            <th style="width:12%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <template x-for="(row, idx) in rows" :key="idx">
                        <tr>
                            <td style="min-width:200px;">
                                <select class="crm-select" style="margin-bottom:4px;"
                                    x-model="row.service_id"
                                    @change="onRowServiceChange(row)">
                                    <option value="">— Select a service —</option>
                                    <template x-for="grp in serviceGroups" :key="grp.category">
                                        <optgroup :label="grp.category || 'Services'">
                                            <template x-for="svc in grp.items" :key="svc.service_id">
                                                <option :value="svc.service_id" x-text="svc.name + ' — ' + currencySymbol + ' ' + svc.unit_price.toFixed(2)"></option>
                                            </template>
                                        </optgroup>
                                    </template>
                                    <option value="__custom__">✎ Custom description…</option>
                                </select>
                                <input x-show="row.service_id === '__custom__' || row.service_id === ''"
                                    type="text" class="crm-input" style="font-size:0.8125rem;"
                                    x-model="row.custom_description"
                                    placeholder="Enter description"
                                    x-cloak>
                                <input type="hidden"
                                    :name="`items[${idx}][description]`"
                                    :value="(row.service_id && row.service_id !== '__custom__') ? row.description : row.custom_description">
                            </td>
                            <td>
                                <input type="number" class="crm-input"
                                    :name="`items[${idx}][quantity]`"
                                    x-model.number="row.quantity"
                                    @input="calcRow(row)"
                                    min="0" step="0.01" required>
                            </td>
                            <td>
                                <input type="number" class="crm-input"
                                    :name="`items[${idx}][unit_price]`"
                                    x-model.number="row.unit_price"
                                    @input="calcRow(row)"
                                    min="0" step="0.01" required>
                            </td>
                            <td style="font-weight:600;font-size:0.875rem;white-space:nowrap;"
                                x-text="currencySymbol + ' ' + row.line_total.toFixed(2)"></td>
                            <td>
                                <button type="button" @click="rows.splice(idx, 1)"
                                    class="crm-icon-btn" style="color:var(--color-danger);" title="Remove">
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
                                    <p class="crm-empty-text">No items yet — link a job above or click a service in the catalogue →</p>
                                </div>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>

            {{-- Totals --}}
            <div class="crm-card-footer" style="display:flex;justify-content:flex-end;">
                <div style="min-width:260px;display:flex;flex-direction:column;gap:0.375rem;">
                    <div class="crm-detail-row">
                        <span class="crm-detail-label">Subtotal</span>
                        <span class="crm-detail-value" x-text="currencySymbol + ' ' + subtotal().toFixed(2)"></span>
                    </div>
                    <div class="crm-detail-row" x-show="discount > 0">
                        <span class="crm-detail-label">Discount</span>
                        <span class="crm-detail-value" style="color:#dc2626;" x-text="'− ' + currencySymbol + ' ' + discount.toFixed(2)"></span>
                    </div>
                    <div class="crm-detail-row" x-show="depositPaid > 0">
                        <span class="crm-detail-label">Deposit Paid</span>
                        <span class="crm-detail-value" style="color:#16a34a;" x-text="'− ' + currencySymbol + ' ' + depositPaid.toFixed(2)"></span>
                    </div>
                    <div class="crm-detail-row" style="font-size:1rem;font-weight:700;border-top:2px solid var(--color-border);padding-top:0.5rem;margin-top:0.25rem;">
                        <span class="crm-detail-label" style="color:var(--color-ink-1);font-weight:700;">Balance Due</span>
                        <span class="crm-detail-value" style="font-size:1.25rem;"
                            :style="balance() <= 0 ? 'color:#16a34a;' : 'color:#dc2626;'"
                            x-text="currencySymbol + ' ' + balance().toFixed(2)"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── STEP 4: Recurring Schedule ── --}}
        <div class="crm-card" x-data="{ recurring: false }">
            <div class="crm-card-header" style="cursor:pointer;" @click="recurring = !recurring">
                <span class="crm-card-title">
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:1.375rem;height:1.375rem;background:var(--color-ink-1);color:#fff;border-radius:50%;font-size:0.625rem;font-weight:700;margin-right:0.5rem;">4</span>
                    Recurring Schedule
                    <span style="font-size:0.75rem;font-weight:400;color:var(--color-ink-3);margin-left:0.5rem;">(optional)</span>
                </span>
                <div style="display:flex;align-items:center;gap:0.75rem;">
                    <span x-show="recurring" x-cloak
                        style="font-size:0.75rem;background:#ecfdf3;color:#027a48;padding:2px 10px;border-radius:99px;font-weight:600;">Active</span>
                    <svg x-show="!recurring" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1.1rem;height:1.1rem;color:var(--color-ink-3);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    <svg x-show="recurring" x-cloak fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1.1rem;height:1.1rem;color:var(--color-ink-3);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                </div>
            </div>

            {{-- Toggle row --}}
            <div class="crm-card-body" style="border-top:1px solid var(--color-border);">
                <label style="display:flex;align-items:center;gap:0.75rem;cursor:pointer;">
                    <div style="position:relative;width:42px;height:24px;flex-shrink:0;">
                        <input type="checkbox" x-model="recurring" name="is_recurring" value="1"
                            style="position:absolute;opacity:0;width:0;height:0;">
                        <div :style="recurring ? 'background:#1a3a2a;' : 'background:#d1d5db;'"
                            style="width:42px;height:24px;border-radius:12px;transition:background 200ms;"></div>
                        <div :style="recurring ? 'transform:translateX(18px);' : 'transform:translateX(2px);'"
                            style="position:absolute;top:2px;width:20px;height:20px;background:#fff;border-radius:50%;transition:transform 200ms;box-shadow:0 1px 3px rgba(0,0,0,0.2);"></div>
                    </div>
                    <div>
                        <p style="font-size:0.875rem;font-weight:600;color:var(--color-ink-1);margin:0;">Make this invoice recurring</p>
                        <p style="font-size:0.75rem;color:var(--color-ink-3);margin:2px 0 0;">A schedule will be created — new invoices auto-generated and emailed on your chosen frequency.</p>
                    </div>
                </label>

                {{-- Expanded fields --}}
                <div x-show="recurring" x-cloak style="margin-top:1.25rem;display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;">
                    <div>
                        <label class="crm-label">Frequency <span style="color:var(--color-danger);">*</span></label>
                        <select name="recur_frequency" class="crm-select">
                            @foreach(['Monthly'=>'Monthly','Weekly'=>'Weekly','Quarterly'=>'Quarterly','Annually'=>'Annually'] as $v=>$l)
                            <option value="{{ $v }}">{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="crm-label">Start Date <span style="color:var(--color-danger);">*</span></label>
                        <input type="date" name="recur_start_date" class="crm-input" value="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="crm-label">End Date <span class="crm-label-hint">(leave blank = ongoing)</span></label>
                        <input type="date" name="recur_end_date" class="crm-input">
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
                    @click="sendImmediately = true; $nextTick(() => document.getElementById('invoice-form').requestSubmit())"
                    class="crm-btn crm-btn-primary crm-btn-lg" style="width:100%;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1rem;height:1rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Save &amp; Send to Client
                </button>
                <button type="button"
                    @click="sendImmediately = false; $nextTick(() => document.getElementById('invoice-form').requestSubmit())"
                    class="crm-btn crm-btn-secondary" style="width:100%;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1rem;height:1rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                    Save as Draft
                </button>
                <a href="{{ route('crm.invoices.index') }}" class="crm-btn crm-btn-ghost" style="width:100%;justify-content:center;">Cancel</a>
            </div>
            <div x-show="sendImmediately" x-cloak
                style="background:#ecfdf3;border-top:1px solid #a7f3d0;padding:0.625rem 1rem;font-size:0.75rem;color:#027a48;display:flex;align-items:flex-start;gap:0.5rem;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                PDF invoice will be emailed. Status → <strong>Sent</strong>.
            </div>
        </div>

        {{-- Linked job summary --}}
        <div x-show="selectedJob" x-cloak class="crm-card" style="border:1.5px solid #2e90fa;overflow:hidden;">
            <div class="crm-card-header" style="background:#eff8ff;border-bottom:1px solid #bae6fd;">
                <span class="crm-card-title" style="color:#0369a1;font-size:0.875rem;">Linked Job</span>
                <span style="font-size:0.6875rem;background:#bae6fd;color:#0369a1;padding:2px 7px;border-radius:99px;font-weight:600;"
                    x-text="selectedJob?.job_id"></span>
            </div>
            <div style="padding:0.875rem 1rem;font-size:0.8125rem;display:flex;flex-direction:column;gap:0.375rem;">
                <p style="font-weight:600;color:var(--color-ink-1);margin:0;" x-text="selectedJob?.job_title"></p>
                <template x-if="selectedJob?.deposit > 0">
                    <p style="color:#027a48;margin:0;">
                        ✅ Deposit: <strong x-text="currencySymbol + ' ' + selectedJob?.deposit.toFixed(2)"></strong> applied
                    </p>
                </template>
                <template x-if="selectedJob?.items?.length > 0">
                    <p style="font-size:0.75rem;color:#0369a1;background:#e0f2fe;border-radius:4px;padding:4px 8px;margin-top:4px;">
                        <span x-text="selectedJob.items.length"></span> items imported from job
                    </p>
                </template>
            </div>
        </div>

        {{-- Live Summary --}}
        <div class="crm-card">
            <div class="crm-card-header"><span class="crm-card-title">Invoice Summary</span></div>
            <div style="padding:0.875rem 1rem;display:flex;flex-direction:column;gap:0.5rem;">
                <div style="display:flex;justify-content:space-between;font-size:0.8125rem;">
                    <span style="color:var(--color-ink-3);">Line items</span>
                    <span style="font-weight:500;" x-text="rows.length"></span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:0.8125rem;">
                    <span style="color:var(--color-ink-3);">Subtotal</span>
                    <span style="font-weight:500;" x-text="currencySymbol + ' ' + subtotal().toFixed(2)"></span>
                </div>
                <div x-show="discount > 0" style="display:flex;justify-content:space-between;font-size:0.8125rem;">
                    <span style="color:var(--color-ink-3);">Discount</span>
                    <span style="font-weight:500;color:#dc2626;" x-text="'− ' + currencySymbol + ' ' + discount.toFixed(2)"></span>
                </div>
                <div x-show="depositPaid > 0" style="display:flex;justify-content:space-between;font-size:0.8125rem;">
                    <span style="color:var(--color-ink-3);">Deposit</span>
                    <span style="font-weight:500;color:#16a34a;" x-text="'− ' + currencySymbol + ' ' + depositPaid.toFixed(2)"></span>
                </div>
                <div style="border-top:1px solid var(--color-border);margin-top:4px;padding-top:8px;display:flex;justify-content:space-between;align-items:baseline;">
                    <span style="font-size:0.8125rem;color:var(--color-ink-3);">Balance Due</span>
                    <span style="font-size:1.25rem;font-weight:700;"
                        :style="balance() <= 0 ? 'color:#16a34a;' : 'color:var(--color-ink-1);'"
                        x-text="currencySymbol + ' ' + balance().toFixed(2)">R 0.00</span>
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
    $allServices = $services->map(fn($s) => [
        'service_id' => $s->service_id,
        'name'       => $s->name,
        'category'   => $s->category ?? '',
        'unit_price' => (float) $s->unit_price,
        'unit_type'  => $s->unit_type ?? '',
    ])->values();

    $allJobs = $jobs->map(fn($j) => [
        'job_id'     => $j->job_id,
        'client_id'  => $j->client_id,
        'job_title'  => $j->job_title,
        'job_status' => $j->job_status,
        'deposit'    => (float) ($j->quote && $j->quote->deposit_received ? $j->quote->required_deposit : 0),
        'items'      => $j->items->map(fn($i) => [
            'service_id'  => $i->service_id ?? '',
            'description' => $i->description,
            'quantity'    => (float) $i->quantity,
            'unit_price'  => (float) $i->unit_price,
            'line_total'  => (float) $i->line_total,
        ])->values()->toArray(),
    ])->values();
@endphp
@push('scripts')
<script>
function invoiceForm() {
    const ALL_SERVICES = @json($allServices);
    const ALL_JOBS = @json($allJobs);

    function buildGroups(services, filter) {
        const q = (filter || '').toLowerCase();
        const list = q ? services.filter(s => s.name.toLowerCase().includes(q) || s.category.toLowerCase().includes(q)) : services;
        const map = {};
        list.forEach(s => { (map[s.category] = map[s.category] || []).push(s); });
        return Object.entries(map).map(([category, items]) => ({ category, items }));
    }

    function makeRow(svc) {
        return {
            service_id:         svc.service_id,
            description:        svc.name,
            custom_description: '',
            quantity:           1,
            unit_price:         svc.unit_price,
            line_total:         svc.unit_price,
        };
    }

    function blankRow() {
        return { service_id: '__custom__', description: '', custom_description: '', quantity: 1, unit_price: 0, line_total: 0 };
    }

    return {
        clientId:        @json($prefilledClientId ?? ''),
        jobId:           @json($prefilledJobId ?? ''),
        invoiceType:     'project',
        selectedJob:     null,
        discount:        0,
        depositPaid:     0,
        sendImmediately: false,
        serviceSearch:   '',
        rows:            [],
        currency:        @json(old('currency', 'ZAR')),
        get currencySymbol() {
            return { ZAR: 'R', USD: '$', EUR: '€', GBP: '£' }[this.currency] || 'R';
        },

        get clientJobs() {
            return this.clientId ? ALL_JOBS.filter(j => j.client_id === this.clientId) : [];
        },
        get serviceGroups()        { return buildGroups(ALL_SERVICES, ''); },
        filteredServiceGroups()    { return buildGroups(ALL_SERVICES, this.serviceSearch); },

        init() {
            if (this.jobId) {
                const job = ALL_JOBS.find(j => j.job_id === this.jobId);
                if (job) this.selectJob(job);
            }
        },

        onClientChange() {
            this.jobId       = '';
            this.selectedJob = null;
            this.rows        = [];
            this.depositPaid = 0;
        },

        selectJob(job) {
            this.selectedJob = job;
            this.jobId       = job.job_id;
            this.depositPaid = job.deposit;
            this.rows = job.items.map(i => ({
                service_id:         i.service_id || '',
                description:        i.description,
                custom_description: i.description,
                quantity:           i.quantity,
                unit_price:         i.unit_price,
                line_total:         i.line_total,
            }));
            if (this.rows.length === 0) this.rows.push(blankRow());
        },

        clearJob() {
            this.selectedJob = null;
            this.jobId       = '';
            this.depositPaid = 0;
            this.rows        = [];
        },

        onRowServiceChange(row) {
            if (row.service_id === '__custom__' || !row.service_id) {
                row.description = '';
                row.unit_price  = 0;
                row.line_total  = 0;
                return;
            }
            const svc = ALL_SERVICES.find(s => s.service_id === row.service_id);
            if (svc) {
                row.description = svc.name;
                row.unit_price  = svc.unit_price;
                row.line_total  = row.quantity * svc.unit_price;
            }
        },

        addServiceRow(svc) { this.rows.push(makeRow(svc)); },
        addBlankRow()      { this.rows.push(blankRow()); },

        calcRow(row) { row.line_total = row.quantity * row.unit_price; },

        subtotal() { return this.rows.reduce((s, r) => s + r.line_total, 0); },
        total()    { return Math.max(0, this.subtotal() - this.discount); },
        balance()  { return Math.max(0, this.total() - this.depositPaid); },
    };
}
</script>
<style>
[x-cloak] { display: none !important; }
</style>
@endpush

</x-crm::layout>
