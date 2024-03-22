<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class KasirController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('kasir.index', compact('menus'));
    }

    public function addToCart(Request $request)
    {
        // Validasi request
        $request->validate([
            'menu_id' => 'required|exists:menu,id',
            'qty' => 'required|numeric|min:1'
        ]);

        // Tambahkan menu ke keranjang
        $menu = Menu::findOrFail($request->menu_id);
        $cart = session()->get('cart');
        
        // Jika keranjang kosong, buat keranjang baru
        if (!$cart) {
            $cart = [
                $request->menu_id => [
                    "name" => $menu->menu_name,
                    "qty" => $request->qty,
                    "price" => $menu->price
                ]
            ];
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Menu berhasil ditambahkan ke keranjang.');
        }

        // Jika menu sudah ada di keranjang, tambahkan jumlahnya
        if (isset($cart[$request->menu_id])) {
            $cart[$request->menu_id]['qty'] += $request->qty;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Jumlah menu berhasil diperbarui di keranjang.');
        }

        // Jika menu belum ada di keranjang, tambahkan baru
        $cart[$request->menu_id] = [
            "name" => $menu->menu_name,
            "qty" => $request->qty,
            "price" => $menu->price
        ];
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Menu berhasil ditambahkan ke keranjang.');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed from cart successfully.');
    }

    // public function checkout()
    // {
    //     // Simpan transaksi dan detailnya ke dalam database
    //     $cart = session()->get('cart');
    //     $transaction = new Transaction();
    //     $transaction->user_id = auth()->user()->id; // Anda mungkin perlu menyesuaikan ini sesuai dengan sistem otentikasi yang Anda gunakan
    //     $transaction->order_date = now();
    //     $transaction->no_table = '1'; // Contoh: di sini menetapkan nomor meja 1 secara statis
    //     $transaction->order_type = 'Dine-In'; // Contoh: menetapkan jenis pesanan sebagai Dine-In secara statis
    //     $transaction->payment_type = 'Cash'; // Contoh: menetapkan metode pembayaran sebagai Cash secara statis
    //     $transaction->payment_status = 'Paid'; // Contoh: menetapkan status pembayaran sebagai Paid secara statis
    //     $transaction->total_price = array_sum(array_column($cart, 'price')); // Menghitung total harga dari keranjang
    //     $transaction->cash = 0; // Contoh: menetapkan uang tunai yang diterima sebagai 0 secara statis
    //     $transaction->bonus_discount = 0; // Contoh: menetapkan diskon bonus sebagai 0 secara statis
    //     $transaction->save();

    //     foreach ($cart as $menu_id => $item) {
    //         $transactionDetail = new TransactionDetail();
    //         $transactionDetail->menu_id = $menu_id;
    //         $transactionDetail->transaction_id = $transaction->id;
    //         $transactionDetail->description = 'Ordered from cashier'; // Deskripsi opsional
    //         $transactionDetail->qty = $item['qty'];
    //         $transactionDetail->price = $item['price'];
    //         $transactionDetail->save();
    //     }

    //     session()->forget('cart'); // Kosongkan keranjang setelah transaksi selesai
    //     return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil. Terima kasih!');
    // }
}
