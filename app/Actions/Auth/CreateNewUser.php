<?php

namespace App\Actions\Auth;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateNewUser
{
    /**
     * @param RegisterRequest $request
     * 
     * @return object
     */
    public function execute(RegisterRequest $request): object
    {
        $user = $this->createUser($request);

        abort_if(!$user, CODE_BAD_REQUEST, "Error occured. Please try again");

        return $user;
    }

    /**
     * @param RegisterRequest $request
     * 
     * @return object
     */
    private function createUser(RegisterRequest $request): object
    {
        $user = User::create([
            'name' => $this->sentenceCase($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $user;
    }

    /**
     * @param mixed $text
     * 
     * @return string
     */
    private function sentenceCase($text): string
    {
        return ucwords(strtolower($text));
    }
}
