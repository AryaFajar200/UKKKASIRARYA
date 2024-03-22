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
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold text-center mb-4">Pesanan Anda Berhasil</h1>
        <p class="text-lg text-center mb-6">Silakan lanjutkan pembayaran di kasir atau panggil salah satu staff kami.</p>
        <p class="text-lg text-center mb-6">Order Lagi?</p>
        <div class="flex justify-center mb-8">
            <!-- Button to navigate to the pelangganpesan route -->
            <button class="w-full md:w-auto bg-[#0c4e68] text-white rounded-full px-8 py-3 focus:outline-none" onclick="window.location='{{ route('pelangganpesan') }}'">
                Kembali ke Awal
            </button>
            
        </div>
    </div>
</body>
</html>
