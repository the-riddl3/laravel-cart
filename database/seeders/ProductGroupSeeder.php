<?php

namespace Database\Seeders;

use App\Models\ProductGroup;
use Illuminate\Database\Seeder;

class ProductGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductGroup::query()->insert([
           'group_id' => 1,
           'user_id' => 10,
           'discount' => 15,
        ]);
    }
}
