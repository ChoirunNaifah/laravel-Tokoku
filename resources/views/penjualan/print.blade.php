<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Penjualan - Toko Ifaa</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 40px;
            color: #333;
        }

        .header {
            border-bottom: 3px solid #e91e63;
            padding-bottom: 10px;
            margin-bottom: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 32px;
            margin: 0;
            color: #e91e63;
        }

        h2, h3 {
            text-align: center;
            color: #d81b60;
        }

        .info {
            margin-bottom: 30px;
        }

        .info p {
            font-size: 16px;
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }

        th, td {
            border: 1px solid #f8bbd0;
            padding: 10px;
        }

        th {
            background-color: #fce4ec;
            color: #880e4f;
        }

        tr:nth-child(even) {
            background-color: #fdf0f5;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
            background-color: #f8bbd0;
        }

        @media print {
            body {
                margin: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Toko Ifaa</h1>
    </div>

    <h2>Detail Penjualan</h2>

    <div class="info">
        <p><strong>Pembeli:</strong> {{ $penjualan->pembeli->nama }}</p>
        <p><strong>Kasir:</strong> {{ $penjualan->kasir->name }}</p>
        <p><strong>Tanggal Pesanan:</strong> {{ $penjualan->tanggal_pesanan }}</p>
        <p><strong>Total Harga:</strong> Rp {{ number_format($penjualan->detailPenjualan->sum('total_harga'), 0, ',', '.') }}</p>
    </div>

    <h3>Daftar Barang</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan->detailPenjualan as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->barang->nama }}</td>
                    <td class="text-right">Rp {{ number_format($detail->barang->harga, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $detail->jumlah }}</td>
                    <td class="text-right">Rp {{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="4" class="text-right">Total Harga</td>
                <td class="text-right">Rp {{ number_format($penjualan->detailPenjualan->sum('total_harga'), 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <script>
        window.print();
    </script>
</body>
</html>
