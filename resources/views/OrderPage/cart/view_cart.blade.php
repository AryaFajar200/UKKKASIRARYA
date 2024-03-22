<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e0d812d232.js" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <nav class="bg-[#0c4e68] py-4">
        <div class="container mx-auto">
            <h1 class="text-white text-2xl font-bold ml-3">RAMEN XYZ</h1>
        </div>
    </nav>
    <div class="container mx-auto mt-4 px-4">
        <a href="{{ route('halaman-order') }}" class="text-blue-500 mb-4 inline-block">&larr; Kembali ke Halaman Order</a>

        <h1 class="text-2xl font-semibold mb-4">Keranjang</h1>
        @if(count($cartItems) > 0)
    <div class="grid grid-cols-1 gap-4">
        @foreach($cartItems as $key => $item)
        <div class="bg-white shadow-md rounded-md p-4 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold mb-2">{{ $item['menu_name'] }}</h3>
                @if (isset($item['discount_price']))
                    <p>Harga: Rp {{ number_format($item['discount_price']) }}</p>
                @else
                    <p>Harga: Rp {{ number_format($item['price']) }}</p>
                @endif
                <p>Jumlah: {{ $item['qty'] }}</p>
                <p>Total Harga: Rp {{ number_format($item['price'] * $item['qty']) }}</p>
            </div>
            <div>
                @if (isset($item['menu_id']))
                    <form id="remove-form-{{ $key }}" action="{{ route('cart.remove', ['id' => $key]) }}" method="post">
                        @csrf
                        <button type="button" class="text-red-600" onclick="confirmRemove({{ $key }})">Hapus</button>
                    </form>
                @endif
            </div>
            
        </div>
    @endforeach
    
        <div class="bg-white shadow-md rounded-md p-4">
            <h3 class="text-lg font-semibold mb-2">Total Harga Keseluruhan</h3>
            <p>Rp {{ number_format($totalPrice) }}</p>
        </div>
    </div>
@else
    <p>Keranjang Anda kosong.</p>
@endif
    
    </div>

    <form id="checkout-form" action="{{ route('proses-transaction2') }}" method="post" class="container mx-auto mt-8 px-4">
        @csrf
        <input type="hidden" name="items" value="{{ json_encode($cartItems) }}">
        <input type="hidden" name="total_price" value="{{ $totalPrice }}">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="no_table" class="block">Nomor Meja</label>
                <input type="text" name="no_table" id="no_table" class="mt-1 block w-full" value="{{ session('no_table') }} " readonly>
            </div>
            <div>
                <label for="order_type" class="block">Jenis Pesanan</label>
                <input type="text" value="{{ session('order_type') }}" name="order_type" id="order_type" class="mt-1 block w-full" readonly>
            </div>
            <div>
                <label for="payment_type" class="block">Jenis Pembayaran</label>
                <select name="payment_type" id="payment_type" class="mt-1 block w-full">
                    <option value="tunai">Tunai</option>
                    <option value="non tunai">Non Tunai</option>
                </select>
            </div>
        </div>
        <input type="hidden" name="user_id" id="user_id" value="">
        <input type="hidden" name="payment_status" id="payment_status" value="bayar nanti">
        <input type="hidden" name="bonus_discount" id="bonus_discount">
        <input type="hidden" name="cash" id="cash">
        <div class="flex justify-center mt-4">
            <button class="w-full md:w-auto rounded-full bg-[#0c4e68] text-white px-6 py-3 focus:outline-none" onclick="confirmOrder()" {{ count($cartItems) == 0 ? 'disabled' : '' }}>
                Beli
            </button>
        </div>
        
            </form>

    <script>
        function confirmRemove(key) {
        Swal.fire({
            title: 'Konfirmasi Penghapusan',
            text: 'Apakah Anda yakin ingin menghapus item ini dari keranjang?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Pesanan berhasil dihapus.',
                    icon: 'success',
                    timer: 1500
            });
                document.getElementById('remove-form-' + key).submit();
            }
        });
    }
       
    function confirmOrder() {
    // Menampilkan SweetAlert saat formulir disubmit
    Swal.fire({
        title: 'Pesanan Berhasil',
        text: 'Pesanan Anda berhasil diproses.',
        icon: 'success',
        showConfirmButton: false,
        timer: 2000 // Durasi SweetAlert ditampilkan dalam milidetik (ms)
    });

    // Mengatur delay sebelum submit form untuk memberikan waktu SweetAlert ditampilkan
    setTimeout(() => {
        document.getElementById('checkout-form').submit();
    }, 2000); // Sesuaikan dengan durasi SweetAlert ditampilkan
}



    </script>
</body>
</html>
