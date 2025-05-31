<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Laporan Penjualan</h1>
    @if ($search)
        <p>Hasil pencarian untuk: <strong>{{ $search }}</strong></p>
    @endif
    @if ($startDate && $endDate)
        <p>Hasil pencarian untuk tanggal <strong>{{ $startDate }} - {{ $endDate }}</strong></p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pembeli</th>
                <th>Kasir</th>
                <th>Tanggal Pesanan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $key => $penjualan)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $penjualan->pembeli->nama }}</td>
                    <td>{{ $penjualan->kasir->name }}</td>
                    <td>{{ $penjualan->tanggal_pesanan }}</td>
                    <td class="text-right">{{ number_format($penjualan->detailPenjualan->sum('total_harga'), 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data penjualan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>