<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // protected $fillable = ['id_users', 'tanggal_transaksi'];
    // public $incrementing = true;
    protected $table = "transaction";
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function transactionsDetail()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }

        public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}