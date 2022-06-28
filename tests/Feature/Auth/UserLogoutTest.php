<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Traits\IsActiveUser;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserLogoutTest extends TestCase
{
    use IsActiveUser;

    public function testUserCanNotLoginWithoutToken()
    {
        $response =  $this->get('/api/logout');

        $response->assertStatus(401);
    }

    public function testUserCanLoginWithToken()
    {
        $response =  $this->get('/api/logout', $this->activeUser());

        $response->assertStatus(200);
    }
}