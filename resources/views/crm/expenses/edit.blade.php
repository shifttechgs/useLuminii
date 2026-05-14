<x-crm::layout title="Edit Expense">
<div class="crm-page-header">
    <div><a href="{{ route('crm.expenses.index') }}" style="color:var(--color-ink-3);font-size:0.875rem;">Expenses</a> / <span style="font-size:0.875rem;">Edit</span>
    <h1 class="crm-page-title">Edit Expense</h1></div>
</div>
<form method="POST" action="{{ route('crm.expenses.update', $expense) }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div style="display:grid;grid-template-columns:1fr 280px;gap:1.25rem;">
    <div class="crm-card">
        <div class="crm-card-header"><span class="crm-card-title">Expense Details</span></div>
        <div class="crm-card-body" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div style="grid-column:1/-1;"><label class="crm-label">Description</label><input type="text" name="description" value="{{ old('description', $expense->description) }}" class="crm-input" required></div>
            <div><label class="crm-label">Vendor</label><input type="text" name="vendor" value="{{ old('vendor', $expense->vendor) }}" class="crm-input"></div>
            <div><label class="crm-label">Amount (R)</label><input type="number" name="amount" value="{{ old('amount', $expense->amount) }}" class="crm-input" step="0.01" min="0" required></div>
            <div><label class="crm-label">Date</label><input type="date" name="expense_date" value="{{ old('expense_date', $expense->expense_date?->format('Y-m-d')) }}" class="crm-input" required></div>
            <div>
                <label class="crm-label">Category</label>
                <select name="category_id" class="crm-select" required>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id',$expense->category_id)==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="grid-column:1/-1;"><label class="crm-label">Notes</label><textarea name="notes" class="crm-textarea" rows="2">{{ old('notes', $expense->notes) }}</textarea></div>
            <div style="grid-column:1/-1;"><label class="crm-label">New Receipt <span class="crm-label-hint">(leave blank to keep existing)</span></label><input type="file" name="receipt" class="crm-input" accept=".jpg,.jpeg,.png,.pdf" style="padding:0.375rem;"></div>
            <div style="grid-column:1/-1;display:flex;align-items:center;gap:0.75rem;">
                <input type="checkbox" name="is_recurring" id="is_recurring" value="1" {{ old('is_recurring',$expense->is_recurring)?'checked':'' }}>
                <label for="is_recurring" class="crm-label" style="margin:0;cursor:pointer;">Recurring</label>
            </div>
            <div>
                <label class="crm-label">Recurrence</label>
                <select name="recurrence_type" class="crm-select">
                    <option value="">— None —</option>
                    @foreach(['Weekly','Monthly','Yearly'] as $r)
                    <option value="{{ $r }}" {{ old('recurrence_type',$expense->recurrence_type)==$r?'selected':'' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div style="display:flex;flex-direction:column;gap:0.5rem;padding-top:3.5rem;">
        <button type="submit" class="crm-btn crm-btn-primary crm-btn-lg" style="width:100%;">Save Changes</button>
        <a href="{{ route('crm.expenses.index') }}" class="crm-btn crm-btn-ghost" style="width:100%;justify-content:center;">Cancel</a>
    </div>
</div>
</form>
</x-crm::layout>

