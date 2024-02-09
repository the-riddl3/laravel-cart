<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ProductGroupItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        (new UserSeeder())->run();
        (new ProductSeeder())->run();
        (new ProductGroupSeeder())->run();
        (new ProductGroupItemSeeder())->run();
        (new CartSeeder())->run();
    }
}
