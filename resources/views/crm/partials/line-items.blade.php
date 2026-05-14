{{-- Line Items Builder --}}
{{-- Usage: @include('crm.partials.line-items', ['items' => $existing, 'currencySymbol' => 'R']) --}}
@php
    $uid = 'li_' . uniqid();
    $sym = $currencySymbol ?? 'R';
    $safeItems = array_map(fn($i) => [
        'description' => $i['description'] ?? '',
        'quantity'    => (float)($i['quantity']   ?? 1),
        'unit_price'  => (float)($i['unit_price']  ?? 0),
        'line_total'  => (float)($i['line_total']  ?? 0),
    ], $items ?? []);
@endphp
<script>window['{{ $uid }}'] = {!! json_encode($safeItems) !!};</script>
<div x-data="lineItems('{{ $uid }}', '{{ $sym }}')" class="crm-card" style="overflow:visible;">
    <div class="crm-card-header">
        <span class="crm-card-title">Line Items</span>
        <button type="button" @click="addRow()" class="crm-btn crm-btn-secondary crm-btn-sm">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Item
        </button>
    </div>
    <div class="crm-table-wrap" style="border:none;border-radius:0;box-shadow:none;overflow:auto;">
        <table class="crm-table" style="min-width:600px;">
            <thead><tr>
                <th style="width:50%;">Description</th>
                <th style="width:15%;">Qty</th>
                <th style="width:18%;" x-text="'Unit Price (' + sym + ')'">Unit Price</th>
                <th style="width:15%;">Total</th>
                <th style="width:2%;"></th>
            </tr></thead>
            <tbody>
            <template x-for="(row, idx) in rows" :key="idx">
                <tr>
                    <td>
                        <input type="text"
                               class="crm-input"
                               :name="`items[${idx}][description]`"
                               x-model="row.description"
                               placeholder="Item description"
                               required>
                    </td>
                    <td>
                        <input type="number"
                               class="crm-input"
                               :name="`items[${idx}][quantity]`"
                               x-model.number="row.quantity"
                               @input="calc(row)"
                               min="0" step="0.01"
                               required>
                    </td>
                    <td>
                        <input type="number"
                               class="crm-input"
                               :name="`items[${idx}][unit_price]`"
                               x-model.number="row.unit_price"
                               @input="calc(row)"
                               min="0" step="0.01"
                               required>
                    </td>
                    <td style="font-weight:500;color:var(--color-ink-1);" x-text="sym + ' ' + row.line_total.toFixed(2)"></td>
                    <td>
                        <button type="button" @click="rows.splice(idx,1)" class="crm-icon-btn" style="color:var(--color-danger);" title="Remove">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:1rem;height:1rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </td>
                </tr>
            </template>
            <template x-if="rows.length === 0">
                <tr><td colspan="5"><div class="crm-empty" style="padding:1.5rem;"><p class="crm-empty-text">No items yet — click Add Item</p></div></td></tr>
            </template>
            </tbody>
        </table>
    </div>
    {{-- Totals --}}
    <div class="crm-card-footer" style="display:flex;justify-content:flex-end;">
        <div style="min-width:220px;">
            <div class="crm-detail-row">
                <span class="crm-detail-label">Subtotal</span>
                <span class="crm-detail-value" x-text="sym + ' ' + subtotal().toFixed(2)"></span>
            </div>
            <div class="crm-detail-row" style="font-size:1rem;font-weight:700;">
                <span class="crm-detail-label" style="color:var(--color-ink-1);font-weight:700;">Total</span>
                <span class="crm-detail-value" x-text="sym + ' ' + subtotal().toFixed(2)"></span>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('lineItems', (uid, sym) => {
        const existing = window[uid] || [];
        delete window[uid];
        return {
            sym: sym || 'R',
            rows: existing.length > 0
                ? existing.map(i => ({
                    description: i.description || '',
                    quantity:    parseFloat(i.quantity)   || 0,
                    unit_price:  parseFloat(i.unit_price) || 0,
                    line_total:  parseFloat(i.line_total) || 0,
                  }))
                : [],
            addRow() {
                this.rows.push({ description: '', quantity: 1, unit_price: 0, line_total: 0 });
            },
            calc(row) {
                row.line_total = row.quantity * row.unit_price;
            },
            subtotal() {
                return this.rows.reduce((s, r) => s + r.line_total, 0);
            },
        };
    });
});
</script>
