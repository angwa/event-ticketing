<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginUserAccountTest extends TestCase
{
    use WithFaker;
    private $user;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user =  User::factory()->create();
    }

    /**
     * User cannot login without email and password
     * 
     * @return void
     */
    public function testUserCannotLoginWithoutEmailAndPassword()
    {
        $this->postJson('/api/user/login', [])
            ->assertJsonValidationErrors([
                'email'    => 'The email field is required.',
                'password' => 'The password field is required.',
            ]);
    }

    /**
     * User cannot login with incorrect password
     * @return void
     */
    public function testUserCannotLoginWithIncorrectPassword()
    {
        $this->postJson('/api/user/login', [
            'email' => $this->user->email,
            'password' => 'wrongpass'
        ])->assertStatus(401);
    }

    /**
     * User can now logn with correct email and password
     * 
     * @return void
     */
    public function testUserCanLoginWithEmailAndPassword()
    {
        $response =  $this->postJson('/api/user/login', [
            'email' => $this->user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
    }
}
