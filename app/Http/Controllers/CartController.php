<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addProductInCart(ProductRequest $request): JsonResponse
    {
        // request validation is inside the ProductRequest class

        /** @var Product $product */
        $product = Product::query()->find($request->get('product_id'));
        /** @var User $user */
        $user = User::query()->first();

        (new CartService($user))->addProductToCart($product);

        return response()->json(['message' => 'Product added to cart']);
    }

    public function removeProductFromCart(ProductRequest $request): JsonResponse
    {
        // request validation is inside the ProductRequest class

        Product::query()->find($request->get('product_id'));
        User::query()->first();

        return response()->json(['message' => 'Product removed from cart']);
    }

    public function setCartProductQuantity(ProductRequest $request): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|min:1'
        ]);

        /** @var Product $product */
        $product = Product::query()->find($request->get('product_id'));
        /** @var User $user */
        $user = User::query()->first();

        (new CartService($user))->updateQuantity($product, $request->integer('quantity'));

        return response()->json(['message' => 'Quantity updated']);
    }

    public function getUserCart(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = User::query()->first();
        return response()->json([
            'products' => CartResource::collection($user->cartItems),
            'discount' => (new CartService($user))->calculateDiscountSlow(),
        ]);
    }
}
