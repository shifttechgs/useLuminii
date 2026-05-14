<x-crm::layout title="Services & Pricing">
<div class="crm-page-header">
    <div>
        <h1 class="crm-page-title">Services & Pricing</h1>
        <p class="crm-page-subtitle">Services shown in quote and invoice dropdowns</p>
    </div>
    <a href="{{ route('crm.services.create') }}" class="crm-btn crm-btn-primary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Service
    </a>
</div>

@php
    $unitLabels = ['hour' => '/hr', 'day' => '/day', 'item' => '/item', 'job' => ' fixed', 'month' => '/mo'];
@endphp

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem;">
    <div class="crm-stat"><span class="crm-stat-label">Total</span><span class="crm-stat-value">{{ $stats['total'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Active</span><span class="crm-stat-value">{{ $stats['active'] }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Inactive</span><span class="crm-stat-value">{{ $stats['inactive'] }}</span></div>
</div>

<div class="crm-table-wrap" style="overflow:visible;">
    <div class="crm-table-toolbar">
        <span style="font-size:0.8125rem;color:var(--color-ink-3);">{{ $services->total() }} services</span>
    </div>
    <table class="crm-table">
        <thead>
            <tr>
                <th>Service</th>
                <th>Category</th>
                <th>Unit</th>
                <th>Price</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @forelse($services as $svc)
        <tr>
            <td>
                <p style="font-weight:500;">{{ $svc->name }}</p>
                @if($svc->description)
                    <p style="font-size:0.75rem;color:var(--color-ink-3);margin-top:2px;">{{ Str::limit($svc->description, 60) }}</p>
                @endif
            </td>
            <td><span class="crm-badge crm-badge-neutral" style="font-size:0.6875rem;">{{ $svc->category ?? '—' }}</span></td>
            <td style="color:var(--color-ink-2);font-size:0.875rem;">{{ ucfirst($svc->unit_type) }}</td>
            <td style="font-weight:600;font-family:monospace;font-size:0.875rem;">
                R{{ number_format($svc->unit_price, 2) }}{{ $unitLabels[$svc->unit_type] ?? '' }}
            </td>
            <td>
                <span class="crm-badge {{ $svc->is_active ? 'crm-badge-success' : 'crm-badge-neutral' }}">
                    {{ $svc->is_active ? 'Active' : 'Inactive' }}
                </span>
            </td>
            <td style="text-align:right;" x-data="{ menu:false, confirmDelete:false }" @keydown.escape.window="menu=false;confirmDelete=false">
                <div style="position:relative;display:inline-flex;" @click.stop>
                    <button type="button"
                            class="crm-icon-btn"
                            @click="menu = !menu"
                            aria-label="Service actions"
                            aria-haspopup="true">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.75h.01M12 12h.01M12 17.25h.01"/>
                        </svg>
                    </button>
                    <div x-show="menu"
                         x-transition
                         @click.outside="menu=false"
                         style="position:absolute;right:0;top:calc(100% + 0.375rem);z-index:60;min-width:11rem;background:#fff;border:1px solid var(--color-border);border-radius:var(--radius-md);box-shadow:var(--shadow-dropdown);padding:0.375rem;text-align:left;">
                        <a href="{{ route('crm.services.edit', $svc) }}" class="crm-dropdown-item">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                            Edit service
                        </a>
                        <button type="button" @click="menu=false;confirmDelete=true" class="crm-dropdown-item crm-dropdown-item-danger">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166M19.228 5.79L18.16 19.673A2.25 2.25 0 0115.916 21H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .397c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            Delete service
                        </button>
                    </div>
                </div>

                <div x-show="confirmDelete" x-cloak class="crm-modal-overlay" @click.self="confirmDelete=false">
                    <div class="crm-modal" @click.stop>
                        <div class="crm-modal-header">
                            <h3 class="crm-modal-title">Delete Service</h3>
                            <button type="button" @click="confirmDelete=false" class="crm-icon-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                        </div>
                        <div class="crm-modal-body">
                            <div class="crm-modal-icon crm-modal-icon--danger">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </div>
                            <p>Are you sure you want to delete <strong>{{ $svc->name }}</strong>? This action cannot be undone.</p>
                        </div>
                        <div class="crm-modal-footer">
                            <button type="button" @click="confirmDelete=false" class="crm-btn crm-btn-secondary">Cancel</button>
                            <form method="POST" action="{{ route('crm.services.destroy', $svc) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="crm-btn crm-btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">
                <div class="crm-empty">
                    <p class="crm-empty-title">No services yet</p>
                    <a href="{{ route('crm.services.create') }}" class="crm-btn crm-btn-primary" style="margin-top:1rem;">Add Service</a>
                </div>
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>
    @if($services->hasPages())
        <div style="padding:1rem 1.25rem;border-top:1px solid var(--color-border);">
            {{ $services->links() }}
        </div>
    @endif
</div>
</x-crm::layout>
