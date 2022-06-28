<?php

namespace Tests\Feature\Event;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Traits\IsActiveUser;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class DeleteEventTest extends TestCase
{
    use WithFaker, IsActiveUser;

    private $event;
    private $token;
    private $user;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->event =  Event::factory()->create();

        $this->user = User::factory()->create();
        $this->token = ['Authorization' => 'Bearer' . JWTAuth::fromUser($this->user)];

    }

    /**
     * User cannot delete event without login in first
     *
     * @return void
     */
    public function testUserCannotDeleteEventWithoutLogin()
    {
        $response = $this->delete('/api/event/delete/' . $this->event->id);

        $response->assertStatus(401);
    }
    /**
     * User cannot delete event with invalid event
     *
     * @return void
     */
    public function testUserCannotDeleteAnInvalidEvent()
    {
        $response = $this->delete('/api/event/delete/0', $this->token);

        $response->assertStatus(404);
    }

    /**
     * User cannot delete event without filling the form correctly
     *
     * @return void
     */
    public function testUserCannotDeleteEventTheyDidNotCreate()
    {
        $response = $this->delete('/api/event/delete/' . $this->event->id, [], $this->token);

        $response->assertStatus(403);
    }

    /**
     * User cann delete event without filling the form correctly
     *
     * @return void
     */
    public function testUserCanDeleteEventTheyCreated()
    {
        $response = $this->delete('/api/event/delete/' . $this->newEvent($this->user)->id, [], $this->token);

        $response->assertStatus(200);
    }

    private function newEvent($user)
    {
       return  Event::create([
           'user_id' => $user->id,
            "name" => $this->faker->name(),
            "location" => $this->faker->address(),
            "description" => $this->faker->text(),
            "date" => now(),
            "type" => $this->faker->randomElement(['paid', 'free']),
            "price" => $this->faker->randomDigitNotZero(),
            "slots" => $this->faker->randomDigitNotZero(),
            "status" => $this->faker->randomElement(['active', 'inactive']),
        ]);
    }
}
