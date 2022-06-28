<?php

namespace Tests\Feature\Event;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Traits\IsActiveUser;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class UpdateEventTest extends TestCase
{
    use WithFaker;

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
     * User cannot update event without login in first
     *
     * @return void
     */
    public function testUserCannotUpdateEventWithoutLogin()
    {
        $response = $this->patchJson('/api/event/update/' . $this->event->id, []);

        $response->assertStatus(401);
    }
    /**
     * User cannot update event with invalid event
     *
     * @return void
     */
    public function testUserCannotUpdateAnInvalidEvent()
    {
        $response = $this->patchJson('/api/event/update/0', $this->token);

        $response->assertStatus(404);
    }

    /**
     * User cann update event without filling the form correctly
     *
     * @return void
     */
    public function testUserCannotUpdateEventTheyDidNotCreate()
    {
        $response = $this->patchJson('/api/event/update/' . $this->event->id, [
            "name" => $this->faker->name(),
            "location" => $this->faker->address(),
            "description" => $this->faker->text(),
            "date" => "03.05.2028",
            "type" => $this->faker->randomElement(['paid', 'free']),
            "price" => $this->faker->randomDigitNotZero(),
            "slots" => $this->faker->randomDigitNotZero(),
            "status" => $this->faker->randomElement(['active', 'inactive']),
        ],  $this->token);

        $response->assertStatus(403);
    }

    /**
     * User cann update event without filling the form correctly
     *
     * @return void
     */
    public function testUserCanUpdateEventTheyCreated()
    {
        $response = $this->patchJson('/api/event/update/' . $this->newEvent($this->user)->id, [
            "name" => $this->faker->name(),
            "location" => $this->faker->address(),
            "description" => $this->faker->text(),
            "date" => "03.05.2028",
            "type" => $this->faker->randomElement(['paid', 'free']),
            "price" => $this->faker->randomDigitNotZero(),
            "slots" => $this->faker->randomDigitNotZero(),
            "status" => $this->faker->randomElement(['active', 'inactive']),
        ],  $this->token);

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
