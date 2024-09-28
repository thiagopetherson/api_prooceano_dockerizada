<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\{Device, User, DeviceLocation};

class DeviceLocationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function device_location_method_index()
    {
        $this->withoutExceptionHandling();

        // Criando um usuário fictício
        $user = User::factory()->create();
        $this->actingAs($user);

        // Criando dispositivos e localizações
        $device = Device::factory()->create();
        DeviceLocation::factory()->create([
            'device_id' => $device->id,
            'latitude' => 12.34,
            'longitude' => 56.78,
            'temperature' => 25.00,
            'salinity' => null,
        ]);

        $response = $this->getJson('api/device-locations');

        $response->assertOk();
        $this->assertCount(1, DeviceLocation::all());

        $response->assertJson([
            [
                "id" => DeviceLocation::first()->id,
                "device_id" => $device->id,
                "latitude" => 12.34,
                "longitude" => 56.78,
                "temperature" => 25.00,
                "salinity" => null,
                "created_at" => DeviceLocation::first()->created_at->toISOString(),
                "updated_at" => DeviceLocation::first()->updated_at->toISOString(),
            ],
        ]);
    }

    /** @test */
    public function device_location_method_store_with_temperature()
    {
        $this->withoutExceptionHandling();

        // Criando um usuário fictício
        $user = User::factory()->create();
        $this->actingAs($user);

        $device = Device::factory()->create();

        $response = $this->postJson('api/device-locations', [
            'device_id' => $device->id,
            'latitude' => 12.34,
            'longitude' => 56.78,
            'temperature' => 25.00, // Certifique-se de que seja um número
            'salinity' => null,
        ])->assertStatus(201);

        $deviceLocation = DeviceLocation::first();

        $this->assertCount(1, DeviceLocation::all());

        $response->assertJson([
            "id" => $deviceLocation->id,
            "device_id" => $deviceLocation->device_id,
            "latitude" => $deviceLocation->latitude,
            "longitude" => $deviceLocation->longitude,
            "temperature" => $deviceLocation->temperature, // Verifique se o tipo é correto
            "salinity" => null,
        ]);
    }

    /** @test */
    public function device_location_method_store_with_salinity()
    {
        $this->withoutExceptionHandling();

        // Criando um usuário fictício
        $user = User::factory()->create();
        $this->actingAs($user);

        $device = Device::factory()->create();

        $response = $this->postJson('api/device-locations', [
            'device_id' => $device->id,
            'latitude' => 12.34,
            'longitude' => 56.78,
            'temperature' => null,
            'salinity' => 3.50, // Certifique-se de que seja um número
        ])->assertStatus(201);

        $deviceLocation = DeviceLocation::first();

        $this->assertCount(1, DeviceLocation::all());

        $response->assertJson([
            "id" => $deviceLocation->id,
            "device_id" => $deviceLocation->device_id,
            "latitude" => $deviceLocation->latitude,
            "longitude" => $deviceLocation->longitude,
            "temperature" => null,
            "salinity" => $deviceLocation->salinity, // Verifique se o tipo é correto
        ]);
    }

    /** @test */
    public function device_location_method_store_without_temperature_or_salinity()
    {       
        // Criando um usuário fictício
        $user = User::factory()->create();
        $this->actingAs($user);

        $device = Device::factory()->create();

        $response = $this->postJson('api/device-locations', [
            'device_id' => $device->id,
            'latitude' => 12.34,
            'longitude' => 56.78,
            'temperature' => null,
            'salinity' => null,
        ]);

        // Verifica se o status de erro de validação é retornado
        $response->assertStatus(422);
        $this->assertCount(0, DeviceLocation::all());

        // Verificar mensagens de erro específicas
        $response->assertJsonValidationErrors(['temperature', 'salinity']);
    }
}
