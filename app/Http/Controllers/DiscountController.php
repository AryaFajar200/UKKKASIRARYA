<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
class DiscountController extends Controller
{

    public function index()
    {
        $today = new DateTime();
        $today->setTime(0, 0, 0);

        $discounts = Discount::all();

        // foreach ($discounts as $diskon) {
        //     $startDate = new DateTime($diskon->start_date);
        //     $startDate->setTime(0, 0, 0);
        //     $endDate = new DateTime($diskon->end_date);
        //     $endDate->setTime(0, 0, 0);

        //     if ($endDate < $today) {
        //         $diskon->status = 'Tidak Berlaku'; // Adjusted for ENUM value
        //     } elseif ($startDate > $today) {
        //         $diskon->status = 'Akan Berlaku'; // Adjusted for ENUM value
        //     } else {
        //         $diskon->status = 'Masih Berlaku'; // Adjusted for ENUM value
        //     }

        //     $diskon->save();
        // }

        $data = Discount::paginate(10);
        return view('Discount.discount', compact('data'));
    }

    public function AddDiscountPage(){
        return view('Discount.discount-create');
    }

    public function ProsesTambah(Request $request)
    {
        $request->validate([
            'discount_name' => 'required|string|max:255',
            'discount_rate' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        Discount::create([
            'discount_name' => $request->input('discount_name'),
            'discount_rate' => $request->input('discount_rate'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);

        return redirect()->route('discount')->with('success', 'menu data added successfully!');
    }

    public function EditDiscountPage($id){
        $discount = Discount::find($id);
        return view('Discount.discount-form', compact('discount'));
    }

    public function ProsesUpdate(Request $request, $id)
    {
        $request->validate([
            'discount_name' => 'required|string|max:255',
            'discount_rate' => 'required|numeric',
            'start_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($id, $request) {
                    // Check if the tanggal_mulai is unique and not overlapping with existing date ranges
                    $overlapping = Discount::where('id', '!=', $id) // Ignore the current record
                        ->where(function ($query) use ($value, $request) {
                            $query->where(function ($q) use ($value, $request) {
                                $q->where('start_date', '<=', $value)
                                  ->where('end_date', '>=', $value);
                            })->orWhere(function ($q) use ($value, $request) {
                                $q->where('start_date', '<=', $request->input('end_date'))
                                  ->where('end_date', '>=', $request->input('end_date'));
                            });
                        })->exists();

                    if ($overlapping) {
                        $fail('The ' . $attribute . ' overlaps with another discount period.');
                    }
                },
            ],
            'end_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($id, $request) {
                    // Check if the tanggal_akhir is unique and not overlapping with existing date ranges
                    $overlapping = Discount::where('id', '!=', $id) // Ignore the current record
                        ->where(function ($query) use ($value, $request) {
                            $query->where(function ($q) use ($value, $request) {
                                $q->where('start_date', '<=', $value)
                                  ->where('end_date', '>=', $value);
                            })->orWhere(function ($q) use ($value, $request) {
                                $q->where('start_date', '<=', $request->input('start_date'))
                                  ->where('end_date', '>=', $request->input('start_date'));
                            });
                        })->exists();

                    if ($overlapping) {
                        $fail('The ' . $attribute . ' overlaps with another discount period.');
                    }
                },
                'after:start_date',
            ],
        ]);

        $menu = Discount::find($id);

        if (!$menu) {
            return redirect()->route('discount')->with('error', 'Discount data not found!');
        }

        $menu->discount_name = $request->input('discount_name');
        $menu->discount_rate = $request->input('discount_rate');
        $menu->start_date = $request->input('start_date');
        $menu->end_date = $request->input('end_date');
        $menu->save();

        return redirect()->route('discount')->with('success', 'Discount data updated successfully!');
    }

    public function DeleteDiscount($id){
        $diskon = Discount::find($id);
        $diskon->delete();
        return back()->with('success','Data berhasil dihapus!');
    }
}