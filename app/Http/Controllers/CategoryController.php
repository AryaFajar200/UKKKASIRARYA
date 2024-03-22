<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }
    public function AddCategoryPage(){
        return view('AdminPage.category.category-create');
    }
    public function ProsesTambah(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255'
        ]);

        $categories = Category::create([
            'category_name' => $request->input('category_name'),
        ]);

        return redirect()->route('category')->with('success', 'Category data added successfully!');
    }

    public function EditCategoryPage($id){
        $categories = Category::find($id);
        return view('AdminPage.category.category-form', compact('categories'));
    }

    public function ProsesUpdate(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255'
        ]);

        $categories = Category::find($id);

        $categories->category_name = $request->input('category_name');

        $categories->save();

        return redirect()->route('category')->with('success', 'Category data updated successfully!');
    }

    public function DeleteCategory($id){
        $menu = Category::find($id);
        $menu->delete();
        return back()->with('success','Data berhasil dihapus!');
    }
    // Fungsi-fungsi lainnya seperti create, store, edit, update, destroy, dll.
}
