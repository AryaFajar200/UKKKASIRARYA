<x-app-layout>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Transaksi') }}
            </h2>
        </x-slot>
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <h2 class="text-lg font-semibold mt-4 mb-4 text-center ">Daftar Transaksi</h2>
                    <div class="table-responsive">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No.</th>
                                    <th scope="col" class="px-6 py-3">No Meja</th>
                                    <th scope="col" class="px-6 py-3">Kasir</th>

                                    <th scope="col" class="px-6 py-3">Tanggal</th>
                                    <th scope="col" class="px-6 py-3">Jenis Order</th>
                                    <th scope="col" class="px-6 py-3">Tipe Pembayaran</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Uang Diberikan</th>
                                    
                                    <th scope="col" class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                @foreach ($transaction as $index => $transactions)
                                
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                                        {{ $index + 1 }}
                                    </td>
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$transactions->no_table}}
                                    </th>
                                    <td class="px-6 py-4">
                      
                                        @php
                                        $kasir = $transactions->user->name ?? 'User Not Found'; // Mendapatkan nama kasir atau menetapkan string default jika tidak ditemukan
                                        $tanggalTransaksi = $transactions->order_date;
                                    @endphp
                                    {{ $kasir }}
                                    </td>
                            
                                    <td class="px-6 py-4">
                                        {{ $tanggalTransaksi }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$transactions->order_type}}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{$transactions->payment_type}}
                                    </td>
                                     <td class="px-6 py-4">
                                        @if ($transactions->payment_status == 'sudah dibayar')
                                            <span class="px-2 py-1 bg-green-200 text-green-800 rounded-full">Sudah Dibayar</span>
                                        @else
                                            <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded-full">Bayar Nanti</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($transactions->cash)
                                        {{ $transactions->cash}}
                                    @else
                                        <p class="font-bold"> Belum Bayar
                                    @endif
                                    </td>
                                    
                                    
                                    
                                    <td class="px-6 py-4">
                                        <div style="display: flex; align-items: center; margin-top: 15px;">
                                            
                                            <form action="{{ route('transaction-detail', ['transaction_id' => $transactions->id, 'kasir' => $kasir, 'tanggal_transaksi' => $tanggalTransaksi]) }}" method="GET">
                                                @csrf
                                                <input type="hidden" name="kasir" value="{{ $kasir }}">
                                                <input type="hidden" name="tanggal_transaksi" value="{{ $tanggalTransaksi }}">
                                                <button type="submit" class="btn btn-primary" style="background-color: #17a2b8; color: #fff;">Detail</button>
                                            </form>
                                            
                                            @if ($transactions->payment_status != 'sudah dibayar')
                                            <form action="{{ route('transaction.edit', ['transaction_id' => $transactions->id]) }}" method="GET">
                                                @csrf
                                                <button type="submit" class="btn btn-primary ml-2" style="background-color: #007bff; color: #fff;">Edit</button>
                                            </form>
                                            @endif
                                        </div>
                                        
                                        
                                    </td>
                                </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</body>
</html>
