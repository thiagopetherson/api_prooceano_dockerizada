<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Device;
use App\Models\User;

class DeviceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function device_method_index()
    {
        $this->withoutExceptionHandling();

        // Criando um usuário fictício
        $user = User::factory()->create();

        //Isso aqui configura como se esse usuário estivesse logado
        $this->actingAs($user);

        $devices = Device::factory(2)->create();

        $response = $this->getJson('api/devices');

        $response->assertStatus(200)->assertOk();

        $devices = Device::all();

        $response->assertJson([
            [
                "id" => $devices->first()->id,
                "name" => $devices->first()->name,
                "description" => $devices->first()->description,               
                "created_at" => $devices->first()->created_at,
                "updated_at" => $devices->first()->updated_at
            ],
            [
                "id" => $devices->last()->id,
                "name" => $devices->last()->name,
                "description" => $devices->last()->description,               
                "created_at" => $devices->last()->created_at,
                "updated_at" => $devices->last()->updated_at
            ]
        ]);
    }

    /** @test */
    public function device_method_show()
    {
        $this->withoutExceptionHandling();

        // Criando um usuário fictício
        $user = User::factory()->create();

        //Isso aqui configura como se esse usuário estivesse logado
        $this->actingAs($user);

        $device = Device::factory()->create();

        $response = $this->getJson("api/devices/{$device->id}");

        $response->assertOk();

        $this->assertCount(1, Device::all());

        $response->assertJson(
            [
                "id" => $device->id,
                "name" => $device->name,
                "description" => $device->description,               
                "created_at" => $device->created_at,
                "updated_at" => $device->updated_at
            ]
        );
    }

    /** @test */
    public function device_method_store()
    {
        $this->withoutExceptionHandling();
 
        // Criando um usuário fictício
        $user = User::factory()->create();
 
        //Isso aqui configura como se esse usuário estivesse logado
        $this->actingAs($user);
  
        $response = $this->postJson('api/devices',[
            'name' => 'Equipamento Interestelar',
            'description' => 'Medição de um parâmetro qualquer'                       
        ])->assertStatus(200);
  
        $device = Device::first();
  
        $this->assertCount(1, Device::all());
  
        $this->assertEquals('Equipamento Interestelar', $device->name);
        $this->assertEquals('Medição de um parâmetro qualquer', $device->description);
  
        $response->assertJson(
            [
                "id" => $device->id,
                "name" => $device->name,
                "description" => $device->description
            ]
        );
    }

    /** @test */
    public function device_method_update()
    {
        $this->withoutExceptionHandling();

        // Criando um usuário fictício
        $user = User::factory()->create();

        //Isso aqui configura como se esse usuário estivesse logado
        $this->actingAs($user);

        $device = Device::factory()->create();

        $response = $this->putJson("api/devices/{$device->id}",[
            'name' => 'Equipamento Maré',
            'description' => 'Medição de um outro parâmetro qualquer'           
        ])->assertStatus(200);

        $this->assertCount(1, Device::all());

        $device = $device->fresh();

        $this->assertEquals('Equipamento Maré', $device->name);
        $this->assertEquals('Medição de um outro parâmetro qualquer', $device->description);

        $response->assertJson(
            [
                "id" => $device->id,
                "name" => $device->name,
                "description" => $device->description
            ]
        );
    }

    /** @test */
    public function device_method_destroy()
    {
        $this->withoutExceptionHandling();

        // Criando um usuário fictício
        $user = User::factory()->create();

        //Isso aqui configura como se esse usuário estivesse logado
        $this->actingAs($user);

        $device = Device::factory()->create();

        $response = $this->deleteJson("api/devices/{$device->id}")->assertNoContent();

        $this->assertCount(0, Device::all());
    }
   
}
