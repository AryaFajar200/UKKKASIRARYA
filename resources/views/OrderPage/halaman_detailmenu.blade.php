<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="bg-[#0c4e68] py-10">
        <div class="container mx-auto">
            <div class="max-w-4xl mx-auto text-center text-white">
                <img src="{{ $menu->menu_image }}" alt="{{ $menu->menu_name }}" class="object-cover w-full h-64 mb-8 rounded-lg shadow-lg">
                <h1 class="text-4xl font-bold">{{ $menu->menu_name }}</h1>
                <p class="text-lg mt-4">{{ $menu->description }}</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto mt-8 px-4">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden p-6">
            @if (isset($menu->discount_price) && $menu->discount_price != $menu->price)
                <p class="text-xl font-semibold text-red-600">Harga Diskon: Rp {{ number_format($menu->discount_price) }}</p>
                <p class="text-sm text-green-600 line-through">Harga Asli: Rp {{ number_format($menu->price) }}</p>
            @else
                <p class="text-xl font-semibold text-green-600">Harga: Rp {{ number_format($menu->price) }}</p>
            @endif
            <form action="{{ route('add-to-cart') }}" method="post">
                @csrf
                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                <input type="hidden" name="price" value="{{ isset($menu->discount_price) && $menu->discount_price != $menu->price ? $menu->discount_price : $menu->price }}">
                <input type="number" name="qty" value="1" min="1" class="w-16 border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:border-blue-500 mb-2">
                <button type="submit" class="block w-full bg-[#0c4e68] text-white font-bold py-2 rounded-md shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-opacity-50 transition duration-300">Tambahkan ke Keranjang</button>
            </form>
            
        </div>
    </div>
</body>
</html>
