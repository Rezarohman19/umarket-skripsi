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
        'image_2',
        'user_id', // penjual
    ];

    protected $with = ['category', 'productImages'];
    protected $appends = ['image_url', 'image_2_url', 'image_urls'];

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

    public function productImages()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    // URL gambar
    public function getImageUrlAttribute()
    {
        return $this->image ? \Illuminate\Support\Facades\Storage::url($this->image) : null;
    }

    public function getImage2UrlAttribute()
    {
        return $this->image_2 ? \Illuminate\Support\Facades\Storage::url($this->image_2) : null;
    }

    public function getImageUrlsAttribute()
    {
        $legacy = [
            $this->image ? \Illuminate\Support\Facades\Storage::url($this->image) : null,
            $this->image_2 ? \Illuminate\Support\Facades\Storage::url($this->image_2) : null,
        ];

        $gallery = $this->relationLoaded('productImages')
            ? $this->productImages->pluck('image_url')->all()
            : $this->productImages()->get()->pluck('image_url')->all();

        return collect(array_merge($legacy, $gallery))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
