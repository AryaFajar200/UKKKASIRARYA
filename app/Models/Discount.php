<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
     
    protected $guarded = ['id'];
    protected $table = "discount";

    protected $primarykey = 'id';
    public $timestamps = false;

    public function menus() {
        return $this->belongsToMany(Menu::class, 'discount_menus', 'discount_id', 'menu_id');
    }
}
