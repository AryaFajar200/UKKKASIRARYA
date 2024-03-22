<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;


class MenuController extends Controller
{

    public function search(Request $request)
    {
        $search = $request->query('search');

        if (!empty($search)) {
            $menu= menu::where('menu_name', 'LIKE', "%{$search}%")
                        ->orWhereHas('category', function ($query) use ($search) {
                            $query->where('category_name', 'LIKE', "%{$search}%");
                        })
                        ->paginate(10);
        } else {
            $menu= menu::with('category')->paginate(10);
        }

        return view('menu.menu', compact('menu'));
    }
    public function index() {
        $data = Menu::with('category')->get();
        return view('dashboard', compact('data'));
    }

    public function show($id)
{
    // Mengambil data menu berdasarkan ID dengan informasi diskon yang berlaku pada tanggal saat ini
    $currentDate = date('Y-m-d');
    $menu = Menu::findOrFail($id);

    // Mengambil semua diskon yang berlaku untuk menu ini pada tanggal saat ini
    $applicableDiscounts = $menu->discount()->where('start_date', '<=', $currentDate)
                                           ->where('end_date', '>=', $currentDate)
                                           ->get();

    // Jika ada diskon yang berlaku, hitung harga diskon
    if ($applicableDiscounts->isNotEmpty()) {
        // Ambil diskon pertama (asumsi hanya ada satu diskon yang berlaku)
        $applicableDiscount = $applicableDiscounts->first();
        $discount_rate = rtrim($applicableDiscount->discount_rate, '%');
        $discount_rate = (float)$discount_rate / 100;
        $menu->discount_price = $menu->price - ($menu->price * $discount_rate);
    } else {
        $menu->discount_price = $menu->price;
    }

    // Mengembalikan view halaman detail menu dengan data menu yang dipilih
    return view('OrderPage.halaman_detailmenu', compact('menu'));
}


    public function AddMenuPage(){
        $categories = Category::all();
         // Mengambil semua kategori dari basis data
       return view('menu.create',  ['categories' => $categories]);
    }

    public function ProsesTambah(Request $request)
    {
        
        $request->validate([
            'menu_name' => 'required|string|max:255',
            'menu_image' => 'image|mimes:png,jpg,jpeg,webp',
            'price' => 'required',
            'stock' => 'required|in:tersedia,habis',
            'description' => 'required|string|max:255',
            'category_id' => 'required'
        ]);

        $imagePath = null;
        if ($request->hasFile('menu_image')) {
            $imageVarchar = $request->file('menu_image');
            $fileName = time() . '_' . $imageVarchar->getClientOriginalName();

            $imageVarchar->storeAs('public/images', $fileName);

            $imagePath = request()->getSchemeAndHttpHost() . '/storage/images/' . $fileName;
        }

        Menu::create([
        'menu_name' => $request->input('menu_name'),
        'stock' => $request->input('stock'),
        'menu_image' => $imagePath,
        'price' => $request->input('price'),
        'description' => $request->input('description'),
        'category_id' => $request->input('category_id') // Pastikan memberikan nilai category_id

        ]);


        return redirect()->route('menu')->with('success', 'Data Added Successfully')->with('status', 'added');
    }

    public function EditMenuPage($id){
        $categories = Category::all();
        $menu = menu::find($id);
        return view('menu.menu-form', compact('categories', 'menu'));
    }

    public function ProsesUpdate(Request $request, $id)
    {
        $request->validate([
            'menu_name' => 'required|string|max:255',
            'menu_image' => 'sometimes|image|mimes:png,jpg,jpeg',
            'price' => 'required',
            'stock' => 'required|in:tersedia,habis',
            'description' => 'required|string|max:255',
            'category_id' => 'required'
        ]);

        $menu = menu::find($id);

        if ($request->hasFile('menu_image')) {
            $menu_image = $request->file('menu_image');
            $fileName = time() . '_' . $menu_image->getClientOriginalName();
            $menu_image->storeAs('public/images', $fileName);
            $imagePath = request()->getSchemeAndHttpHost() . '/storage/images/' . $fileName;
            $menu->menu_image = $imagePath;
        }

        $menu->menu_name = $request->input('menu_name');
        $menu->stock = $request->input('stock');
        $menu->price = $request->input('price');
        $menu->description = $request->input('description');
        $menu->category_id = $request->input('category_id'); 
        $menu->save();// Pastikan memberikan nilai category_id

       

        return redirect()->route('menu')->with('success', 'Data Updated Successfully')->with('status', 'updated');
    }

    public function DeleteMenu($id)
    {
        $menu = menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menu')->with('success', 'Data deleted successfully!');
    }

}