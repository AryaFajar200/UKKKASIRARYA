<x-app-layout>
<!DOCTYPE html>
<html>
<head>
    <title>Transaction Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/e0d812d232.js" crossorigin="anonymous"></script>
</head>
<body>
    
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Laporan') }}
            </h2>
        </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <a href="{{ route('download-pdf') }}" class="btn btn-primary" style="margin-bottom: 20px;"> &nbsp; Download PDF</a>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>No. Transaksi</th>
                                    <th>Kasir</th>
                                    <th>Menu</th>
                                    <th>Jumlah Menu</th>
                                    <th>Harga Jual</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Discount Rate</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $totalBayar = 0;
                                @endphp
                                @foreach ($data as $detail)
                                    @if ($detail->transaction->payment_status === 'sudah dibayar' && $detail->transaction->user->name)
                                        <tr>
                                            <td>{{ $detail->transaction_id}}</td>
                                            <td>{{ $detail->transaction->user->name ?? 'N/A' }}</td>
                                            <td>{{ $detail->menu->menu_name }}</td>
                                            <td>{{ $detail->qty }}</td>
                                            <td>Rp. {{ number_format($detail->price) }}</td>
                                            <td>{{ $detail->transaction->order_date ?? 'N/A' }}</td>
                                            <td>
                                                @if ($detail->discount_rate)
                                                    {{ $detail->discount_rate . '%' }}
                                                @else
                                                    No Discount
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                $hargaSatuan = $detail->menu->price;
                                                $discountRate = $detail->discount_rate ?? 0; // Menggunakan nilai default 0 jika tidak ada diskon
                                                $jumlahHarga = $hargaSatuan * $detail->qty * (1 - $discountRate / 100); // Menghitung jumlah harga setelah diskon
                                                $totalBayar += $jumlahHarga; // Menambahkan jumlah harga ke totalBayar
                                            @endphp
                                            
                                                {{ number_format($jumlahHarga) }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <td colspan="7" class="text-right">Total</td>
                                    <td>Rp. {{ number_format($totalBayar) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
