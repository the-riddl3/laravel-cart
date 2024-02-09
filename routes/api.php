<?php

use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('cart')
    ->name('cart.')
    ->group(function () {
        Route::post('add-product', [CartController::class, 'addProductInCart'])->name('addProduct');
        Route::post('remove-product', [CartController::class, 'removeProductFromCart'])->name('removeProduct');
        Route::post('set-quantity', [CartController::class, 'setCartProductQuantity'])->name('setQuantity');
        Route::get('/', [CartController::class, 'getUserCart'])->name('get');
    });
