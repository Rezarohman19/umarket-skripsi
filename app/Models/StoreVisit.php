<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreVisit extends Model
{
    protected $fillable = [
        'store_id',
        'ip_address',
        'visit_date',
    ];

    public function store()
    {
        return $this->belongsTo(User::class, 'store_id');
    }

    /**
     * Catat kunjungan ke toko dengan cooldown 1 menit per IP untuk mencegah spam reload.
     */
    public static function recordVisit($storeId, $request = null)
    {
        if (!$storeId) return null;

        $ip = $request instanceof \Illuminate\Http\Request ? $request->ip() : request()->ip();
        $ip = $ip ?: '127.0.0.1';

        // Cek cooldown 1 menit dari IP yang sama untuk toko yang sama
        $recent = static::where('store_id', $storeId)
            ->where('ip_address', $ip)
            ->where('created_at', '>=', now()->subMinute())
            ->first();

        if (!$recent) {
            return static::create([
                'store_id' => $storeId,
                'ip_address' => $ip,
                'visit_date' => now()->toDateString(),
            ]);
        }

        return $recent;
    }
}
