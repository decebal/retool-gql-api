<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use GraphQL\Type\Definition\ResolveInfo;

class AuthMutations
{
    /**
     * Handle login and return access and refresh tokens.
     *
     * @param null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @param ResolveInfo $resolveInfo
     * @return array
     */
    public function login($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $credentials = ['email' => $args['email'], 'password' => $args['password']];

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return [
                'access_token' => null,
                'refresh_token' => null,
                'token_type' => null,
                'expires_in' => null,
            ];
        }

        $user = Auth::guard('api')->user();

        return [
            'access_token' => $token,
            'refresh_token' => JWTAuth::fromUser($user),
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ];
    }

    /**
     * Refresh the access token using the refresh token.
     *
     * @param null $rootValue
     * @param array $args
     * @param GraphQLContext $context
     * @param ResolveInfo $resolveInfo
     * @return array
     */
    public function refresh($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        try {
            $newAccessToken = JWTAuth::refresh($args['refreshToken']);
            return [
                'access_token' => $newAccessToken,
                'refresh_token' => $args['refreshToken'], // Keep the same refresh token
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ];
        } catch (\Exception $e) {
            return [
                'access_token' => null,
                'refresh_token' => null,
                'token_type' => null,
                'expires_in' => null,
            ];
        }
    }
}
