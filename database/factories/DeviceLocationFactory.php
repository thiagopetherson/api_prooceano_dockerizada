<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\{Device, DeviceLocation};

class DeviceLocationFactory extends Factory
{
    protected $model = DeviceLocation::class;

    public function definition()
    {
        // Decide aleatoriamente se a temperatura ou a salinidade será usada
        if ($this->faker->boolean) {
            return [
                'device_id' => Device::factory(),
                'latitude' => $this->faker->latitude,
                'longitude' => $this->faker->longitude,
                'temperature' => $this->faker->randomFloat(2, 0, 100), // Define temperatura
                'salinity' => null, // Define salinidade como nula
            ];
        } else {
            return [
                'device_id' => Device::factory(),
                'latitude' => $this->faker->latitude,
                'longitude' => $this->faker->longitude,
                'temperature' => null, // Define temperatura como nula
                'salinity' => $this->faker->randomFloat(2, 0, 100), // Define salinidade
            ];
        }
    }
}
