<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Expense::with('createdBy');

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('expense_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('expense_date', '<=', $request->end_date);
        }

        $expenses = $query->latest()->paginate(10);
        $totalExpenses = $expenses->sum('amount');

        // Calculate total income based on the same date range
        $incomeQuery = Transaction::query();

        if ($request->filled('start_date')) {
            $incomeQuery->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $incomeQuery->whereDate('created_at', '<=', $request->end_date);
        }

        $totalIncome = $incomeQuery->sum('total');
        $netProfit = $totalIncome - $totalExpenses;

        return view('admin.expenses.index', compact('expenses', 'totalExpenses', 'totalIncome', 'netProfit'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|in:belanja,gaji,utilities,lainnya',
            'payment_method' => 'required|in:cash,transfer',
            'receipt_number' => 'nullable|string|max:255',
            'expense_date' => 'required|date',
        ]);

        $validated['created_by'] = Auth::id();

        Expense::create($validated);

        return redirect()
            ->route('admin.expenses.index')
            ->with('success', 'Pengeluaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        return view('admin.expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        return view('admin.expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|in:belanja,gaji,utilities,lainnya',
            'payment_method' => 'required|in:cash,transfer',
            'receipt_number' => 'nullable|string|max:255',
            'expense_date' => 'required|date',
        ]);

        $expense->update($validated);

        return redirect()
            ->route('admin.expenses.index')
            ->with('success', 'Pengeluaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()
            ->route('admin.expenses.index')
            ->with('success', 'Pengeluaran berhasil dihapus');
    }
}
