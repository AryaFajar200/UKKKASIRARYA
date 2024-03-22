<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = ['menu_id', 'transaction_id', 'qty', 'price', 'discount_rate'];
    protected $table = "transaction_detail";

    public $timestamps = false;


    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function discountmenu()
    {
        return $this->belongsTo(discountmenu::class, 'menu_id', 'discount_id');
    }


    public function menu()
    {
        return $this->belongsTo(menu::class, 'menu_id');
    }
}