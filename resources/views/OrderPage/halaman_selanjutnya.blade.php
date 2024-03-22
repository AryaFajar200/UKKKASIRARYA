<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Selanjutnya</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])

</head>
<body>
    <nav class="bg-[#0c4e68] py-4">
        <div class="container mx-auto">
            <h1 class="text-white text-2xl font-bold ml-3">RAMEN XYZ</h1>
        </div>
    </nav>
    <div class="container mx-auto mt-8">
        <a href="{{ route('pelangganpesan') }}" class="text-blue-500 mb-4 inline-block">&larr; Kembali</a>

        @if($order_type !== 'takeaway')
        <h1 class="text-2xl font-semibold mb-4">Masukkan Nomor Meja</h1>
        @endif
        <form action="{{ route('store-no-table') }}" method="post">
            @csrf
            <input type="hidden" name="order_type" value="{{ $order_type }}">
            <!-- Tampilkan input nomor meja hanya jika order_type bukan "takeaway" -->
            @if($order_type !== 'takeaway')
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="no_table">Nomor Meja:</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="no_table" type="number" name="no_table" placeholder="Masukkan nomor meja">
                </div>
            @endif
            <div class="flex justify-center">
                <button type="submit" class="bg-[#0c4e68]  hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Lanjutkan ke Order</button>
            </div>
        </form>
    </div>
</body>
</html>
