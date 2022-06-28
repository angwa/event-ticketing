<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LoginAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Actions\Token\Jwt;
use App\Http\Resources\UserResource;

class UserLoginController extends Controller
{
    public function store(LoginRequest $request)
    {
        $user = (new LoginAction($request))->execute();

        return JSON(CODE_SUCCESS, 'Login Successful', [
            'token' => (new Jwt())->token($user),
            'login' => new UserResource(auth()->user())
        ]);
    }
}
