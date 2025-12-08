<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'user_id', // penjual
    ];

    // Relasi ke user (penjual)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke keranjang
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    // Relasi ke item transaksi
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
