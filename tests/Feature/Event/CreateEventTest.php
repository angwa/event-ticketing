<?php

namespace Tests\Feature\Event;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Traits\IsActiveUser;
use Tests\TestCase;

class CreateEventTest extends TestCase
{
    use WithFaker, IsActiveUser;

    /**
     * User cannot create event without login in first
     *
     * @return void
     */
    public function testUserCannotCreateEventWithoutFirstLoging()
    {
        $response = $this->postJson('/api/event/create', []);

        $response->assertStatus(401);
    }

    /**
     * User cannot create event without filling the form correctly
     *
     * @return void
     */
    public function testUserCannotCreateEventWithoutFillingFormProperly()
    {
        $this->postJson('/api/event/create', [], $this->activeUser())
            ->assertJsonValidationErrors([
                'name'    => 'The name field is required.',
                'location' => 'The location field is required.',
                'date' => 'The date field is required.',
                'type' => 'The type field is required.',
            ]);
    }

    /**
     * User can create event when filling the form correctly
     *
     * @return void
     */
    public function testUserCanCreateEventByFillingFormProperly()
    {
        $response = $this->postJson('/api/event/create', [
            "name" => $this->faker->name(),
            "location" => $this->faker->address(),
            "description" => $this->faker->text(),
            "date" =>"03.05.2028",
            "type" => $this->faker->randomElement(['paid', 'free']),
            "price" =>$this->faker->randomDigitNotZero(),
            "slots" =>$this->faker->randomDigitNotZero(),
            "status" => $this->faker->randomElement(['active', 'inactive']),
        ], $this->activeUser());

        $response->assertStatus(201);
    }
}
