<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'destination_lat',
        'destination_lng',
        'payment_method',
        'tracking_number',
        'shipping_courier',
        'order_id',
        'voucher_code',
        'discount_amount',
    ];

    protected $casts = [
        'destination_lat' => 'decimal:7',
        'destination_lng' => 'decimal:7',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    /**
     * Kurangi stok produk untuk setiap item dalam transaksi ini.
     */
    public function reduceStock()
    {
        foreach ($this->items as $item) {
            $product = $item->product;
            if ($product) {
                $product->stock -= $item->qty;
                $product->save();
            }
        }
    }
}
