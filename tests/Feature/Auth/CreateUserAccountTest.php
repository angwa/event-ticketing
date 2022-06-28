<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserAccountTest extends TestCase
{
    use WithFaker;

    /**
     * User cannot register without filling the form correctly
     *
     * @return void
     */
    public function testUserCannotRegisterWithoutFillingFormProperly()
    {
        $this->postJson('/api/user/create', [])
            ->assertJsonValidationErrors([
                'email'    => 'The email field is required.',
                'password' => 'The password field is required.',
            ]);
    }

        /**
     * User can register new account
     * 
     * @return void
     */
    public function testUserCanRegisterNewAccount()
    {
        $response =  $this->postJson('/api/user/create', [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => 'userpassword', // userpassword
            'password_confirmation' => 'userpassword', // userpassword
        ]);

        $response->assertStatus(201);
        $this->assertIsObject($response);
    }

}
