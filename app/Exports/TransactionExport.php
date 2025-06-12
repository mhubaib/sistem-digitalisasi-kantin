<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TransactionExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query->get();
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Tanggal',
            'Santri',
            'Total',
            'Metode Pembayaran',
            'Kasir'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->created_at->format('d/m/Y H:i'),
            $transaction->santri?->user?->name ?? 'Non-Santri',
            'Rp ' . number_format($transaction->total, 0, ',', '.'),
            $transaction->payment_type === 'saldo' ? 'Saldo Digital' : 'Tunai',
            $transaction->createdBy?->name ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A1:F1' => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ]
            ]
        ];
    }
}
