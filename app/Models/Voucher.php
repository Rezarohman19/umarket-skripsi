<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_purchase',
        'max_discount',
        'usage_limit',
        'used_count',
        'per_user_limit',
        'is_active',
        'starts_at',
        'expires_at',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Check if this voucher is currently valid
     */
    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        if ($this->starts_at && now()->lt($this->starts_at)) return false;
        if ($this->expires_at && now()->gt($this->expires_at)) return false;
        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) return false;
        return true;
    }

    /**
     * Check if a specific user can use this voucher
     */
    public function canBeUsedBy(int $userId): bool
    {
        if (!$this->isValid()) return false;

        $userUsageCount = VoucherUsage::where('voucher_id', $this->id)
            ->where('user_id', $userId)
            ->count();

        return $userUsageCount < $this->per_user_limit;
    }

    /**
     * Calculate the discount amount for a given subtotal
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($subtotal < $this->min_purchase) return 0;

        if ($this->type === 'percentage') {
            $discount = $subtotal * ($this->value / 100);
            if ($this->max_discount !== null) {
                $discount = min($discount, $this->max_discount);
            }
            return round($discount, 2);
        }

        // Fixed discount
        return min($this->value, $subtotal);
    }

    /**
     * Record a usage of this voucher
     */
    public function recordUsage(int $userId, int $transactionId, float $discountAmount): void
    {
        VoucherUsage::create([
            'voucher_id' => $this->id,
            'user_id' => $userId,
            'transaction_id' => $transactionId,
            'discount_amount' => $discountAmount,
        ]);
        $this->increment('used_count');
    }

    public function usages()
    {
        return $this->hasMany(VoucherUsage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
