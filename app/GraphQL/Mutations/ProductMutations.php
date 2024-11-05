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

        // Validate the delivery time and status
        $validator = Validator::make($args, [
            'deliveryTime' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Define acceptable formats
                    $formats = ['Y-m-d', 'Y-m-d H:i:s'];
                    $dateValid = false;

                    foreach ($formats as $format) {
                        $parsedDate = \DateTime::createFromFormat($format, $value);
                        if ($parsedDate && $parsedDate->format($format) === $value) {
                            $dateValid = true;
                            break;
                        }
                    }

                    if (!$dateValid) {
                        $fail("The $attribute must be a valid date in one of the formats: Y-m-d or Y-m-d H:i:s.");
                    }
                }
            ],
            'deliveryStatus' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Define valid delivery statuses
                    $validStatuses = ['pending', 'shipped', 'delivered', 'cancelled'];
                    if (!in_array(strtolower($value), $validStatuses)) {
                        $fail("The $attribute must be one of the following: " . implode(', ', $validStatuses) . " (case-insensitive).");
                    }
                }
            ],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $deliveryTime = $args['deliveryTime'];
        $formats = ['Y-m-d', 'Y-m-d H:i:s']; // Define your allowed formats
        $parsedDate = null;

        foreach ($formats as $format) {
            try {
                $parsedDate = Carbon::createFromFormat($format, $deliveryTime);
                break; // Exit loop once a valid format is found
            } catch (\Exception $e) {
                // Continue to the next format if the current one fails
            }
        }

        if (!$parsedDate) {
            throw new \InvalidArgumentException("The deliveryTime must match one of the following formats: " . implode(', ', $formats));
        }

        // Update the order_products table
        $updated = DB::table('order_products')
            ->where('order_id', $args['orderId'])
            ->where('product_id', $args['productId'])
            ->update([
                'delivery_time' => $parsedDate,
                'delivery_status' => strtolower($args['deliveryStatus']),
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
