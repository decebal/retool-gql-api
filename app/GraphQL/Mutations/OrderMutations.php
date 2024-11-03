<?php

namespace App\GraphQL\Mutations;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Type\Definition\ResolveInfo;

class OrderMutations
{
    /**
     * Handle create order
     *
     * @param null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @param ResolveInfo $resolveInfo
     * @return array
     * @throws ValidationException
     */
    public function create($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $userId = Auth::guard('api')->user()->getAuthIdentifier();
        $user = User::findOrFail($userId);

        if (!$user || !$user->role == 'admin') {
            throw ValidationException::withMessages([
                'role' => 'You do not have permission to place an order.',
            ]);
        }

        // Validate the input for products and quantities
        if (count($args['products']) !== count($args['quantities'])) {
            throw ValidationException::withMessages([
                'input' => 'Products and quantities arrays must be of the same length.',
            ]);
        }

        // Generate the next order number with the format ORD-XXXX
        $lastOrder = Order::latest('created_at')->first();  // Get the latest order by creation date
        $nextOrderNumber = 'ORD-1001';  // Default for the first order

        if ($lastOrder) {
            // Extract the numeric part of the last order number
            $lastOrderNumber = intval(substr($lastOrder->order_number, 4));
            $nextOrderNumber = 'ORD-' . str_pad($lastOrderNumber + 1, 4, '0', STR_PAD_LEFT);
        }

        // Create the order
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => $nextOrderNumber,
        ]);

        // Attach products to the order with quantities
        foreach ($args['products'] as $index => $productId) {
            $product = Product::findOrFail($productId);

            // Attach product with quantity to the order
            $order->products()->attach($product->id, ['quantity' => $args['quantities'][$index]]);
        }

        return $order;
    }
}
