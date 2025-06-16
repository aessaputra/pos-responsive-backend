<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 12px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
        }

        .content {
            margin-bottom: 30px;
        }

        .stats {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .stat-item {
            display: table-cell;
            width: 33.33%;
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
        }

        .stat-item h3 {
            margin: 0 0 5px 0;
            font-size: 14px;
            font-weight: normal;
            color: #666;
        }

        .stat-item p {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Laporan Penjualan</h1>
            <p>Periode: {{ $periodTitle }} ({{ $startDate }} - {{ $endDate }})</p>
            <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>

        <div class="content">
            <h3>Ringkasan Statistik</h3>
            <div class="stats">
                <div class="stat-item">
                    <h3>Total Pendapatan</h3>
                    <p>Rp {{ number_format($reportData['stats']['total_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="stat-item">
                    <h3>Total Transaksi</h3>
                    <p>{{ number_format($reportData['stats']['total_transactions']) }}</p>
                </div>
                <div class="stat-item">
                    <h3>Item Terjual</h3>
                    <p>{{ number_format($reportData['stats']['total_items_sold']) }}</p>
                </div>
            </div>

            <h3>Rincian Produk Terlaris</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th class="text-center">Jumlah Terjual</th>
                        <th class="text-right">Total Omzet</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reportData['top_selling_items'] as $item)
                        <tr>
                            <td>{{ $item['product_name'] }}</td>
                            <td class="text-center">{{ $item['total_quantity_sold'] }}</td>
                            <td class="text-right">Rp {{ number_format($item['total_revenue'], 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data penjualan untuk periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        {{ config('app.name', 'Laravel') }}
    </div>
</body>

</html>
