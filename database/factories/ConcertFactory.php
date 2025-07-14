<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Concert>
 */
class ConcertFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3, true),
            'tags' => implode(', ', $this->faker->randomElements(['rock', 'pop', 'jazz', 'electronic', 'classical'], 2)),
            'company' => $this->faker->company(),
            'location_id' => Location::factory(),
            'email' => $this->faker->safeEmail(),
            'website' => $this->faker->url(),
            'description' => $this->faker->paragraph(),
            'concert_date' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'ticket_limit' => $this->faker->numberBetween(100, 10000),
        ];
    }
}
