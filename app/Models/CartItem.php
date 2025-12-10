<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $table = 'cart_items';

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
    ];

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke product
     */
=======
    protected $fillable = [
        'cart_id',
        'product_id',
        'qty',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

>>>>>>> b767d72ace30c1e275eb6ee93cda34db91678434
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
