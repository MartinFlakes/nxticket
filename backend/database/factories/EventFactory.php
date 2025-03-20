<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Event;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'title' => $this->faker->name,
            'description' => $this->faker->text(),
            'start_date' => now(),
            'end_date' => now()->addDays(2),
            'category_id' => Category::all()->random(), // asigna id de la collecion
            'venue_id' => \App\Models\Venue::all()->random()->id, 
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null

        ];
    }
}
