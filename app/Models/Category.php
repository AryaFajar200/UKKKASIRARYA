<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "menu_category"; // Sesuaikan dengan nama tabel Anda
    protected $primaryKey = 'id';
    public $timestamps = false;

    // Jika ada relasi antara Category dan Menu, Anda dapat mendefinisikannya di sini.
    // Misalnya, jika setiap kategori memiliki banyak menu:
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}

