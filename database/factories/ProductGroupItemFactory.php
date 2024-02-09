<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductGroupItem>
 */
class ProductGroupItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'group_id' => ProductGroup::factory()->create()->group_id,
            'product_id' => Product::factory()->create()->product_id,
        ];
    }
}
