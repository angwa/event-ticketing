<?php

namespace Tests\Feature\Ticket;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Traits\IsActiveUser;
use Tests\TestCase;

class UserCanCreateTicketTest extends TestCase
{
    use WithFaker, IsActiveUser;

    /**
     * User cannot create ticket without login in first
     *
     * @return void
     */
    public function testUserCannotCreateTicketWithoutFirstLoging()
    {
        $response = $this->postJson('/api/ticket/create', []);

        $response->assertStatus(401);
    }

    /**
     * User cannot create ticket without filling the form correctly
     *
     * @return void
     */
    public function testUserCannotCreateTicketithoutFillingFormProperly()
    {
        $this->postJson('/api/ticket/create', [], $this->activeUser())
            ->assertJsonValidationErrors([
                'event_id'    => 'The event id field is required.',
                'slot' => 'The slot field is required.',
            ]);
    }

    /**
     * User can create ticket when filling the form correctly
     *
     * @return void
     */
    public function testUserCannotCreateTicketByFillingFormProperly()
    {
        $response = $this->postJson('/api/ticket/create', [
            "event_id" => Event::factory()->create()->id,
            "slot" => $this->faker->randomDigitNotZero(),
        ], $this->activeUser());

        $response->assertStatus(201);
    }
}
