<x-crm::layout title="Add Service">
<div class="crm-page-header">
    <div>
        <h1 class="crm-page-title">Add Service</h1>
        <p class="crm-page-subtitle">New service will appear in quote and invoice dropdowns immediately</p>
    </div>
    <a href="{{ route('crm.services.index') }}" class="crm-btn crm-btn-secondary">Cancel</a>
</div>

<div style="max-width:640px;">
<form method="POST" action="{{ route('crm.services.store') }}" class="crm-card" style="padding:1.5rem;display:flex;flex-direction:column;gap:1.25rem;">
    @csrf

    <div class="crm-form-group">
        <label class="crm-label">Service Name <span style="color:var(--color-danger);">*</span></label>
        <input type="text" name="name" class="crm-input @error('name') is-invalid @enderror"
               value="{{ old('name') }}" required placeholder="e.g. Custom Website Development">
        @error('name') <p class="crm-field-error">{{ $message }}</p> @enderror
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
        <div class="crm-form-group">
            <label class="crm-label">Category</label>
            <select name="category" class="crm-select">
                <option value="">— None —</option>
                @foreach(['Web','Mobile','Design','Software','Cloud','AI','Support','Consulting','Other'] as $cat)
                    <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat === 'AI' ? 'AI & Automation' : $cat }}</option>
                @endforeach
            </select>
        </div>

        <div class="crm-form-group">
            <label class="crm-label">Priced Per <span style="color:var(--color-danger);">*</span></label>
            <select name="unit_type" class="crm-select" required>
                @foreach(['hour' => 'Hour', 'day' => 'Day', 'item' => 'Item', 'job' => 'Job (fixed)', 'month' => 'Month'] as $val => $lbl)
                    <option value="{{ $val }}" {{ old('unit_type', 'job') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="crm-form-group">
        <label class="crm-label">Default Price (R) <span style="color:var(--color-danger);">*</span></label>
        <div style="position:relative;">
            <span style="position:absolute;left:0.75rem;top:50%;transform:translateY(-50%);color:var(--color-ink-3);font-weight:500;">R</span>
            <input type="number" name="unit_price" class="crm-input @error('unit_price') is-invalid @enderror"
                   value="{{ old('unit_price', 0) }}" step="0.01" min="0" required style="padding-left:1.75rem;">
        </div>
        <p style="font-size:0.75rem;color:var(--color-ink-3);margin-top:4px;">Auto-fills when this service is picked on a quote or invoice line</p>
        @error('unit_price') <p class="crm-field-error">{{ $message }}</p> @enderror
    </div>

    <div class="crm-form-group">
        <label class="crm-label">Description</label>
        <textarea name="description" class="crm-input" rows="3" placeholder="Optional — shown on quotes and invoices">{{ old('description') }}</textarea>
    </div>

    <div style="display:flex;align-items:center;gap:0.625rem;">
        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}
               style="width:1rem;height:1rem;accent-color:var(--color-accent);">
        <label for="is_active" style="font-size:0.875rem;font-weight:500;color:var(--color-ink-1);cursor:pointer;">
            Active — visible in all dropdowns
        </label>
    </div>

    <div style="display:flex;gap:0.75rem;padding-top:0.25rem;">
        <button type="submit" class="crm-btn crm-btn-primary">Save Service</button>
        <a href="{{ route('crm.services.index') }}" class="crm-btn crm-btn-secondary">Cancel</a>
    </div>
</form>
</div>
</x-crm::layout>
