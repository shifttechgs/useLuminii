<x-crm::layout title="Edit Service">
@push('head')
<style>
    .crm-service-edit-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 1.5rem;
        align-items: start;
    }
    @media (max-width: 1023px) {
        .crm-service-edit-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

<div class="crm-page-header">
    <div>
        <h1 class="crm-page-title">Edit Service</h1>
        <p class="crm-page-subtitle">Update pricing, category, and quote visibility for this service</p>
    </div>
    <div style="display:flex;gap:0.625rem;align-items:center;">
        <a href="{{ route('crm.services.index') }}" class="crm-btn crm-btn-secondary">Back to Services</a>
        <button type="submit" form="service-edit-form" class="crm-btn crm-btn-primary">Save Changes</button>
    </div>
</div>

@php
    $unitLabels = ['hour' => 'Per hour', 'day' => 'Per day', 'item' => 'Per item', 'job' => 'Fixed job', 'month' => 'Monthly'];
@endphp

<div class="crm-service-edit-grid">
    <form id="service-edit-form" method="POST" action="{{ route('crm.services.update', $service) }}" class="crm-card" style="padding:0;overflow:hidden;">
        @csrf
        @method('PUT')

        <div style="padding:1.25rem 1.5rem;border-bottom:1px solid var(--color-border);background:var(--color-surface-2);">
            <p style="font-size:0.8125rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--color-ink-3);margin:0 0 0.25rem;">Service details</p>
            <h2 style="font-size:1rem;font-weight:700;color:var(--color-ink-1);margin:0;">Commercial information</h2>
        </div>

        <div style="padding:1.5rem;display:grid;gap:1.25rem;">
            <div class="crm-form-group">
                <label class="crm-label">Service Name <span style="color:var(--color-danger);">*</span></label>
                <input type="text"
                       name="name"
                       class="crm-input @error('name') is-invalid @enderror"
                       value="{{ old('name', $service->name) }}"
                       required
                       placeholder="e.g. Website care plan">
                @error('name') <p class="crm-field-error">{{ $message }}</p> @enderror
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="crm-form-group">
                    <label class="crm-label">Category</label>
                    <select name="category" class="crm-select">
                        <option value="">None</option>
                        @foreach(['Web','Mobile','Design','Software','Cloud','AI','Support','Consulting','Other'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $service->category) === $cat ? 'selected' : '' }}>{{ $cat === 'AI' ? 'AI & Automation' : $cat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="crm-form-group">
                    <label class="crm-label">Priced Per <span style="color:var(--color-danger);">*</span></label>
                    <select name="unit_type" class="crm-select" required>
                        @foreach(['hour' => 'Hour', 'day' => 'Day', 'item' => 'Item', 'job' => 'Job (fixed)', 'month' => 'Month'] as $val => $lbl)
                            <option value="{{ $val }}" {{ old('unit_type', $service->unit_type) === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="crm-form-group">
                <label class="crm-label">Default Price <span style="color:var(--color-danger);">*</span></label>
                <div style="position:relative;">
                    <span style="position:absolute;left:0.875rem;top:50%;transform:translateY(-50%);color:var(--color-ink-3);font-weight:700;">R</span>
                    <input type="number"
                           name="unit_price"
                           class="crm-input @error('unit_price') is-invalid @enderror"
                           value="{{ old('unit_price', $service->unit_price) }}"
                           step="0.01"
                           min="0"
                           required
                           style="padding-left:2rem;font-weight:600;">
                </div>
                <p style="font-size:0.75rem;color:var(--color-ink-3);margin-top:4px;">Used as the default line-item price when this service is selected.</p>
                @error('unit_price') <p class="crm-field-error">{{ $message }}</p> @enderror
            </div>

            <div class="crm-form-group">
                <label class="crm-label">Description</label>
                <textarea name="description"
                          class="crm-textarea"
                          rows="5"
                          placeholder="Optional description used internally and on service documents">{{ old('description', $service->description) }}</textarea>
            </div>

            <label for="is_active" style="display:flex;align-items:flex-start;gap:0.75rem;padding:1rem;border:1px solid var(--color-border);border-radius:var(--radius-md);background:var(--color-surface-2);cursor:pointer;">
                <input type="checkbox"
                       name="is_active"
                       id="is_active"
                       value="1"
                       {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                       style="width:1rem;height:1rem;margin-top:0.125rem;accent-color:var(--color-accent);">
                <span>
                    <span style="display:block;font-size:0.875rem;font-weight:700;color:var(--color-ink-1);">Active service</span>
                    <span style="display:block;font-size:0.8125rem;color:var(--color-ink-3);margin-top:0.125rem;">Visible in quote and invoice dropdowns.</span>
                </span>
            </label>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:0.75rem;padding:1rem 1.5rem;border-top:1px solid var(--color-border);background:var(--color-surface);">
            <a href="{{ route('crm.services.index') }}" class="crm-btn crm-btn-secondary">Cancel</a>
            <button type="submit" class="crm-btn crm-btn-primary">Save Changes</button>
        </div>
    </form>

    <aside class="crm-card" style="padding:1.25rem;">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1rem;">
            <div>
                <p style="font-size:0.75rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--color-ink-3);margin:0 0 0.25rem;">Current service</p>
                <h2 style="font-size:1rem;font-weight:700;color:var(--color-ink-1);margin:0;">{{ $service->name }}</h2>
            </div>
            <span class="crm-badge {{ $service->is_active ? 'crm-badge-success' : 'crm-badge-neutral' }}">{{ $service->is_active ? 'Active' : 'Inactive' }}</span>
        </div>

        <div style="display:grid;gap:0.875rem;">
            <div style="padding:0.875rem;border:1px solid var(--color-border);border-radius:var(--radius-md);background:var(--color-surface-2);">
                <p style="font-size:0.75rem;color:var(--color-ink-3);margin:0 0 0.25rem;">Default price</p>
                <p style="font-size:1.25rem;font-weight:800;color:var(--color-ink-1);margin:0;">R {{ number_format($service->unit_price, 2) }}</p>
                <p style="font-size:0.75rem;color:var(--color-ink-3);margin:0.125rem 0 0;">{{ $unitLabels[$service->unit_type] ?? ucfirst($service->unit_type) }}</p>
            </div>

            <div style="display:flex;justify-content:space-between;gap:1rem;padding-bottom:0.75rem;border-bottom:1px solid var(--color-border);">
                <span style="font-size:0.8125rem;color:var(--color-ink-3);">Category</span>
                <span style="font-size:0.8125rem;font-weight:600;color:var(--color-ink-1);">{{ $service->category ?: 'None' }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;gap:1rem;padding-bottom:0.75rem;border-bottom:1px solid var(--color-border);">
                <span style="font-size:0.8125rem;color:var(--color-ink-3);">Unit</span>
                <span style="font-size:0.8125rem;font-weight:600;color:var(--color-ink-1);">{{ ucfirst($service->unit_type) }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;gap:1rem;">
                <span style="font-size:0.8125rem;color:var(--color-ink-3);">Last updated</span>
                <span style="font-size:0.8125rem;font-weight:600;color:var(--color-ink-1);">{{ $service->updated_at?->format('d M Y') ?? 'Never' }}</span>
            </div>
        </div>
    </aside>
</div>
</x-crm::layout>
