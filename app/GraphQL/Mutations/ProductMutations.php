<?php

namespace App\GraphQL\Mutations;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nuwave\Lighthouse\Exceptions\ValidationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Validator;

class ProductMutations
{
    /**
     * Handle update product delivery
     *
     * @param null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @param ResolveInfo $resolveInfo
     */
    public function update($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $userId = Auth::guard('api')->user()->getAuthIdentifier();
        $user = User::findOrFail($userId);

        if (!$user || !$user->role == 'supplier') {
            throw ValidationException::withMessages([
                'role' => 'You do not have permission to place an order.',
            ]);
        }

        // Validate that the order exists
        $order = Order::find($args['orderId']);
        if (!$order) {
            throw ValidationException::withMessages([
                'orderId' => 'The specified order does not exist.',
            ]);
        }

        // Validate that the product exists
        $product = Product::find($args['productId']);
        if (!$product) {
            throw ValidationException::withMessages([
                'productId' => 'The specified product does not exist.',
            ]);
        }

        // Define valid delivery statuses
        $validStatuses = ['pending', 'shipped', 'delivered', 'cancelled'];

        // Validate the delivery time and status
        $validator = Validator::make($args, [
            'deliveryTime' => 'required|date|after:now',
            'deliveryStatus' => 'required|string|in:' . implode(',', $validStatuses),
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Update the order_products table
        $updated = DB::table('order_products')
            ->where('order_id', $args['orderId'])
            ->where('product_id', $args['productId'])
            ->update([
                'delivery_time' => Carbon::parse($args['deliveryTime']),
                'delivery_status' => $args['deliveryStatus'],
                'updated_at' => now(),
            ]);

//        if (!$updated) {
//            throw ValidationException::withMessages([
//                'update' => 'Failed to update the order product details.',
//            ]);
//        }

        // Return the updated order product details (as an array for simplicity)
        return DB::table('order_products')
            ->where('order_id', $args['orderId'])
            ->where('product_id', $args['productId'])
            ->first();
    }
}
