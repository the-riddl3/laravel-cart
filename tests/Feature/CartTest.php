<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\ProductGroupItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function testAddProductToCart() {
        $user = User::factory()->create(['id' => 10]);
        /** @var Collection<Product> $products */
        $product = Product::factory()->create(['user_id' => $user->id]);

        $this->post(route('cart.addProduct'), [
           'product_id' => $product->product_id
        ])->assertStatus(200);

        $this->assertDatabaseHas('carts', ['product_id' => $product->product_id]);
    }

    public function testRemoveProductFromCart() {
        $user = User::factory()->create(['id' => 10]);
        /** @var Collection<Product> $products */
        $product = Product::factory()->create(['user_id' => $user->id]);

        $this->post(route('cart.removeProduct'), [
            'product_id' => $product->product_id
        ])->assertStatus(200);

        $this->assertDatabaseCount('carts', 0);
    }

    public function testSetCartProductQuantity() {
        $user = User::factory()->create(['id' => 10]);
        /** @var Collection<Product> $products */
        $product = Product::factory()->create(['user_id' => $user->id]);
        Cart::factory()->create(['user_id' => $user->id, 'product_id' => $product->product_id, 'quantity' => 1]);

        $this->post(route('cart.setQuantity'), [
            'product_id' => $product->product_id,
            'quantity' => 3
        ])->assertStatus(200);

        $this->assertDatabaseHas('carts', ['product_id' => $product->product_id, 'quantity' => 3]);
    }

    public function testGetUserCart()
    {
        $user = User::factory()->create(['id' => 10]);
        /** @var Collection<Product> $products */
        $products = Product::factory()->count(5)->create(['user_id' => $user->id]);
        $productGroup = ProductGroup::factory()->create(['discount' => 10, 'user_id' => $user->id]);
        ProductGroupItem::factory()->create([
            'group_id' => $productGroup->group_id,
            'product_id' => $products[0]->product_id
        ]);
        ProductGroupItem::factory()->create([
            'group_id' => $productGroup->group_id,
            'product_id' => $products[1]->product_id
        ]);

        Cart::factory()->create(['user_id' => $user->id, 'product_id' => $products[0]->product_id, 'quantity' => 3]);
        Cart::factory()->create(['user_id' => $user->id, 'product_id' => $products[1]->product_id, 'quantity' => 2]);
        Cart::factory()->create(['user_id' => $user->id, 'product_id' => $products[2]->product_id]);

        $minimumQuantity = 2;
        $expectedDiscount = ($products[0]->price + $products[1]->price) * ($productGroup->discount / 100) * $minimumQuantity;

        $this->get(route('cart.get'))
            ->assertStatus(200)
            ->assertJsonCount(3, 'products')
            ->assertJsonFragment(['discount' => $expectedDiscount]);
    }
}
