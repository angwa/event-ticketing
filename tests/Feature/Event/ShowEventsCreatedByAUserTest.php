<?php

namespace Tests\Feature\Event;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Traits\IsActiveUser;
use Tests\TestCase;

class ShowEventsCreatedByAUserTest extends TestCase
{
    use WithFaker, IsActiveUser;

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
     * User cannot see event without login in first
     *
     * @return void
     */
    public function testUserCannotSeeEventWithoutFirstLoging()
    {
        $response = $this->get('/api/event/show/'.$this->user->id, []);
    
        $response->assertStatus(401);
    }

    /**
     * User cann see event without filling the form correctly
     *
     * @return void
     */
    public function testUserCanSeeEventsForAUser()
    {
        $response = $this->get('/api/event/show/'.$this->user->id, $this->activeUser());

        $response->assertStatus(200);
    }
}
