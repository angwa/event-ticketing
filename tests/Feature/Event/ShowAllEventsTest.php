<?php

namespace Tests\Feature\Event;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Traits\IsActiveUser;
use Tests\TestCase;

class ShowAllEventsTest extends TestCase
{
    use WithFaker, IsActiveUser;

    /**
     * User cannot see event without login in first
     *
     * @return void
     */
    public function testUserCannotSeeAllEventWithoutFirstLoging()
    {
        $response = $this->get('/api/event/all', []);

        $response->assertStatus(401);
    }

    /**
     * User cann see all events when logged in.
     *
     * @return void
     */
    public function testUserCanSeeAllEvents()
    {
        $response = $this->get('/api/event/all', $this->activeUser());

        $response->assertStatus(200);
    }
}
