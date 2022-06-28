<?php

namespace Tests\Feature\Event;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Traits\IsActiveUser;
use Tests\TestCase;

class UserCanSeeEventsTheyCreatedTest extends TestCase
{
    use WithFaker, IsActiveUser;

    /**
     * User cannot see event without login in first
     *
     * @return void
     */
    public function testUserCannotSeeTheirEventWithoutFirstLoging()
    {
        $response = $this->get('/api/event/show', []);

        $response->assertStatus(401);
    }

    /**
     * User cann see event without filling the form correctly
     *
     * @return void
     */
    public function testUserCanSeeEventTheyCreated()
    {
        $response = $this->get('/api/event/show', $this->activeUser());

        $response->assertStatus(200);
    }
}
