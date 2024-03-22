<!DOCTYPE html>
<html>
<head>
    <title>LAPORAN PENJUALAN</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>LAPORAN PENJUALAN</h2>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Kasir</th>
                <th>Menu</th>
                <th>Jumlah Menu</th>
                <th>Harga Jual</th>
                <th>Discount Rate</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $detail)
                @if ($detail->transaction->user->name)
                    <tr>
                        <td>{{ $detail->transaction_id}}</td>
                        <td>{{ $detail->transaction->user->name ?? 'N/A' }}</td>
                        <td>{{ $detail->menu->menu_name}}</td>
                        <td>{{ $detail->qty}}</td>
                        <td>Rp. {{ number_format($detail->price) }}</td>
                        <td>{{ $detail->discount_rate != 0 ? $detail->discount_rate.'%' : 'No Discount' }}</td>
                        <td>{{ $detail->transaction->order_date ?? 'N/A' }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>
