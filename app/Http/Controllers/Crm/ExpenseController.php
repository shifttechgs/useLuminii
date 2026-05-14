<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with('category')->orderBy('expense_date', 'desc');

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%$search%")
                  ->orWhere('vendor', 'like', "%$search%")
                  ->orWhere('expense_id', 'like', "%$search%");
            });
        }
        if ($cat = $request->get('category')) {
            $query->where('category_id', $cat);
        }

        $expenses    = $query->paginate(25)->withQueryString();
        $categories  = ExpenseCategory::orderBy('name')->get();

        $stats = [
            'total_month' => Expense::whereBetween('expense_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount'),
            'total_year'  => Expense::whereYear('expense_date', now()->year)->sum('amount'),
            'count'       => Expense::count(),
        ];

        return view('crm.expenses.index', compact('expenses', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = ExpenseCategory::orderBy('name')->get();
        return view('crm.expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'description'    => 'required|string|max:255',
            'vendor'         => 'nullable|string|max:255',
            'amount'         => 'required|numeric|min:0',
            'expense_date'   => 'required|date',
            'category_id'    => 'required|exists:expense_categories,id',
            'is_recurring'   => 'boolean',
            'recurrence_type'=> 'nullable|in:Weekly,Monthly,Yearly',
            'notes'          => 'nullable|string',
            'receipt'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('receipts', 'public');
        }

        $expense = Expense::create([
            'description'    => $data['description'],
            'vendor'         => $data['vendor'] ?? null,
            'amount'         => $data['amount'],
            'expense_date'   => $data['expense_date'],
            'category_id'    => $data['category_id'],
            'user_id'        => auth()->id(),
            'is_recurring'   => $request->boolean('is_recurring'),
            'recurrence_type'=> $data['recurrence_type'] ?? null,
            'notes'          => $data['notes'] ?? null,
            'receipt_path'   => $receiptPath,
        ]);

        ActivityLog::record('created', 'Expense', $expense->expense_id, "Expense '{$expense->description}' of R{$expense->amount} added");

        return redirect()->route('crm.expenses.index')->with('success', 'Expense added.');
    }

    public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::orderBy('name')->get();
        return view('crm.expenses.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'description'    => 'required|string|max:255',
            'vendor'         => 'nullable|string|max:255',
            'amount'         => 'required|numeric|min:0',
            'expense_date'   => 'required|date',
            'category_id'    => 'required|exists:expense_categories,id',
            'is_recurring'   => 'boolean',
            'recurrence_type'=> 'nullable|in:Weekly,Monthly,Yearly',
            'notes'          => 'nullable|string',
            'receipt'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        if ($request->hasFile('receipt')) {
            if ($expense->receipt_path) {
                Storage::disk('public')->delete($expense->receipt_path);
            }
            $data['receipt_path'] = $request->file('receipt')->store('receipts', 'public');
        }

        $expense->update($data + ['is_recurring' => $request->boolean('is_recurring'), 'user_id' => auth()->id()]);

        return redirect()->route('crm.expenses.index')->with('success', 'Expense updated.');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->receipt_path) {
            Storage::disk('public')->delete($expense->receipt_path);
        }
        $expense->delete();
        return redirect()->route('crm.expenses.index')->with('success', 'Expense deleted.');
    }
}

