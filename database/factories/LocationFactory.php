<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->company(),
            'latitude' => fake()->latitude(-32, 2.3),
            'longitude' => fake()->longitude(-33, -64),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
