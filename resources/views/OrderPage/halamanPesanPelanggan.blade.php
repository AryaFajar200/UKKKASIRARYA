<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Order</title>
    <script src="https://kit.fontawesome.com/e0d812d232.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])

</head>
<body class="bg-gray-100">
    <nav class="bg-[#0c4e68] py-4">
        <div class="container mx-auto">
            <h1 class="text-white text-2xl font-bold ml-3">RAMEN XYZ</h1>
        </div>
    </nav>
    <a href="{{ route('halaman-selanjutnya') }}" class="text-blue-500 inline-block px-4 mt-4">&larr; Kembali</a>

    <div class="container mx-auto mt-4 px-4">
        <h1 class="text-2xl font-semibold mb-4 text-center">Daftar Menu</h1>
        <div class="mb-4">
            <label for="kategori" class="mr-2">Category</label>
            <select id="kategori" class="rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="all">Semua</option>
                <option value="1">Ramen</option>
                <option value="2">Makanan Ringan</option>
                <option value="3">MINUMAN</option>
            </select>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4">
            @foreach($menuData as $menu)
            <div class="relative">
                @if ($menu->stock === 'habis')
                    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-75 text-white text-lg font-semibold cursor-not-allowed z-10">Sold Out</div>
                @endif
                <a @if ($menu->stock !== 'habis') href="{{ route('menu.detail', ['id' => $menu->id]) }}" @endif class="relative flex flex-col text-gray-700 bg-white shadow-md bg-clip-border rounded-xl hover:shadow-lg transition duration-300 menu-item" data-category="{{ $menu->category_id }}">
                    <div class="relative h-40 overflow-hidden bg-blue-gray-500 rounded-t-xl">
                        <img src="{{ $menu->menu_image }}" alt="{{ $menu->menu_name }}" class="object-cover w-full h-full" />
                    </div>
                    <div class="p-4">
                        <h5 class="text-lg font-semibold mb-2">{{ $menu->menu_name }}</h5>
                        @if (isset($menu->discount_price) && $menu->discount_price != $menu->price)
                            <p class="text-sm text-green-600 line-through">Rp {{ number_format($menu->price) }}</p>
                            <p class="text-sm text-red-600">Rp {{ number_format($menu->discount_price) }}</p>
                        @else
                            <p class="text-sm text-green-600">Rp {{ number_format($menu->price) }}</p>
                        @endif
                    </div>
                </a>
            </div>
        @endforeach
        
        
        
        </div>
    </div>


<div class="fixed bottom-4 right-4">
    <a href="{{ route('view-cart') }}" class="bg-[#0c4e68]  text-white rounded-full px-6 py-3 shadow-md hover:shadow-lg transition duration-300 flex items-center">
        <i class="fas fa-shopping-cart text-xl mr-2"></i>
        Keranjang
    </a>
</div>



    
    {{-- <div class="fixed bottom-16 left-4 bg-white p-4 shadow-md rounded-md">
        <p class="text-gray-700">Order Type: {{ session('order_type') }}</p>
        <p class="text-gray-700">No. Meja: {{ session('no_table') }}</p>
    </div> --}}
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
            const kategoriDropdown = document.getElementById('kategori');
            const menuItemsContainer = document.getElementById('menuItems');

            // Ketika nilai dropdown berubah, filter menu berdasarkan kategori
            kategoriDropdown.addEventListener('change', function() {
                const selectedCategory = this.value;
                filterMenu(selectedCategory);
            });

            // Fungsi untuk melakukan filter menu
            function filterMenu(category) {
                const menuItems = document.querySelectorAll('.menu-item');


                menuItems.forEach(item => {
                    const itemCategory = item.getAttribute('data-category');

                    if (category === 'all' || itemCategory === category) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }
        });
</script>
</html>
