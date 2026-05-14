<x-crm::layout title="Invoices">

<div class="crm-page-header">
    <div>
        <h1 class="crm-page-title">Invoices</h1>
        <p class="crm-page-subtitle">Billing, payments and outstanding balances</p>
    </div>
    <a href="{{ route('crm.invoices.create') }}" class="crm-btn crm-btn-primary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Invoice
    </a>
</div>

{{-- ── Stats bar ── --}}
<div style="display:grid;grid-template-columns:repeat(6,1fr);gap:1rem;margin-bottom:1.5rem;">
    <div class="crm-stat">
        <span class="crm-stat-label">Total</span>
        <span class="crm-stat-value">{{ $stats['total'] }}</span>
    </div>
    <div class="crm-stat">
        <span class="crm-stat-label">Draft</span>
        <span class="crm-stat-value" style="color:var(--color-ink-2);">{{ $stats['draft'] }}</span>
    </div>
    <div class="crm-stat">
        <span class="crm-stat-label">Awaiting</span>
        <span class="crm-stat-value" style="color:#0369a1;">{{ $stats['sent'] }}</span>
    </div>
    <div class="crm-stat {{ $stats['overdue'] > 0 ? 'style="border-color:#fecdca;"' : '' }}">
        <span class="crm-stat-label" style="{{ $stats['overdue'] > 0 ? 'color:var(--color-danger-text);' : '' }}">Overdue</span>
        <span class="crm-stat-value" style="{{ $stats['overdue'] > 0 ? 'color:var(--color-danger-text);' : '' }}">{{ $stats['overdue'] }}</span>
    </div>
    <div class="crm-stat">
        <span class="crm-stat-label">Revenue</span>
        <span class="crm-stat-value" style="font-size:1rem;color:var(--color-success-text);">R&nbsp;{{ number_format($stats['revenue'], 0) }}</span>
    </div>
    <div class="crm-stat">
        <span class="crm-stat-label">Outstanding</span>
        <span class="crm-stat-value" style="font-size:1rem;{{ $stats['outstanding'] > 0 ? 'color:var(--color-warning-text);' : '' }}">R&nbsp;{{ number_format($stats['outstanding'], 0) }}</span>
    </div>
</div>

<div class="crm-table-wrap" style="overflow:visible;">
    {{-- Toolbar --}}
    <div class="crm-table-toolbar">
        <form method="GET" action="{{ route('crm.invoices.index') }}" style="display:contents;">
            <div class="crm-search">
                <svg class="crm-search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by invoice #, client…">
            </div>
            <select name="status" class="crm-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                @foreach(['Draft','Sent','PartiallyPaid','Paid','Overdue','Cancelled'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
            <select name="type" class="crm-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Types</option>
                @foreach(['project'=>'Project','hosting'=>'Hosting','consultation'=>'Consultation','domain'=>'Domain','maintenance'=>'Maintenance','recurring'=>'Recurring','other'=>'Other'] as $val=>$label)
                    <option value="{{ $val }}" {{ request('type') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button type="submit" class="crm-btn crm-btn-secondary crm-btn-sm">Search</button>
            @if(request('q') || request('status') || request('type'))
                <a href="{{ route('crm.invoices.index') }}" class="crm-btn crm-btn-ghost crm-btn-sm">Clear</a>
            @endif
        </form>
        <span style="margin-left:auto;font-size:0.8125rem;color:var(--color-ink-3);">{{ $invoices->total() }} records</span>
    </div>

    {{-- Table --}}
    <table class="crm-table">
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Client</th>
                <th>Type</th>
                <th style="text-align:right;">Total</th>
                <th style="text-align:right;">Balance Due</th>
                <th>Status</th>
                <th>Due Date</th>
                <th>Next Action</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($invoices as $inv)
            @php
                $isOverdue  = $inv->due_date && $inv->due_date->isPast() && !in_array($inv->status, ['Paid','Cancelled']);
                $daysPast   = $inv->due_date ? now()->diffInDays($inv->due_date, false) : 0;
                $daysSince  = $inv->updated_at->diffInDays();

                // Next Action
                [$naLabel, $naColor] = match(true) {
                    $inv->status === 'Paid'                             => ['✅ Done',              'success'],
                    $inv->status === 'Cancelled'                        => ['— Cancelled',           'gray'],
                    $inv->status === 'Overdue'                          => ['🔴 Urgent: overdue',    'danger'],
                    $inv->status === 'PartiallyPaid'                    => ['💰 Record balance',     'warning'],
                    $inv->status === 'Draft'                            => ['📤 Send invoice',       'primary'],
                    $inv->status === 'Sent' && $daysSince > 5           => ['⏰ Chase payment',      'danger'],
                    $inv->status === 'Sent'                             => ['⏳ Awaiting payment',   'warning'],
                    default                                              => ['—',                    'gray'],
                };

                // Type label + color [label, text, background]
                [$typeLabel, $typeText, $typeBg] = match($inv->invoice_type ?? 'project') {
                    'project'      => ['Project',      '#2e90fa', '#eff8ff'],
                    'hosting'      => ['Hosting',      '#0369a1', '#e0f2fe'],
                    'consultation' => ['Consultation', '#7c3aed', '#f5f3ff'],
                    'domain'       => ['Domain',       '#027a48', '#ecfdf3'],
                    'maintenance'  => ['Maintenance',  '#b54708', '#fffaeb'],
                    'recurring'    => ['Recurring',    '#5a6a7e', '#f1f3f7'],
                    default        => ['Other',        '#5a6a7e', '#f1f3f7'],
                };

                // Status badge colors
                $statusStyle = match($inv->status) {
                    'Draft'         => 'background:#f1f3f7;color:#5a6a7e;',
                    'Sent'          => 'background:#e0f2fe;color:#0369a1;',
                    'PartiallyPaid' => 'background:#fffaeb;color:#b54708;',
                    'Paid'          => 'background:#ecfdf3;color:#027a48;',
                    'Overdue'       => 'background:#fef3f2;color:#b42318;',
                    'Cancelled'     => 'background:#f1f3f7;color:#9ca3af;',
                    default         => 'background:#f1f3f7;color:#5a6a7e;',
                };

                $naStyle = match($naColor) {
                    'danger'  => 'background:#fef3f2;color:#b42318;',
                    'warning' => 'background:#fffaeb;color:#b54708;',
                    'primary' => 'background:#eff8ff;color:#0369a1;',
                    'success' => 'background:#ecfdf3;color:#027a48;',
                    default   => 'background:#f1f3f7;color:#5a6a7e;',
                };
            @endphp
            <tr onclick="window.location='{{ route('crm.invoices.show', $inv) }}'" style="cursor:pointer;">

                {{-- Invoice # --}}
                <td>
                    <span class="crm-mono" style="font-size:0.8rem;">{{ $inv->invoice_id }}</span>
                    @if($inv->job_id)
                        <br><span style="font-size:0.7rem;color:var(--color-ink-3);">{{ $inv->job_id }}</span>
                    @endif
                </td>

                {{-- Client --}}
                <td>
                    <span style="font-weight:600;color:var(--color-ink-1);">{{ $inv->client->full_name ?? '—' }}</span>
                    @if($inv->client?->company)
                        <br><span style="font-size:0.75rem;color:var(--color-ink-3);">{{ $inv->client->company }}</span>
                    @endif
                </td>

                {{-- Type --}}
                <td>
                    <span style="font-size:0.75rem;font-weight:600;padding:2px 8px;border-radius:99px;background:{{ $typeBg }};color:{{ $typeText }};">
                        {{ $typeLabel }}
                    </span>
                </td>

                {{-- Total --}}
                <td style="text-align:right;white-space:nowrap;">
                    <span style="font-weight:600;color:var(--color-ink-1);">R&nbsp;{{ number_format($inv->total_amount, 2) }}</span>
                    @if($inv->deposit_paid > 0)
                        <br><span style="font-size:0.72rem;color:var(--color-ink-3);">dep. R&nbsp;{{ number_format($inv->deposit_paid, 2) }}</span>
                    @endif
                </td>

                {{-- Balance --}}
                <td style="text-align:right;white-space:nowrap;">
                    @if($inv->balance <= 0)
                        <span style="font-weight:700;color:#027a48;">R&nbsp;0.00</span>
                    @else
                        <span style="font-weight:700;{{ $isOverdue ? 'color:#b42318;' : 'color:var(--color-warning-text);' }}">
                            R&nbsp;{{ number_format($inv->balance, 2) }}
                        </span>
                    @endif
                </td>

                {{-- Status --}}
                <td>
                    <span style="font-size:0.75rem;font-weight:600;padding:2px 8px;border-radius:99px;{{ $statusStyle }}">
                        {{ $inv->status === 'PartiallyPaid' ? 'Part. Paid' : $inv->status }}
                    </span>
                </td>

                {{-- Due Date --}}
                <td style="white-space:nowrap;font-size:0.875rem;{{ $isOverdue ? 'color:#b42318;font-weight:600;' : 'color:var(--color-ink-3);' }}">
                    @if($inv->due_date)
                        {{ $inv->due_date->format('d M Y') }}
                        @if($isOverdue)
                            <br><span style="font-size:0.7rem;">{{ abs((int)$daysPast) }}d overdue</span>
                        @endif
                    @else
                        —
                    @endif
                </td>

                {{-- Next Action --}}
                <td>
                    <span style="font-size:0.75rem;font-weight:600;padding:2px 8px;border-radius:99px;white-space:nowrap;{{ $naStyle }}">
                        {{ $naLabel }}
                    </span>
                </td>

                {{-- Actions --}}
                <td onclick="event.stopPropagation()" style="white-space:nowrap;">
                    <div x-data="{ open: false, sendOpen: false }" style="position:relative;display:inline-block;">
                        <button @click.stop="open = !open" @keydown.escape="open = false"
                                class="crm-btn crm-btn-ghost crm-btn-sm"
                                style="display:flex;align-items:center;gap:0.25rem;padding-right:0.5rem;">
                            Actions
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:0.75rem;height:0.75rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open"
                             @click.outside="open = false"
                             x-transition:enter="transition ease-out duration-75"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-50"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             style="display:none;position:absolute;right:0;top:calc(100% + 4px);background:#ffffff;border:1px solid var(--color-border);border-radius:8px;box-shadow:0 4px 16px rgba(0,0,0,.1);z-index:100;min-width:148px;padding:4px 0;">

                            <a href="{{ route('crm.invoices.show', $inv) }}"
                               style="display:block;padding:7px 14px;font-size:0.8125rem;color:var(--color-ink-1);text-decoration:none;"
                               onmouseover="this.style.background='var(--color-surface-2)'" onmouseout="this.style.background='transparent'">
                                View
                            </a>

                            <a href="{{ route('crm.invoices.edit', $inv) }}"
                               style="display:block;padding:7px 14px;font-size:0.8125rem;color:var(--color-ink-1);text-decoration:none;"
                               onmouseover="this.style.background='var(--color-surface-2)'" onmouseout="this.style.background='transparent'">
                                Edit
                            </a>

                            <a href="{{ route('invoice.pdf', $inv->invoice_id) }}" target="_blank"
                               style="display:block;padding:7px 14px;font-size:0.8125rem;color:var(--color-ink-1);text-decoration:none;"
                               onmouseover="this.style.background='var(--color-surface-2)'" onmouseout="this.style.background='transparent'">
                                Download PDF
                            </a>

                            @if($inv->status === 'Draft' && $inv->client?->email)
                            <div style="border-top:1px solid var(--color-border);margin:4px 0;"></div>
                            <button type="button" @click.stop="open=false; sendOpen=true"
                                    style="display:block;width:100%;padding:7px 14px;font-size:0.8125rem;color:#0369a1;background:transparent;border:none;cursor:pointer;text-align:left;"
                                    onmouseover="this.style.background='var(--color-surface-2)'" onmouseout="this.style.background='transparent'">
                                Send to Client
                            </button>
                            @endif

                        </div>

                        {{-- Send confirmation modal --}}
                        @if($inv->status === 'Draft' && $inv->client?->email)
                        <div x-show="sendOpen" x-cloak class="crm-modal-overlay" @click.self="sendOpen=false">
                            <div class="crm-modal" @click.stop>
                                <div class="crm-modal-header">
                                    <h3 class="crm-modal-title">Send Invoice</h3>
                                    <button type="button" @click="sendOpen=false" class="crm-icon-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                                </div>
                                <div class="crm-modal-body">
                                    <div class="crm-modal-icon crm-modal-icon--primary">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <p>Send <strong>{{ $inv->invoice_id }}</strong> to <strong>{{ $inv->client->email }}</strong>?</p>
                                </div>
                                <div class="crm-modal-footer">
                                    <button type="button" @click="sendOpen=false" class="crm-btn crm-btn-secondary">Cancel</button>
                                    <form method="POST" action="{{ route('crm.invoices.send', $inv) }}">
                                        @csrf
                                        <button type="submit" class="crm-btn crm-btn-primary">Send Invoice</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9">
                    <div class="crm-empty">
                        <div class="crm-empty-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1.5rem;height:1.5rem;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                            </svg>
                        </div>
                        <p class="crm-empty-title">No invoices found</p>
                        <a href="{{ route('crm.invoices.create') }}" class="crm-btn crm-btn-primary" style="margin-top:1rem;">New Invoice</a>
                    </div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    @if($invoices->hasPages())
        <div style="padding:1rem 1.25rem;border-top:1px solid var(--color-border);">
            {{ $invoices->links() }}
        </div>
    @endif
</div>

</x-crm::layout>
