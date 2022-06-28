<?php

namespace App\Actions\Token;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class Jwt
{
    /**
     * @param User $user
     * 
     * @return string
     */
    public function token(User $user): string
    {
        $token = JWTAuth::fromUser($user);
        $authenticate = JWTAuth::setToken($token)->toUser();

        abort_if(!$authenticate, CODE_UNAUTHORIZED, "Unable to authenticate user.");

        return $token;
    }
}
