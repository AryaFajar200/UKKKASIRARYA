<?php

namespace App\Http\Controllers;

use App\Models\menu;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\DetailTransaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session; // Tambahkan impor untuk kelas Session
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class TransactionController extends Controller
{

    public function index(Request $request) {
        $currentDate = date('Y-m-d');
    
        // Mengambil semua data menu dengan 'eager loading' untuk diskon yang berlaku pada tanggal saat ini
        $menuData = menu::with(['discount' => function ($query) use ($currentDate) {
            $query->where('start_date', '<=', $currentDate)
                  ->where('end_date', '>=', $currentDate);
        }])->get();
    
        // Iterasi melalui setiap data menu untuk menghitung harga diskon jika ada
        foreach ($menuData as $menu) {
            // Inisialisasi harga_diskon dengan harga asli menu
            $menu->discount_price = $menu->price;
    
            // Mencari diskon yang berlaku untuk menu tertentu
            $applicableDiscount = $menu->findApplicableDiscount();
    
            // Memeriksa apakah ada diskon yang berlaku
            if ($applicableDiscount) {
                // Menghapus simbol '%' dari persentase diskon dan konversi ke nilai numerik
                $discount_rate = rtrim($applicableDiscount->discount_rate, '%');
                $discount_rate = (float)$discount_rate / 100; // Mengubah persentase menjadi pecahan
    
                // Menghitung harga setelah diskon dan memperbarui discount_price pada menu
                $menu->discount_price -= $menu->price * $discount_rate;
            }
        }
    
        // Mengembalikan view 'CRUD.transaction' dengan data menu yang sudah diolah
        return view('kasir.transaction', compact('menuData'));
    }


    public function indextransaction() {
        // Ambil data transaksi berdasarkan peran pengguna
        if (Auth::check() && Auth::user()->role === 'admin') {
            $transaction = Transaction::with('user')
                ->where('payment_status', 'sudah dibayar')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $transaction = Transaction::with('user')
                ->orderBy('id', 'desc')
                ->get();
        }
    
        return view('Transaction.transaction', compact('transaction'));
    }
    
    
    
    public function index2(Request $request) {
        $currentDate = date('Y-m-d');
    
        // Mengambil semua data menu dengan 'eager loading' untuk diskon yang berlaku pada tanggal saat ini
        $menuData = menu::with(['discount' => function ($query) use ($currentDate) {
            $query->where('start_date', '<=', $currentDate)
                  ->where('end_date', '>=', $currentDate);
        }])->get();
    
        // Iterasi melalui setiap data menu untuk menghitung harga diskon jika ada
        foreach ($menuData as $menu) {
            // Inisialisasi harga_diskon dengan harga asli menu
            $menu->discount_price = $menu->price;
    
            // Mencari diskon yang berlaku untuk menu tertentu
            $applicableDiscount = $menu->findApplicableDiscount();
    
            // Memeriksa apakah ada diskon yang berlaku
            if ($applicableDiscount) {
                // Menghapus simbol '%' dari persentase diskon dan konversi ke nilai numerik
                $discount_rate = rtrim($applicableDiscount->discount_rate, '%');
                $discount_rate = (float)$discount_rate / 100; // Mengubah persentase menjadi pecahan
    
                // Menghitung harga setelah diskon dan memperbarui discount_price pada menu
                $menu->discount_price -= $menu->price * $discount_rate;
            }
        }
    
        // Mengembalikan view 'CRUD.transaction' dengan data menu yang sudah diolah
        return view('OrderPage.halamanPesanPelanggan', compact('menuData'));
    }
    
    
    
    public function store(Request $request)
{
    $items = json_decode($request->items, true);



    $transaction = Transaction::create([
        'user_id' => Auth::id(),
        'order_date' => now(),
        'no_table' => $request->no_table,
        'order_type' => $request->order_type,
        'payment_type' => $request->payment_type,
        'payment_status' => $request->payment_status,
        'total_price' => $request->total_price,
        'cash' => $request->cash,
        'bonus_discount' => $request->bonus_discount,
    ]);

   
        // Lakukan iterasi jika $items tidak kosong
        foreach ($items as $item) {
            $discount_rate = isset($item['discount_rate']) ? $item['discount_rate'] : 0;

            // Periksa apakah menu memiliki diskon, jika ada, gunakan harga diskon, jika tidak, gunakan harga asli
            $menu = Menu::find($item['id']);
            $price = isset($menu->discount_price) && $menu->discount_price != $menu->price ? $menu->discount_price : $menu->price;
    
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'menu_id' => $item['id'],
                'qty' => $item['qty'],
                'price' => $price, // Gunakan harga yang belum terkena diskon
                'discount_rate' => $item['discount_rate'], // Insert the discount rate into the transaction detail record
            ]);
        }
  
    

    return redirect()->route('transaction')->with('success', 'Transaction successful!');
}

public function storeOrderType(Request $request)
{
    $orderType = $request->input('order_type');
    Session::put('order_type', $orderType);

    return redirect()->route('halaman-selanjutnya');
}

public function storeNoTable(Request $request)
    {
        $orderType = $request->input('order_type');
        $noTable = $orderType === 'takeaway' ? null : $request->input('no_table');

        Session::put('order_type', $orderType);
        Session::put('no_table', $noTable);

        return redirect()->route('halaman-order');
    }

public function halamanSelanjutnya()
{
    $orderType = Session::get('order_type');

    return view('OrderPage.halaman_selanjutnya')->with('order_type', $orderType);
}
    public function store2(Request $request)
    {
        $items = json_decode($request->items, true);
    

        


        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'order_date' => now(),
            'no_table' => $request->no_table,
            'order_type' => $request->order_type,
            'payment_type' => $request->payment_type,
            'payment_status' => $request->payment_status,
            'total_price' => $request->total_price,
            'cash' => $request->cash,
            'bonus_discount' => $request->bonus_discount,
        ]);

    
            // Lakukan iterasi jika $items tidak kosong
            foreach ($items as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'menu_id' => $item['menu_id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    
                ]);
            }
    
            session()->forget('cart');


        return redirect()->route('pesanansukses')->with('success', 'Transaction successful!');
    }

 // if ($menu) {
            //     $menu->decrement('stok', $item['quantity']);
            // }
            public function search(Request $request)
            {
                $search = $request->query('search');
            
                if (!empty($search)) {
                    $menuData = menu::where('menu_name', 'LIKE', "%{$search}%")
                                ->orWhere('discount_price', 'LIKE', "%{$search}%")
                                ->get();
                } else {
                    $menuData = menu::all();
                }
            
                return view('kasir.transaction', compact('menuData'));
            }
            
            public function edit($transaction_id)
{
    $transaction = Transaction::findOrFail($transaction_id);
    return view('Transaction.transaction-form', compact('transaction'));
}

public function update(Request $request, $transaction_id)
{
    $transaction = Transaction::findOrFail($transaction_id);

    $request->validate([
        'payment_status' => 'required',
        'cash' => 'required|numeric',
    ]);


    $transaction->payment_status = $request->payment_status;
    $transaction->cash = $request->cash;
    
    $transaction->user_id = Auth::id();
    
    $transaction->save();
    
    return redirect()->route('datatransaksi', ['transaction_id' => $transaction->id]);
}

public function downloadPdf()
    {

        $data = TransactionDetail::with(['transaction.user', 'menu'])->get();

        $pdf = Pdf::loadView('Transaction.transaction-pdf', compact('data'));

        return $pdf->download('laporan-penjualan.pdf');
    }

}
        

        

        

        