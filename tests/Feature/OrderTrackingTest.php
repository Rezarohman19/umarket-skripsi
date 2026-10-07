<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\OrderTracking;
use App\Services\WhatsAppService;

class OrderTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_seller_can_start_delivery_and_buyer_can_track_location()
    {
        // 1. Create seller and buyer
        $seller = User::factory()->create(['name' => 'Seller Unila', 'phone' => '081234567890']);
        $buyer = User::factory()->create(['name' => 'Buyer Unila', 'phone' => '089876543210']);
        $category = Category::create(['name' => 'Buku & Kuliah']);

        $product = Product::create([
            'user_id' => $seller->id,
            'name' => 'Modul Algoritma',
            'category_id' => $category->id,
            'description' => 'Buku modul kuliah',
            'price' => 50000,
            'stock' => 5,
        ]);

        $transaction = Transaction::create([
            'user_id' => $buyer->id,
            'total_price' => 50000,
            'status' => 'paid',
            'order_id' => 'ORDER-TRK-001',
            'shipping_name' => 'Buyer Unila',
            'shipping_phone' => '089876543210',
            'shipping_address' => 'Gedung H Ilmu Komputer Unila',
        ]);

        TransactionItem::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'qty' => 1,
            'price' => 50000,
        ]);

        // 2. Seller starts delivery (POST /api/tracking/{id}/start)
        $startResponse = $this->actingAs($seller)->postJson("/api/tracking/{$transaction->id}/start", [
            'latitude' => -5.3653,
            'longitude' => 105.2435,
        ]);

        $startResponse->assertStatus(200);
        $this->assertEquals('shipping', $transaction->fresh()->status);
        $this->assertDatabaseHas('order_tracking', [
            'transaction_id' => $transaction->id,
            'seller_id' => $seller->id,
            'tracking_status' => 'picked_up',
        ]);

        // 3. Seller updates location during transit (POST /api/tracking/{id}/update)
        $updateResponse = $this->actingAs($seller)->postJson("/api/tracking/{$transaction->id}/update", [
            'latitude' => -5.3660,
            'longitude' => 105.2440,
            'tracking_status' => 'on_the_way',
            'note' => 'Melewati Rektorat Unila',
        ]);

        $updateResponse->assertStatus(200);
        $this->assertDatabaseHas('order_tracking', [
            'transaction_id' => $transaction->id,
            'tracking_status' => 'on_the_way',
            'note' => 'Melewati Rektorat Unila',
        ]);

        // 4. Buyer gets current tracking location (GET /api/tracking/{id})
        $getTrackingResponse = $this->actingAs($buyer)->getJson("/api/tracking/{$transaction->id}");
        $getTrackingResponse->assertStatus(200);
        $getTrackingResponse->assertJsonStructure([
            'tracking' => ['latitude', 'longitude', 'tracking_status', 'note'],
            'shipping_address',
            'transaction_status',
            'order_id',
        ]);

        // 5. Seller completes delivery (POST /api/tracking/{id}/complete)
        $completeResponse = $this->actingAs($seller)->postJson("/api/tracking/{$transaction->id}/complete", [
            'latitude' => -5.3670,
            'longitude' => 105.2450,
        ]);

        $completeResponse->assertStatus(200);
        $this->assertEquals('delivered', $transaction->fresh()->status);
    }

    public function test_whatsapp_phone_number_formatting()
    {
        $this->assertEquals('628123456789', WhatsAppService::formatPhoneNumber('08123456789'));
        $this->assertEquals('628123456789', WhatsAppService::formatPhoneNumber('+628123456789'));
        $this->assertEquals('628123456789', WhatsAppService::formatPhoneNumber('628123456789'));
        $this->assertEquals('628123456789', WhatsAppService::formatPhoneNumber('8123456789'));
        $this->assertEquals('628123456789', WhatsAppService::formatPhoneNumber('0812-3456-789'));
    }
}
