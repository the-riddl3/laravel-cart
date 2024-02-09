<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::query()->insert([
            [
                'product_id' => 1,
                'user_id' => 10,
                'title' => 'produqti 1',
                'price' => 10,
            ],
            [
                'product_id' => 2,
                'user_id' => 10,
                'title' => 'produqti 2',
                'price' => 15,
            ],
            [
                'product_id' => 3,
                'user_id' => 10,
                'title' => 'produqti 3',
                'price' => 8,
            ],
            [
                'product_id' => 4,
                'user_id' => 10,
                'title' => 'produqti 4',
                'price' => 7,
            ],
            [
                'product_id' => 5,
                'user_id' => 10,
                'title' => 'produqti 5',
                'price' => 20,
            ],
        ]);
    }
}
