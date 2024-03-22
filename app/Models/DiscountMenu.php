<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountMenu extends Model
{
    use HasFactory;

    protected $table = 'discount_menus';
    public $timestamps = false;



    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

    public function menu()
    {
        return $this->belongsTo(menu::class, 'menu_id');
    }

    
}