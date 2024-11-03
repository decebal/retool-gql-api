<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::where('role', 'admin')->first();

        Order::create([
            'order_number' => 'ORD-1001',
            'user_id' => $adminUser->id,
        ]);

        Order::create([
            'order_number' => 'ORD-1002',
            'user_id' => $adminUser->id,
        ]);

        // Fetch all order and product IDs
        $orderIds = Order::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();

        // Seed the pivot table with random data
        foreach ($orderIds as $orderId) {
            $randomProductIds = array_rand(array_flip($productIds), rand(1, 3)); // Get 1 to 3 random products per order

            foreach ((array)$randomProductIds as $productId) {
                \DB::table('order_products')->insert([
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'quantity' => rand(1, 5),
                    'delivery_time' => now()->addDays(rand(1, 10)),
                    'delivery_status' => ['pending', 'shipped', 'delivered'][array_rand(['pending', 'shipped', 'delivered'])],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
