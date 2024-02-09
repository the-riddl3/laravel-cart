<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\User;

class CartService
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function addProductToCart(Product $product): void
    {
        $this->user->cartItems()->create([
            'product_id' => $product->product_id,
            'quantity' => 1
        ]);
    }

    public function removeProductFromCart(Product $product): void
    {
        $this->user->cartItems()->delete([$product->product_id]);
    }

    public function calculateDiscountSlow(): float
    {
        $discount = 0;
        $productGroups = ProductGroup::query()->get();
        foreach ($productGroups as $productGroup) {
            /** @var ProductGroup $productGroup */
            $groupCount = $productGroup->groupItems->count();

            $matching = $this->user->cartItems()
                ->whereIn('product_id', $productGroup->groupItems->pluck('product_id'))
                ->get();

            if($matching->count() === $groupCount) {
                $minimumQuantity = $matching->pluck('quantity')->min();
                $discount +=
                    $matching->map(fn(Cart $cartItem) => $cartItem->product->price)->sum()
                    * ($productGroup->discount / 100)
                    * $minimumQuantity;
            }
        }

        return $discount;
    }

    public function updateQuantity(Product $product, int $quantity): void
    {
        $this->user->cartItems()
            ->where('product_id', $product->product_id)
            ->update(['quantity' => $quantity]);
    }
}
