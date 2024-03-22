<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // Ambil data menu berdasarkan ID
        $menu = Menu::findOrFail($request->menu_id);
    
        // Hitung harga diskon jika ada
        $discountPrice = $menu->price; // Harga awal jika tidak ada diskon
        $applicableDiscount = $menu->findApplicableDiscount(); // Cari diskon yang berlaku
        if ($applicableDiscount) {
            $discountRate = (float) rtrim($applicableDiscount->discount_rate, '%') / 100;
            $discountPrice -= $menu->price * $discountRate; // Harga setelah diskon
        }
    
        // Tambahkan item ke keranjang
        $cart = session()->get('cart', []);
        $cart[$menu->id] = [
            'menu_id' => $menu->id,
            'menu_name' => $menu->menu_name,
            'price' => $discountPrice, // Gunakan harga diskon jika tersedia
            'qty' => $request->qty,
        ];
        session()->put('cart', $cart);
    
        return redirect()->route('halaman-order')->with('success', 'Menu berhasil ditambahkan ke keranjang.');
    }
    
    public function cartindex()
        {
            // Ambil data keranjang dari session
            $cartItems = session('cart', []);
    
            $totalPrice = 0;
        foreach ($cartItems as $item) {
            $menu = Menu::find($item['menu_id']);
            $item['id'] = $menu->id; // Tambahkan id ke setiap item    
            $totalPrice += $item['price'] * $item['qty'];
        }
    
    
            // Tampilkan view cart dengan data keranjang
            return view('OrderPage.cart.view_cart', [
                'cartItems' => $cartItems,
                'totalPrice' => $totalPrice,
            ]);
        }

        public function removeItem($id)
{
    // Ambil data keranjang dari session
    $cart = session('cart', []);

    // Hapus item dengan ID yang sesuai dari data keranjang
    unset($cart[$id]);

    // Simpan kembali data keranjang yang telah diupdate ke session
    session(['cart' => $cart]);

    // Redirect kembali ke halaman keranjang dengan pesan sukses
    return redirect()->route('view-cart')->with('success', 'Item berhasil dihapus dari keranjang.');
}

    
}
