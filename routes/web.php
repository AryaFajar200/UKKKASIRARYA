<?php

use App\Models\Menu;
use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\DiscountMenu;
use App\Models\DiscountDetail;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DetailDiscountController;
use App\Http\Controllers\TransactionDetailController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/pesan', function () {
    return view('OrderPage.home_order');
})->name('pelangganpesan');

Route::get('/menu', function ()  {
    if (Auth::check() && Auth::user()->role == 'admin') {
    $menu = menu::paginate(10);
    return view('menu.menu', compact('menu'));
}


})->middleware(['auth', 'verified'])->name('menu');



Route::get('/datatransaksi', [TransactionController::class, 'indextransaction'])->name('datatransaksi');


Route::get('/category', function ()  {
    if (Auth::check() && Auth::user()->role == 'admin') {
        $category = Category::paginate(10);
        return view('AdminPage.category.category', compact('category'));
    }
})->middleware(['auth', 'verified'])->name('category');

Route::get('/karyawan', function () {
    return view('Karyawan.karyawan');
})->middleware(['auth', 'verified'])->name('user');

Route::get('/transaction', function () {
    return view('Kasir.transaction');
})->middleware(['auth', 'verified'])->name('transaction');


Route::get('/pesanpelanggan', function () {
    return view('OrderPage.halamanPesanPelanggan');
})->name('halaman-order');

Route::get('/users', function () {
    if (Auth::check() && Auth::user()->role == 'admin') {
        $data = User::all();
        return view('users.users', compact("data"));
    }
    return redirect('/transaction')->with('error', 'You are not authorized to view this page.');
})->middleware(['auth', 'verified'])->name('users');
Route::get('/discount-menu', function () {
    $data = DiscountMenu::with(['discount', 'menu'])
        ->get()
        ->groupBy('discount_id')
        ->map(function ($group) {
            return [
                'id' => $group->first()->discount_id,
                'discount_name' => $group->first()->discount->discount_name,
                'menus' => $group->pluck('menu.menu_name')->join(', '),
            ];
        });

    return view('Discount.detail-discount.discount-detail', compact('data'));
})->middleware(['auth', 'verified'])->name('discountdetail');


Route::get('/transaction', [TransactionController::class, 'index']) ->name('transaction');
Route::get('/detail-menu/{id}', [MenuController::class, 'show'])->name('menu.detail');

Route::get('/pesanpelanggan', [TransactionController::class, 'index2']) ->name('halaman-order');

    Route::get('/detail-transaction', [TransactionDetailController::class, 'showTransactions'])
    ->middleware(['auth', 'verified'])
    ->name('detail');

Route::get('/discount', [DiscountController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('discount');

        Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
        Route::post('/kasir/add-to-cart', [KasirController::class, 'addToCart'])->name('kasir.addToCart');
        Route::delete('/kasir/remove-from-cart/{id}', [KasirController::class, 'removeFromCart'])->name('kasir.removeFromCart');
        Route::post('/kasir/checkout', [KasirController::class, 'checkout'])->name('kasir.checkout');
   
        Route::post('/pesan/store', [TransactionController::class, 'store2'])->name('proses-transaction2');

        Route::post('/transaction/store', [TransactionController::class, 'store'])->name('proses-transaction');
        Route::get('/search-barang-transaction', [TransactionController::class, 'search'])->name('search-barang-transaction');

Route::get('/menu/create', [MenuController::class, 'AddMenuPage'])->name('add-menu-page');
Route::post('/menu/store', [MenuController::class, 'ProsesTambah'])->name('menu-store');
Route::get('/form-edit-menu/{id}', [MenuController::class, 'EditMenuPage'])->name('edit-menu');
Route::post('/proses-edit-menu/{id}', [MenuController::class, 'ProsesUpdate'])->name('proses-edit-menu');
Route::post('/delete-menu/{id}', [MenuController::class, 'DeleteMenu'])->name('delete-menu');
Route::get('/search-menu', [menuController::class, 'search'])->name('search-menu');

Route::get('/form-add-detail-diskon', [DetailDiscountController::class, 'AddDetailDiscountPage'])->name('add-detail-discount-page');
Route::post('/proses-tambah-detail-discount', [DetailDiscountController::class, 'ProsesTambah'])->name('proses-tambah-detail-discount');
Route::get('/form-edit-detail-discount/{id}', [DetailDiscountController::class, 'EditDetaildiscountPage'])->name('edit-detail-discount');
Route::post('/proses-edit-detail-discount/{id}', [DetailDiscountController::class, 'ProsesUpdate'])->name('proses-edit-detail-discount');
Route::post('/delete-detail-discount/{id}', [DetailDiscountController::class, 'DeleteDetaildiscount'])->name('delete-detail-discount');

Route::get('/discount/create', [DiscountController::class, 'AddDiscountPage'])->name('add-discount-page');
Route::post('/discount/store', [DiscountController::class, 'ProsesTambah'])->name('discount-store');
Route::get('/form-edit-discount/{id}', [DiscountController::class, 'EditDiscountPage'])->name('edit-discount');
Route::post('/proses-edit-discount/{id}', [DiscountController::class, 'ProsesUpdate'])->name('proses-edit-discount');
Route::post('/delete-discount/{id}', [DiscountController::class, 'DeleteDiscount'])->name('delete-discount');
Route::get('/admin/discount-detail/{id}', [DiscountController::class, 'showDiscountDetail'])->name('discount.detail');
Route::get('/admin/add-discount-menu', [DiscountController::class, 'addmenu'])->name('add.discount-menu');
Route::post('/admin/add-discount-menu/{discountId}', [DiscountController::class, 'addmenu'])->name('add.discount-menu');

Route::get('/category/create', [CategoryController::class, 'AddCategoryPage'])->name('add-category-page');
Route::post('/category/store', [CategoryController::class, 'ProsesTambah'])->name('category-store');
Route::get('/form-edit-category/{id}', [CategoryController::class, 'EditCategoryPage'])->name('edit-category');
Route::post('/proses-edit-category/{id}', [CategoryController::class, 'ProsesUpdate'])->name('proses-edit-category');
Route::post('/delete-category/{id}', [CategoryController::class, 'DeleteCategory'])->name('delete-category');


Route::post('/store-order-type', [TransactionController::class, 'storeOrderType'])->name('store-order-type');
Route::post('/store-no-table', [TransactionController::class, 'storeNoTable'])->name('store-no-table');
Route::get('/halaman-selanjutnya', [TransactionController::class, 'halamanSelanjutnya'])->name('halaman-selanjutnya');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('/cart', [CartController::class, 'cartindex'])->name('view-cart');
Route::post('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');

Route::get('/form-add-users', [UserController::class, 'AddUserPage'])->name('add-users-page');
Route::post('/proses-tambah-users', [UserController::class, 'ProsesTambah'])->name('proses-tambah-users');
Route::get('/form-edit-users/{id}', [UserController::class, 'EditUserPage'])->name('edit-users');
Route::post('/proses-edit-users/{id}', [UserController::class, 'ProsesUpdate'])->name('proses-edit-users');
Route::post('/delete-users/{id}', [UserController::class, 'DeleteUsers'])->name('delete-users');

Route::get('/search-users', [UserController::class, 'search'])->name('search-users');

Route::get('/pesanansukses', function ()  {

    return view('OrderPage.cart.halaman_suksesorder');
})->name('pesanansukses');

Route::get('transaction/{transaction_id}/detail', [TransactionDetailController::class, 'show'])
->name('transaction-detail');

Route::get('transaction/{transaction_id}/edit', [TransactionController::class, 'edit'])->name('transaction.edit');
Route::put('transaction/{transaction_id}', [TransactionController::class, 'update'])->name('transaction.update');

Route::get('/download-pdf', [TransactionController::class, 'downloadPdf'])->name('download-pdf');
Route::get('/detail-transaction', [TransactionDetailController::class, 'showTransactions'])
    ->middleware(['auth', 'verified'])
    ->name('detail');
require __DIR__.'/auth.php';
