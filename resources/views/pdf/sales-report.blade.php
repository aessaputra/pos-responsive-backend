<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Harian</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 11px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
        }

        .content {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
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
            background-color: #f7f7f7;
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

        tfoot {
            font-weight: bold;
            background-color: #f7f7f7;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Laporan Penjualan Harian</h1>
            <p>Periode: {{ $startDate }}</p>
        </div>

        <div class="content">
            <div class="section-title">Rincian Penjualan</div>
            <table>
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%;">No.</th>
                        <th style="width: 50%;">Nama Item</th>
                        <th class="text-center" style="width: 20%;">Jumlah</th>
                        <th class="text-right" style="width: 25%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reportData['items'] as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item['product_name'] }}</td>
                            <td class="text-center">{{ $item['total_quantity'] }}</td>
                            <td class="text-right">Rp {{ number_format($item['total_revenue'], 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data penjualan untuk periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if (!empty($reportData['items']))
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-right"><strong>Total Keseluruhan</strong></td>
                            <td class="text-center">
                                <strong>{{ number_format($reportData['totals']['total_quantity']) }}</strong>
                            </td>
                            <td class="text-right"><strong>Rp
                                    {{ number_format($reportData['totals']['grand_total'], 0, ',', '.') }}</strong></td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>

    <div class="footer">
        Laporan ini dibuat secara otomatis oleh sistem pada {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>

</html>
