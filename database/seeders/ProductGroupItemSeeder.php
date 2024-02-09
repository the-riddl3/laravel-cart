<?php

namespace Database\Seeders;

use App\Models\ProductGroupItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductGroupItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductGroupItem::query()->insert([
            [
                'item_id' => 1,
                'group_id' => 1,
                'product_id' => 2
            ],
            [
                'item_id' => 2,
                'group_id' => 1,
                'product_id' => 5,
            ]
        ]);
    }
}
