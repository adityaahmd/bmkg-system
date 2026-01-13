<?php
// tests/Feature/ProductTest.php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_view_products_page()
    {
        $response = $this->get(route('products.index'));
        $response->assertStatus(200);
    }

    public function test_users_can_view_single_product()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'status' => 'published'
        ]);

        $response = $this->get(route('products.show', $product->slug));
        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    public function test_users_can_add_product_to_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['status' => 'published']);

        $response = $this->actingAs($user)
            ->post(route('cart.add', $product));

        $response->assertStatus(200);
        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);
    }
}