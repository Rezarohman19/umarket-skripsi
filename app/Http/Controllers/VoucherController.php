<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\VoucherUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    /**
     * Get all available (active, not expired) vouchers for display.
     */
    public function index()
    {
        $user = Auth::user();
        $vouchers = Voucher::with('user:id,name')
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->where(function ($q) {
                $q->whereNull('starts_at')
                  ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                  ->orWhereRaw('used_count < usage_limit');
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($v) use ($user) {
                return [
                    'id' => $v->id,
                    'code' => $v->code,
                    'name' => $v->name,
                    'description' => $v->description,
                    'type' => $v->type,
                    'value' => $v->value,
                    'min_purchase' => $v->min_purchase,
                    'max_discount' => $v->max_discount,
                    'seller_id' => $v->user_id,
                    'store_name' => $v->user?->name ?? 'Promo U-Market',
                    'expires_at' => $v->expires_at ? $v->expires_at->toDateTimeString() : null,
                    'can_use' => $user ? $v->canBeUsedBy($user->id) : false,
                ];
            });

        return response()->json($vouchers);
    }

    /**
     * Apply/validate a voucher code against a given subtotal.
     */
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $voucher = Voucher::where('code', strtoupper(trim($request->code)))->first();

        if (!$voucher) {
            return response()->json(['message' => 'Kode voucher tidak ditemukan'], 404);
        }

        if (!$voucher->isValid()) {
            return response()->json(['message' => 'Voucher sudah tidak berlaku atau habis'], 400);
        }

        if (!$voucher->canBeUsedBy($user->id)) {
            return response()->json(['message' => 'Anda sudah menggunakan voucher ini'], 400);
        }

        $subtotal = (float) $request->subtotal;
        if ($subtotal < $voucher->min_purchase) {
            return response()->json([
                'message' => 'Minimum pembelian Rp ' . number_format($voucher->min_purchase, 0, ',', '.') . ' untuk voucher ini',
            ], 400);
        }

        $discount = $voucher->calculateDiscount($subtotal);

        return response()->json([
            'voucher' => [
                'code' => $voucher->code,
                'name' => $voucher->name,
                'type' => $voucher->type,
                'value' => $voucher->value,
                'max_discount' => $voucher->max_discount,
                'seller_id' => $voucher->user_id,
                'store_name' => $voucher->user?->name ?? 'Promo U-Market',
            ],
            'discount_amount' => $discount,
            'final_price' => max(0, $subtotal - $discount),
        ]);
    }

    /**
     * Seller: Get all vouchers created by the authenticated seller.
     */
    public function sellerIndex()
    {
        $sellerId = Auth::id();
        $vouchers = Voucher::where('user_id', $sellerId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($vouchers);
    }

    /**
     * Seller: Create a new store voucher.
     */
    public function sellerStore(Request $request)
    {
        $sellerId = Auth::id();
        if (!$sellerId) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:vouchers,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:1',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
        ]);

        $voucher = Voucher::create([
            'user_id' => $sellerId,
            'code' => strtoupper(trim($validated['code'])),
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
            'value' => $validated['value'],
            'min_purchase' => $validated['min_purchase'] ?? 0,
            'max_discount' => $validated['max_discount'] ?? null,
            'usage_limit' => $validated['usage_limit'] ?? null,
            'per_user_limit' => $validated['per_user_limit'] ?? 1,
            'starts_at' => $validated['starts_at'] ?? now(),
            'expires_at' => $validated['expires_at'] ?? null,
            'is_active' => true,
        ]);

        return response()->json([
            'message' => 'Voucher toko berhasil dibuat!',
            'voucher' => $voucher,
        ], 201);
    }

    /**
     * Seller: Toggle active status of seller's voucher.
     */
    public function sellerToggle($id)
    {
        $sellerId = Auth::id();
        $voucher = Voucher::where('id', $id)->where('user_id', $sellerId)->firstOrFail();
        $voucher->is_active = !$voucher->is_active;
        $voucher->save();

        return response()->json([
            'message' => 'Status voucher berhasil diubah',
            'voucher' => $voucher,
        ]);
    }

    /**
     * Seller: Delete seller's voucher.
     */
    public function sellerDestroy($id)
    {
        $sellerId = Auth::id();
        $voucher = Voucher::where('id', $id)->where('user_id', $sellerId)->firstOrFail();
        $voucher->delete();

        return response()->json([
            'message' => 'Voucher berhasil dihapus',
        ]);
    }

    /**
     * Admin: Create a new voucher.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:vouchers,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        $voucher = Voucher::create([
            'code' => strtoupper(trim($request->code)),
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'value' => $request->value,
            'min_purchase' => $request->min_purchase ?? 0,
            'max_discount' => $request->max_discount,
            'usage_limit' => $request->usage_limit,
            'per_user_limit' => $request->per_user_limit ?? 1,
            'starts_at' => $request->starts_at,
            'expires_at' => $request->expires_at,
        ]);

        return response()->json([
            'message' => 'Voucher berhasil dibuat',
            'voucher' => $voucher,
        ], 201);
    }

    /**
     * Admin: List all vouchers.
     */
    public function adminIndex()
    {
        $vouchers = Voucher::orderBy('created_at', 'desc')->get();
        return response()->json($vouchers);
    }

    /**
     * Admin: Delete a voucher.
     */
    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return response()->json(['message' => 'Voucher berhasil dihapus']);
    }

    /**
     * Admin: Toggle voucher active status.
     */
    public function toggle($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->is_active = !$voucher->is_active;
        $voucher->save();

        return response()->json([
            'message' => 'Status voucher berhasil diubah',
            'voucher' => $voucher,
        ]);
    }
}
