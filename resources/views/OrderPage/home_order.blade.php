<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Awal</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Tambahkan CSS Swiper -->
    @vite(['resources/css/app.css','resources/js/app.js'])

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <style>
        /* Tambahkan styling khusus untuk gambar pada carousel */
        .swiper-slide img {
            width: 100%;
            height: 300px; /* Menjadikan tinggi gambar mengikuti proporsi lebar */
            object-fit: cover; /* Mengatur gambar agar terisi secara proporsional */
        }
    </style>
</head>
<body>
    <nav class="bg-[#0c4e68] py-4">
        <div class="container mx-auto">
            <h1 class="text-white text-2xl font-bold ml-3">RAMEN XYZ</h1>
        </div>
    </nav>

    <!-- Tambahkan container untuk carousel -->
    <div class="container mx-auto mt-8">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <!-- Isi dengan gambar-gambar untuk carousel -->
                <div class="swiper-slide"><img src="https://www.justonecookbook.com/wp-content/uploads/2023/04/Spicy-Shoyu-Ramen-8055-I-480x270.jpg" alt="Gambar 1" ></div>
                <div class="swiper-slide"><img src="https://cdn-2.tstatic.net/travel/foto/bank/images/promo-17-agustus-dari-gokana-ramen-teppan-senin-1682022.jpg" alt="Gambar 2"></div>
                <div class="swiper-slide"><img src="https://foto.kontan.co.id/ao7iWnbtsAaRkErD5VPSEuwh6KU=/smart/filters:format(webp)/2022/11/29/1277180576p.jpg" alt="Gambar 3"></div>
            </div>
        </div>
    </div>

    <div class="container mx-auto mt-8">
        <form action="{{ route('store-order-type') }}" method="post">
            @csrf
            <div class="flex justify-center">
                <button type="submit" class="bg-transparent hover:bg-[#0c4e68] text-black font-semibold hover:text-white py-2 px-4 border border-[#0c4e68] hover:border-transparent rounded mr-2" name="order_type" value="dine in">Dine In</button>
                <button type="submit" class="bg-transparent hover:bg-[#0c4e68] text-black font-semibold hover:text-white py-2 px-4 border border-[#0c4e68] hover:border-transparent rounded mr-2" name="order_type" value="takeaway">Takeaway</button>
            </div>
        </form>
    </div>

    <!-- Tambahkan library Swiper.js -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        // Inisialisasi Swiper
        var swiper = new Swiper('.swiper-container', {
            // Efek transisi slide
            effect: 'fade',
            // Durasi antara pergantian slide (dalam milidetik)
            autoplay: {
                delay: 2000, // 5 detik
            },
            // Looping untuk kembali ke slide pertama setelah mencapai slide terakhir
            loop: true,
        });
    </script>
</body>
</html>
