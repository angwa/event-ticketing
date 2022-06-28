<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

class EventFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "user_id" => User::factory()->create()->id,
            "name" => $this->faker->name(),
            "location" => $this->faker->address(),
            "description" => $this->faker->text(),
            "date" => Carbon::parse("03.05.2028"),
            "type" => $this->faker->randomElement(['paid', 'free']),
            "price" => $this->faker->randomDigitNotZero(),
            "slots" => $this->faker->randomDigitNotZero(),
            "status" => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
