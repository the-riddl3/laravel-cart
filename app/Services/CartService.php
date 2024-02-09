<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

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

            if ($matching->count() === $groupCount) {
                $minimumQuantity = $matching->pluck('quantity')->min();
                $discount +=
                    $matching->map(fn(Cart $cartItem) => $cartItem->product->price)->sum()
                    * ($productGroup->discount / 100)
                    * $minimumQuantity;
            }
        }

        return $discount;
    }

    public function calculateDiscountFast(): float
    {
        $user = $this->user;
        return DB::table('product_groups as pg')
            ->select(DB::raw("SUM(p.price) * (pg.discount / 100) * MIN(c.quantity) as discount"))
            ->join('product_group_items as pgi', 'pg.group_id', 'pgi.group_id')
            ->join('products as p', 'pgi.product_id', 'p.product_id')
            ->join('carts as c', function (JoinClause $join) use ($user) {
                $join->on('c.product_id', 'p.product_id')
                    ->where('c.user_id', $user->id);
            })
            ->groupBy('pg.group_id')
            ->havingRaw("COUNT(pg.group_id) = (select count(group_id) from product_group_items where group_id = pg.group_id)")
            ->sum('discount');
    }

    public function updateQuantity(Product $product, int $quantity): void
    {
        $this->user->cartItems()
            ->where('product_id', $product->product_id)
            ->update(['quantity' => $quantity]);
    }
}
