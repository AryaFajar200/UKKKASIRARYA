<?php

namespace App\Http\Controllers;

use App\Models\menu;
use App\Models\Discount;
use App\Models\DiscountDetail;
use App\Models\DiscountMenu;
use Illuminate\Http\Request;

class DetailDiscountController extends Controller
{

    public function AddDetailDiscountPage(){
        $discount = Discount::all();
        $menu = menu::all();
            // Fetch all diskon IDs that are already used in DetailDiskon
        $usedDiscountIds = DiscountMenu::pluck('discount_id')->all();
        return view('Discount.detail-discount.detail-discount-create', compact('menu', 'discount', 'usedDiscountIds'));
    }
    public function EditDetailDiscountPage($id){
        $discount = Discount::find($id);
        $menu = menu::all();
        return view('Discount.detail-discount.detail-discount-form', compact('menu', 'discount'));
    }

    public function ProsesTambah(Request $request)
    {
        $request->validate([
            'discount_id' => 'required',
            'menu_id' => 'required|array',
        ]);
    
        $discount = Discount::findOrFail($request->discount_id);

        $discount->menus()->sync($request->menu_id);

        return redirect()->route('discountdetail')->with('success', 'discoun$discount updated successfully with new genres.');
    
    }
    




    public function ProsesUpdate(Request $request, $id)
{
    try {
        $discount = Discount::findOrFail($id);

        $discount->menus()->sync($request->menus);

        return redirect()->route('discountdetail')->with('success', 'Discount menus updated successfully.');
    } catch (\Exception $e) {
        // Log the error for debugging purposes
        \Log::error('Error updating discount menus: ' . $e->getMessage());

        // Redirect back with error message
        return redirect()->back()->with('error', 'Failed to update discount menus. Please try again.');
    }
}

    public function DeleteDetailDiskon($id)
    {
        $diskon = Discount::findOrFail($id);

        $diskon->menus()->detach();

        return redirect()->route('discountdetail')->with('success', 'Diskon deleted successfully.');
    }
}