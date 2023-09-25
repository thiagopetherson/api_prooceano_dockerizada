<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Location;
use App\Models\User;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function location_method_index()
    {
        $this->withoutExceptionHandling();

        // Criando um usuário fictício
        $user = User::factory()->create();

        //Isso aqui configura como se esse usuário estivesse logado
        $this->actingAs($user);

        $locations = Location::factory(2)->create();

        $response = $this->getJson('api/locations');

        $response->assertStatus(200)->assertOk();

        $locations = Location::all();

        $response->assertJson([
            [
                "id" => $locations->first()->id,
                "name" => $locations->first()->name,
                "latitude" => $locations->first()->latitude,
                "longitude" => $locations->first()->longitude,
                "created_at" => $locations->first()->created_at,
                "updated_at" => $locations->first()->updated_at
            ],
            [
                "id" => $locations->last()->id,
                "name" => $locations->last()->name,
                "latitude" => $locations->last()->latitude,
                "longitude" => $locations->last()->longitude,
                "created_at" => $locations->last()->created_at,
                "updated_at" => $locations->last()->updated_at
            ]
        ]);
    }

    /** @test */
    public function location_method_show()
    {
        $this->withoutExceptionHandling();

        // Criando um usuário fictício
        $user = User::factory()->create();

        //Isso aqui configura como se esse usuário estivesse logado
        $this->actingAs($user);

        $location = Location::factory()->create();

        $response = $this->getJson("api/locations/{$location->id}");

        $response->assertOk();

        $this->assertCount(1, Location::all());

        $response->assertJson(
            [
                "id" => $location->id,
                "name" => $location->name,
                "latitude" => $location->latitude,
                "longitude" => $location->longitude,
                "created_at" => $location->created_at,
                "updated_at" => $location->updated_at
            ]
        );
    }

    /** @test */
    public function location_method_store()
    {
        $this->withoutExceptionHandling();

        // Criando um usuário fictício
        $user = User::factory()->create();

        //Isso aqui configura como se esse usuário estivesse logado
        $this->actingAs($user);
 
        $response = $this->postJson('api/locations',[
            'name' => 'Pousada Majestic',
            'latitude' => '-20.29700099971624',
            'longitude' => '-40.322439720783834'            
        ])->assertStatus(200);
 
        $location = Location::first();
 
        $this->assertCount(1, Location::all());
 
        $this->assertEquals('Pousada Majestic', $location->name);
        $this->assertEquals('-20.29700099971624', $location->latitude);
        $this->assertEquals('-40.322439720783834', $location->longitude);
 
        $response->assertJson(
            [
                "id" => $location->id,
                "name" => $location->name,
                "latitude" => $location->latitude,
                "longitude" => $location->longitude
            ]
        );
    }

    /** @test */
    public function location_method_update()
    {
        $this->withoutExceptionHandling();

        // Criando um usuário fictício
        $user = User::factory()->create();

        //Isso aqui configura como se esse usuário estivesse logado
        $this->actingAs($user);

        $location = Location::factory()->create();

        $response = $this->putJson("api/locations/{$location->id}",[
            'name' => 'Parque Ipanema',
            'latitude' => '-19.466404616803356',
            'longitude' => '-42.54176521394513'
        ])->assertStatus(200);

        $this->assertCount(1, Location::all());

        $location = $location->fresh();

        $this->assertEquals('Parque Ipanema', $location->name);
        $this->assertEquals('-19.466404616803356', $location->latitude);
        $this->assertEquals('-42.54176521394513', $location->longitude);

        $response->assertJson(
            [
                "id" => $location->id,
                "name" => $location->name,
                "latitude" => $location->latitude,
                "longitude" => $location->longitude
            ]
        );
    }

    /** @test */
    public function location_method_destroy()
    {
        $this->withoutExceptionHandling();

        // Criando um usuário fictício
        $user = User::factory()->create();

        //Isso aqui configura como se esse usuário estivesse logado
        $this->actingAs($user);

        $location = Location::factory()->create();

        $response = $this->deleteJson("api/locations/{$location->id}")->assertNoContent();

        $this->assertCount(0, Location::all());
    }
}
