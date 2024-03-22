<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Detail</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Transaction Detail</h1>
        <h5>Kasir: {{ $kasir }}</h5>
        <H5>Tanggal Transaksi: {{ $tanggalTransaksi }}</H5>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Menu</th>
                    <th>Harga Satuan</th>
                    <th>Besaran Diskon</th>
                    <th>Harga Setelah Diskon</th>
                    <th>Quantity</th>
                    <th>Jumlah Harga</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalBayar = 0;
                @endphp
                @foreach($transactionDetails as $index => $transactionDetail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transactionDetail->menu->menu_name }}</td>
                    
                    <td>{{ $transactionDetail->menu->price }}</td>
                    <td> @if($transactionDetail->discount_rate)
                        {{ $transactionDetail->discount_rate }}%
                    @else
                        No discount 
                    @endif</td>
                    <td>
                        @php
                            $hargaSatuan = $transactionDetail->menu->price;
                            $discountRate = $transactionDetail->discount_rate ?? 0; // Menggunakan nilai default 0 jika tidak ada diskon
                            $hargaSetelahDiskon = $hargaSatuan * (1 - $discountRate / 100); // Menghitung harga setelah diskon
                            echo $hargaSetelahDiskon; // Menampilkan harga setelah diskon
                        @endphp
                    </td>
                    <td>{{ $transactionDetail->qty }}</td>
                    <td>
                        
                        @php
                        $hargaSatuan = $transactionDetail->menu->price;
                        $discountRate = $transactionDetail->discount_rate ?? 0; // Menggunakan nilai default 0 jika tidak ada diskon
                        $jumlahHarga = $hargaSatuan * $transactionDetail->qty * (1 - $discountRate / 100); // Menghitung jumlah harga setelah diskon
                        $totalBayar += $jumlahHarga; // Menambahkan jumlah harga ke totalBayar
                    @endphp
                        {{ $jumlahHarga }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5"><strong>Total Bayar</strong></td>
                    <td>{{ $totalBayar }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
