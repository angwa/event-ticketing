<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;

class UserRegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
        $user  = (new CreateNewUser())->execute($request);

        return JSON(CODE_CREATED, 'Registration Successful. ', new UserResource($user));
    }
}
