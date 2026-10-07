<?php

namespace App\Http\Controllers;

use App\Models\OrderTracking;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderTrackingController extends Controller
{
    /**
     * Seller mengirim/update lokasi real-time.
     * POST /api/tracking/{transaction_id}/update
     */
    public function updateLocation(Request $request, $transactionId)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'tracking_status' => 'nullable|in:picked_up,on_the_way,nearby,delivered',
            'note' => 'nullable|string|max:500',
        ]);

        $seller = Auth::user();
        $transaction = Transaction::findOrFail($transactionId);

        // Verifikasi bahwa user adalah seller dari produk dalam transaksi ini
        $productIds = Product::where('user_id', $seller->id)->pluck('id');
        $isSeller = $transaction->items()->whereIn('product_id', $productIds)->exists();

        if (!$isSeller) {
            return response()->json(['message' => 'Anda bukan penjual untuk pesanan ini'], 403);
        }

        // Hanya bisa tracking jika status transaksi adalah shipping, paid, atau processing
        if (!in_array($transaction->status, ['shipping', 'paid', 'processing'])) {
            return response()->json([
                'message' => 'Tracking hanya tersedia untuk pesanan yang sedang dikemas atau dikirim'
            ], 400);
        }

        // Update atau buat tracking record baru
        $tracking = OrderTracking::updateOrCreate(
            [
                'transaction_id' => $transactionId,
                'seller_id' => $seller->id,
            ],
            [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'tracking_status' => $request->tracking_status ?? 'on_the_way',
                'note' => $request->note,
            ]
        );

        // Jika status tracking jadi 'delivered', update juga status transaksi
        if ($request->tracking_status === 'delivered') {
            $transaction->status = 'delivered';
            $transaction->save();
        }

        // Jika transaksi masih paid atau processing (belum shipping), ubah ke shipping
        if (in_array($transaction->status, ['paid', 'processing'])) {
            $transaction->status = 'shipping';
            $transaction->save();
        }

        return response()->json([
            'message' => 'Lokasi berhasil diperbarui',
            'tracking' => $tracking,
            'shipping_name' => $transaction->shipping_name,
            'shipping_phone' => $transaction->shipping_phone,
            'shipping_address' => $transaction->shipping_address,
            'destination_lat' => $transaction->destination_lat,
            'destination_lng' => $transaction->destination_lng,
        ]);
    }

    /**
     * Buyer mendapatkan lokasi terkini seller.
     * GET /api/tracking/{transaction_id}
     */
    public function getLocation($transactionId)
    {
        $user = Auth::user();
        $transaction = Transaction::findOrFail($transactionId);

        // Verifikasi bahwa user adalah buyer atau seller
        $productIds = Product::where('user_id', $user->id)->pluck('id');
        $isSeller = $transaction->items()->whereIn('product_id', $productIds)->exists();
        $isBuyer = $transaction->user_id === $user->id;

        if (!$isBuyer && !$isSeller) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $tracking = OrderTracking::where('transaction_id', $transactionId)
            ->latest('updated_at')
            ->first();

        $firstItem = $transaction->items()->with('product.user')->first();
        $seller = $firstItem?->product?->user;

        $shippingName = $transaction->shipping_name ?: ($transaction->user?->name ?? 'Pembeli');
        $shippingPhone = $transaction->shipping_phone ?: ($transaction->user?->phone ?? '-');
        $shippingAddress = $transaction->shipping_address ?: ($transaction->user?->address ?? 'Alamat tujuan belum diisi');

        $responseData = [
            'tracking' => $tracking,
            'shipping_name' => $shippingName,
            'shipping_phone' => $shippingPhone,
            'shipping_address' => $shippingAddress,
            'destination_lat' => $transaction->destination_lat,
            'destination_lng' => $transaction->destination_lng,
            'transaction_status' => $transaction->status,
            'order_id' => $transaction->order_id ?: ('#' . $transaction->id),
            'store_name' => $seller?->name ?? 'Toko Penjual',
            'store_phone' => $seller?->phone ?? '',
        ];

        if (!$tracking) {
            $responseData['message'] = 'Belum ada data tracking untuk pesanan ini';
        }

        return response()->json($responseData);
    }

    /**
     * Seller memulai pengiriman (start tracking).
     * POST /api/tracking/{transaction_id}/start
     */
    public function startDelivery(Request $request, $transactionId)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $seller = Auth::user();
        $transaction = Transaction::findOrFail($transactionId);

        // Verifikasi seller
        $productIds = Product::where('user_id', $seller->id)->pluck('id');
        $isSeller = $transaction->items()->whereIn('product_id', $productIds)->exists();

        if (!$isSeller) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!in_array($transaction->status, ['paid', 'processing'])) {
            return response()->json(['message' => 'Hanya pesanan yang sudah dibayar atau sedang dikemas yang bisa dikirim'], 400);
        }

        // Update status transaksi ke shipping
        $transaction->status = 'shipping';
        $transaction->save();

        // Buat tracking record awal
        $tracking = OrderTracking::create([
            'transaction_id' => $transactionId,
            'seller_id' => $seller->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'tracking_status' => 'picked_up',
            'note' => 'Pengiriman dimulai',
        ]);

        // Kirim notifikasi WhatsApp ke buyer
        try {
            $wa = new \App\Services\WhatsAppService();
            if ($wa->isEnabled()) {
                $transaction->load('user');
                $buyer = $transaction->user;
                if ($buyer && $buyer->phone) {
                    $wa->notifyBuyerOrderShipped(
                        $buyer->phone,
                        $transaction->order_id,
                        $seller->name
                    );
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to send WhatsApp shipping notification: " . $e->getMessage());
        }

        return response()->json([
            'message' => 'Pengiriman dimulai! Lokasi Anda akan dikirim secara real-time.',
            'tracking' => $tracking,
            'shipping_name' => $transaction->shipping_name,
            'shipping_phone' => $transaction->shipping_phone,
            'shipping_address' => $transaction->shipping_address,
            'destination_lat' => $transaction->destination_lat,
            'destination_lng' => $transaction->destination_lng,
        ]);
    }

    /**
     * Seller menyelesaikan pengiriman.
     * POST /api/tracking/{transaction_id}/complete
     */
    public function completeDelivery(Request $request, $transactionId)
    {
        $seller = Auth::user();
        $transaction = Transaction::findOrFail($transactionId);

        $productIds = Product::where('user_id', $seller->id)->pluck('id');
        $isSeller = $transaction->items()->whereIn('product_id', $productIds)->exists();

        if (!$isSeller) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Update tracking status
        OrderTracking::updateOrCreate(
            [
                'transaction_id' => $transactionId,
                'seller_id' => $seller->id,
            ],
            [
                'latitude' => $request->latitude ?? 0,
                'longitude' => $request->longitude ?? 0,
                'tracking_status' => 'delivered',
                'note' => 'Pesanan telah sampai',
            ]
        );

        // Update transaction status
        $transaction->status = 'delivered';
        $transaction->save();

        // Kirim notifikasi WhatsApp ke buyer
        try {
            $wa = new \App\Services\WhatsAppService();
            if ($wa->isEnabled()) {
                $transaction->load('user');
                $buyer = $transaction->user;
                if ($buyer && $buyer->phone) {
                    $wa->notifyBuyerOrderDelivered(
                        $buyer->phone,
                        $transaction->order_id
                    );
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to send WhatsApp delivered notification: " . $e->getMessage());
        }

        return response()->json([
            'message' => 'Pengiriman selesai! Pesanan telah sampai.',
        ]);
    }

    /**
     * Buyer atau seller memperbarui koordinat tujuan pengiriman.
     * POST /api/tracking/{transaction_id}/destination
     */
    public function updateDestination(Request $request, $transactionId)
    {
        $request->validate([
            'destination_lat' => 'required|numeric|between:-90,90',
            'destination_lng' => 'required|numeric|between:-180,180',
            'shipping_address' => 'nullable|string',
        ]);

        $user = Auth::user();
        $transaction = Transaction::findOrFail($transactionId);

        // Verifikasi bahwa user adalah buyer atau seller
        $productIds = Product::where('user_id', $user->id)->pluck('id');
        $isSeller = $transaction->items()->whereIn('product_id', $productIds)->exists();
        $isBuyer = $transaction->user_id === $user->id;

        if (!$isBuyer && !$isSeller) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $transaction->destination_lat = $request->destination_lat;
        $transaction->destination_lng = $request->destination_lng;
        if ($request->filled('shipping_address')) {
            $transaction->shipping_address = $request->shipping_address;
        }
        $transaction->save();

        return response()->json([
            'message' => 'Titik tujuan pengiriman berhasil disimpan.',
            'destination_lat' => $transaction->destination_lat,
            'destination_lng' => $transaction->destination_lng,
            'shipping_address' => $transaction->shipping_address,
        ]);
    }
}
