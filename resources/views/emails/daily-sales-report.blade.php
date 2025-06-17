<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Harian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .header {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .content p {
            margin: 0 0 10px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            Laporan Penjualan Harian
        </div>
        <div class="content">
            <p>Selamat pagi,</p>
            <p>Berikut terlampir laporan penjualan untuk tanggal <strong>{{ now()->subDay()->format('d F Y') }}</strong>
                dalam format PDF.</p>
            <p>Laporan ini dibuat secara otomatis oleh sistem.</p>
            <br>
            <p>Terima kasih,</p>
            <p><strong>{{ config('app.name', 'Laravel') }}</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
