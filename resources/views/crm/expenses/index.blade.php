<x-crm::layout title="Expenses">
<div class="crm-page-header">
    <div><h1 class="crm-page-title">Expenses</h1><p class="crm-page-subtitle">Track business expenses and receipts</p></div>
    <a href="{{ route('crm.expenses.create') }}" class="crm-btn crm-btn-primary">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Expense
    </a>
</div>

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem;">
    <div class="crm-stat"><span class="crm-stat-label">This Month</span><span class="crm-stat-value" style="font-size:1.3rem;">R {{ number_format($stats['total_month'], 2) }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">This Year</span><span class="crm-stat-value" style="font-size:1.3rem;">R {{ number_format($stats['total_year'], 2) }}</span></div>
    <div class="crm-stat"><span class="crm-stat-label">Total Records</span><span class="crm-stat-value">{{ $stats['count'] }}</span></div>
</div>

<div class="crm-table-wrap">
    <div class="crm-table-toolbar">
        <form method="GET" action="{{ route('crm.expenses.index') }}" style="display:contents;">
            <div class="crm-search">
                <svg class="crm-search-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search expenses…">
            </div>
            <select name="category" class="crm-select" style="width:auto;" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="crm-btn crm-btn-secondary crm-btn-sm">Search</button>
            @if(request('q')||request('category'))<a href="{{ route('crm.expenses.index') }}" class="crm-btn crm-btn-ghost crm-btn-sm">Clear</a>@endif
        </form>
        <span style="margin-left:auto;font-size:0.8125rem;color:var(--color-ink-3);">{{ $expenses->total() }} records</span>
    </div>
    <table class="crm-table">
        <thead><tr><th>Description</th><th>Vendor</th><th>Category</th><th>Amount</th><th>Date</th><th></th></tr></thead>
        <tbody>
        @forelse($expenses as $exp)
        <tr>
            <td style="font-weight:500;">{{ $exp->description }}</td>
            <td style="color:var(--color-ink-2);">{{ $exp->vendor ?? '—' }}</td>
            <td>
                @if($exp->category)
                <span style="display:inline-flex;align-items:center;gap:0.375rem;font-size:0.8125rem;">
                    <span style="width:8px;height:8px;border-radius:50%;background:{{ $exp->category->color ?? '#8898aa' }};flex-shrink:0;"></span>
                    {{ $exp->category->name }}
                </span>
                @else —
                @endif
            </td>
            <td style="font-weight:600;">R {{ number_format($exp->amount, 2) }}</td>
            <td style="color:var(--color-ink-3);">{{ $exp->expense_date ? $exp->expense_date->format('d M Y') : '—' }}</td>
            <td style="display:flex;gap:0.375rem;" x-data="{ open: false }">
                <a href="{{ route('crm.expenses.edit', $exp) }}" class="crm-btn crm-btn-ghost crm-btn-sm">Edit</a>
                <button type="button" @click="open = true" class="crm-btn crm-btn-ghost crm-btn-sm" style="color:var(--color-danger-text);">Delete</button>
                <div x-show="open" x-cloak class="crm-modal-overlay" @click.self="open=false">
                    <div class="crm-modal" @click.stop>
                        <div class="crm-modal-header">
                            <h3 class="crm-modal-title">Delete Expense</h3>
                            <button type="button" @click="open=false" class="crm-icon-btn"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                        </div>
                        <div class="crm-modal-body">
                            <div class="crm-modal-icon crm-modal-icon--danger">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </div>
                            <p>Are you sure you want to delete this expense? This action cannot be undone.</p>
                        </div>
                        <div class="crm-modal-footer">
                            <button type="button" @click="open=false" class="crm-btn crm-btn-secondary">Cancel</button>
                            <form method="POST" action="{{ route('crm.expenses.destroy', $exp) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="crm-btn crm-btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="6"><div class="crm-empty"><p class="crm-empty-title">No expenses yet</p><a href="{{ route('crm.expenses.create') }}" class="crm-btn crm-btn-primary" style="margin-top:1rem;">Add Expense</a></div></td></tr>
        @endforelse
        </tbody>
    </table>
    @if($expenses->hasPages())<div style="padding:1rem 1.25rem;border-top:1px solid var(--color-border);">{{ $expenses->links() }}</div>@endif
</div>
</x-crm::layout>

