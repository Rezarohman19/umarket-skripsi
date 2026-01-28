<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'description',
        'price',
        'stock',
        'image',
        'user_id', // penjual
    ];

    protected $with = ['category'];
    protected $appends = ['image_url'];

    // Relasi ke user (penjual)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke item keranjang
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // Relasi ke item transaksi
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    // URL gambar
    public function getImageUrlAttribute()
    {
        return $this->image ? \Illuminate\Support\Facades\Storage::url($this->image) : null;
    }
}
