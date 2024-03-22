<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "menu";
    protected $primaryKey = 'id';
    public $timestamps = false;

    public $discount_price;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function discount()
    {
        return $this->belongsToMany(Discount::class, 'discount_menus', 'menu_id', 'discount_id');
    }

    public function detailTransactions()
{
    return $this->hasMany(TransactionDetail::class, 'menu_id');
}


public function findApplicableDiscount() {
    $today = now()->toDateString();

    
    $applicableDiscount = $this->discount()
        ->where('start_date', '<=', $today)
        ->where('end_date', '>=', $today)
        ->orderBy('discount_rate', 'desc') // Urutkan berdasarkan persentase diskon tertinggi
        ->first();

    return $applicableDiscount;
}




}