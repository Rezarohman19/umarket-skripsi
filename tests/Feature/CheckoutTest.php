<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\CartItem;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_checkout_and_transaction_created()
    {
        // Create user
        $user = User::factory()->create();

        // Create category and product
        $category = Category::create(['name' => 'Test Cat']);

        $product = Product::create([
            'user_id' => $user->id,
            'name' => 'Test Product',
            'category_id' => $category->id,
            'description' => 'Desc',
            'price' => 100000,
            'stock' => 10,
        ]);

        // Create cart and cart item
        $cart = Cart::create(['user_id' => $user->id]);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'qty' => 1,
        ]);

        // Act as user and call checkout
        $response = $this->actingAs($user)->postJson('/api/checkout', []);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'snap_token', 'transaction']);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'total_price' => 100000,
            'status' => 'pending',
        ]);
    }
}
