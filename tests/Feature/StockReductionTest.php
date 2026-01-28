<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Config;

class StockReductionTest extends TestCase
{
    use RefreshDatabase;

    public function test_stock_is_reduced_when_transaction_becomes_paid()
    {
        // 1. Setup Data
        $seller = User::factory()->create();
        $buyer = User::factory()->create();
        $category = Category::create(['name' => 'Test Cat']);
        
        $initialStock = 10;
        $orderQty = 2;
        
        $product = Product::create([
            'user_id' => $seller->id,
            'name' => 'Stock Test Product',
            'category_id' => $category->id,
            'description' => 'Stock Test Desc',
            'price' => 1000,
            'stock' => $initialStock,
        ]);

        $orderId = 'ORDER-TEST-' . time();
        $transaction = Transaction::create([
            'user_id' => $buyer->id,
            'total_price' => 2000,
            'status' => 'pending',
            'order_id' => $orderId,
            'payment_method' => 'midtrans',
        ]);

        TransactionItem::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'qty' => $orderQty,
            'price' => 1000,
        ]);

        // 2. Mock Midtrans Config
        Config::set('midtrans.server_key', 'test-key');
        
        $signature = hash('sha512', $orderId . '200' . '2000.00' . 'test-key');

        // 3. Simulate Successful Notification
        $response = $this->postJson('/api/midtrans/notification', [
            'order_id' => $orderId,
            'transaction_status' => 'settlement',
            'status_code' => '200',
            'gross_amount' => '2000.00',
            'signature_key' => $signature,
        ]);

        $response->assertStatus(200);

        // 4. Verification
        $this->assertEquals('paid', $transaction->fresh()->status);
        $this->assertEquals($initialStock - $orderQty, $product->fresh()->stock);

        // 5. Test Idempotency (Second notification should not reduce stock again)
        $response2 = $this->postJson('/api/midtrans/notification', [
            'order_id' => $orderId,
            'transaction_status' => 'settlement',
            'status_code' => '200',
            'gross_amount' => '2000.00',
            'signature_key' => $signature,
        ]);

        $response2->assertStatus(200);
        $this->assertEquals($initialStock - $orderQty, $product->fresh()->stock);
    }
}
