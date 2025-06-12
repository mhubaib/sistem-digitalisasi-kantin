<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionPdfExport
{
    protected $query;
    protected $totalIncome;
    protected $totalExpenses;

    public function __construct($query, $totalIncome, $totalExpenses)
    {
        $this->query = $query;
        $this->totalIncome = $totalIncome;
        $this->totalExpenses = $totalExpenses;
    }

    public function export()
    {
        $transactions = $this->query->get();
        $pdf = PDF::loadView('exports.transactions-pdf', [
            'transactions' => $transactions,
            'totalIncome' => $this->totalIncome,
            'totalExpenses' => $this->totalExpenses,
            'netProfit' => $this->totalIncome - $this->totalExpenses
        ]);

        return $pdf->download('laporan-transaksi-' . now()->format('Y-m-d') . '.pdf');
    }
}
