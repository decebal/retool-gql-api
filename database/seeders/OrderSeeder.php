<?php

namespace Database\Seeders;

use App\Models\Order;
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
    }
}
