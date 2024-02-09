<?php

namespace Database\Seeders;

use App\Models\Cart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cart::query()->insert([
            [
                'id' => 1,
                'user_id' => 10,
                'product_id' => 2,
                'quantity' => 3,
            ],
            [
                'id' => 2,
                'user_id' => 10,
                'product_id' => 5,
                'quantity' => 2,
            ],
            [
                'id' => 3,
                'user_id' => 10,
                'product_id' => 1,
                'quantity' => 1,
            ],
        ]);
    }
}
