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
        $orders = Order::all();

        foreach ($orders as $order) {
            Product::create([
                'name' => 'Sample Product 1',
                'delivery_status' => 'pending',
                'delivery_time' => now()->addDays(3),
                'order_id' => $order->id,
            ]);

            Product::create([
                'name' => 'Sample Product 2',
                'delivery_status' => 'shipped',
                'delivery_time' => now()->addDays(1),
                'order_id' => $order->id,
            ]);
        }
    }
}
