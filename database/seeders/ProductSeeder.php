<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Laptop',
        ]);

        Product::create([
            'name' => 'Monitor',
        ]);

        Product::create([
            'name' => 'Standup Desk',
        ]);

        Product::create([
            'name' => 'Lamp',
        ]);

        Product::create([
            'name' => 'Headphones',
        ]);
    }
}
