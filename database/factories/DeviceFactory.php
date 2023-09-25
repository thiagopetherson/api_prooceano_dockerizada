<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
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
            'description' => fake()->word(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
