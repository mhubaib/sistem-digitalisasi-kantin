<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #2d3748;
            margin: 0;
            font-size: 24px;
        }

        .header p {
            color: #718096;
            margin: 5px 0 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f7fafc;
            font-weight: bold;
        }

        .summary {
            margin-top: 30px;
            border-top: 2px solid #e2e8f0;
            padding-top: 20px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .summary-item.total {
            font-weight: bold;
            font-size: 14px;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
            margin-top: 10px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            color: #718096;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Transaksi</h1>
        <p>Periode: {{ request('start_date') ? date('d/m/Y', strtotime(request('start_date'))) : 'Semua' }} -
            {{ request('end_date') ? date('d/m/Y', strtotime(request('end_date'))) : 'Semua' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Santri</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Kasir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $transaction->santri?->user?->name ?? 'Non-Santri' }}</td>
                    <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                    <td>{{ $transaction->payment_type === 'saldo' ? 'Saldo Digital' : 'Tunai' }}</td>
                    <td>{{ $transaction->createdBy?->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-item">
            <span>Total Pendapatan:</span>
            <span>Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
        </div>
        <div class="summary-item">
            <span>Total Pengeluaran:</span>
            <span>Rp {{ number_format($totalExpenses, 0, ',', '.') }}</span>
        </div>
        <div class="summary-item total">
            <span>Laba Bersih:</span>
            <span>Rp {{ number_format($netProfit, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Sistem Koperasi Digital</p>
    </div>
</body>

</html>
