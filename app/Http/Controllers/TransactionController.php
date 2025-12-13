<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\CartItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Ambil transactions milik user dengan items
        $transactions = Transaction::where('user_id', $user->id)
            ->with(['items.product.user', 'user'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($transaction) {
                // Ambil item pertama untuk ditampilkan di list (atau bisa ditampilkan semua)
                $firstItem = $transaction->items->first();
                
                return [
                    'id' => $transaction->id,
                    'status' => $transaction->status,
                    'total_price' => $transaction->total_price,
                    'created_at' => $transaction->created_at,
                    'product_name' => $firstItem->product->name ?? 'Produk',
                    'product_description' => $firstItem->product->description ?? '',
                    'qty' => $firstItem->qty ?? 0,
                    'price' => $firstItem->price ?? 0,
                    'store_name' => $firstItem->product->user->name ?? 'Toko',
                    'items' => $transaction->items->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'product_id' => $item->product_id,
                            'qty' => $item->qty,
                            'quantity' => $item->qty, // Alias untuk kompatibilitas
                            'price' => $item->price,
                            'product' => [
                                'id' => $item->product->id,
                                'name' => $item->product->name,
                                'description' => $item->product->description,
                                'price' => $item->product->price,
                                'user' => $item->product->user,
                            ],
                        ];
                    }),
                ];
            });

        return response()->json($transactions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'total_price' => 'required|numeric',
            'status'      => 'nullable|string'
        ]);

        $transaction = Transaction::create($request->all());
        return response()->json($transaction, 201);
    }

    public function show($id)
    {
        return response()->json(Transaction::with('items')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all());
        return response()->json($transaction);
    }

    /**
     * Proses checkout dari cart
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.cart_item_id' => 'required|exists:cart_items,id',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'shipping_address' => 'nullable|array',
            'payment_method' => 'nullable|string',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        DB::beginTransaction();
        try {
            // Ambil cart user
            $cart = Cart::where('user_id', $user->id)->first();
            if (!$cart) {
                return response()->json(['message' => 'Cart not found'], 404);
            }

            $totalPrice = 0;
            $transactionItems = [];

            // Proses setiap item
            foreach ($request->items as $itemData) {
                // Ambil cart item
                $cartItem = CartItem::where('cart_id', $cart->id)
                    ->where('id', $itemData['cart_item_id'])
                    ->with('product')
                    ->first();

                if (!$cartItem) {
                    throw new \Exception('Cart item not found');
                }

                // Hitung subtotal
                $subtotal = $cartItem->product->price * $itemData['quantity'];
                $totalPrice += $subtotal;

                // Simpan data untuk transaction item
                $transactionItems[] = [
                    'product_id' => $cartItem->product_id,
                    'qty' => $itemData['quantity'],
                    'price' => $cartItem->product->price,
                ];
            }

            // Buat transaction dengan data tambahan
            $transactionData = [
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ];

            // Simpan shipping address dan payment method jika ada
            if ($request->has('shipping_address') && is_array($request->shipping_address)) {
                $transactionData['shipping_name'] = $request->shipping_address['name'] ?? null;
                $transactionData['shipping_phone'] = $request->shipping_address['phone'] ?? null;
                $transactionData['shipping_address'] = $request->shipping_address['address'] ?? null;
            }

            if ($request->has('payment_method')) {
                $transactionData['payment_method'] = $request->payment_method;
            }

            $transaction = Transaction::create($transactionData);

            // Buat transaction items
            foreach ($transactionItems as $itemData) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $itemData['product_id'],
                    'qty' => $itemData['qty'],
                    'price' => $itemData['price'],
                ]);
            }

            // Hapus cart items yang sudah di-checkout
            $cartItemIds = array_column($request->items, 'cart_item_id');
            CartItem::whereIn('id', $cartItemIds)->delete();

            DB::commit();

            // Load relasi untuk response
            $transaction->load(['items.product', 'user']);

            return response()->json([
                'message' => 'Checkout berhasil',
                'transaction' => $transaction,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal melakukan checkout: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ambil pesanan yang masuk ke toko penjual
     * Pesanan yang mengandung produk milik penjual
     */
    public function sellerOrders()
    {
        $seller = Auth::user();
        if (!$seller) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Ambil semua produk milik penjual
        $productIds = \App\Models\Product::where('user_id', $seller->id)->pluck('id');

        if ($productIds->isEmpty()) {
            return response()->json([]);
        }

        // Ambil transaction items yang mengandung produk milik penjual
        $transactionItemIds = \App\Models\TransactionItem::whereIn('product_id', $productIds)
            ->pluck('transaction_id')
            ->unique();

        // Ambil transactions dengan items yang relevan
        $transactions = Transaction::whereIn('id', $transactionItemIds)
            ->with(['items.product.user', 'user'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($transaction) use ($productIds) {
                // Filter items yang hanya produk milik penjual ini
                $sellerItems = $transaction->items->filter(function ($item) use ($productIds) {
                    return $productIds->contains($item->product_id);
                });

                return [
                    'id' => $transaction->id,
                    'status' => $transaction->status,
                    'total_price' => $sellerItems->sum(function ($item) {
                        return $item->price * $item->qty;
                    }), // Total hanya untuk produk penjual ini
                    'created_at' => $transaction->created_at,
                    'buyer_name' => $transaction->user->name ?? 'Pembeli',
                    'buyer_id' => $transaction->user_id,
                    'items' => $sellerItems->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'product_id' => $item->product_id,
                            'qty' => $item->qty,
                            'quantity' => $item->qty,
                            'price' => $item->price,
                            'product' => [
                                'id' => $item->product->id,
                                'name' => $item->product->name,
                                'description' => $item->product->description,
                                'price' => $item->product->price,
                                'image_url' => $item->product->image ? \Illuminate\Support\Facades\Storage::url($item->product->image) : null,
                            ],
                        ];
                    }),
                    'shipping_address' => [
                        'name' => $transaction->shipping_name ?? null,
                        'phone' => $transaction->shipping_phone ?? null,
                        'address' => $transaction->shipping_address ?? null,
                    ],
                    'payment_method' => $transaction->payment_method ?? null,
                    'tracking_number' => $transaction->tracking_number ?? null,
                    'shipping_courier' => $transaction->shipping_courier ?? null,
                ];
            });

        return response()->json($transactions);
    }

    /**
     * Update status pesanan oleh penjual
     */
    public function updateSellerOrderStatus(Request $request, $id)
    {
        $seller = Auth::user();
        if (!$seller) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'status' => 'required|string|in:paid,processing,shipping,delivered,completed,cancelled',
            'tracking_number' => 'nullable|string',
            'shipping_courier' => 'nullable|string',
        ]);

        // Pastikan transaction ini mengandung produk milik penjual
        $productIds = \App\Models\Product::where('user_id', $seller->id)->pluck('id');
        $transactionItem = \App\Models\TransactionItem::where('transaction_id', $id)
            ->whereIn('product_id', $productIds)
            ->first();

        if (!$transactionItem) {
            return response()->json(['message' => 'Order not found or not authorized'], 404);
        }

        $transaction = Transaction::findOrFail($id);

        $transaction->status = $request->status;
        
        if ($request->tracking_number) {
            $transaction->tracking_number = $request->tracking_number;
        }
        
        if ($request->shipping_courier) {
            $transaction->shipping_courier = $request->shipping_courier;
        }

        $transaction->save();

        return response()->json([
            'message' => 'Order status updated successfully',
            'transaction' => $transaction,
        ]);
    }
}
