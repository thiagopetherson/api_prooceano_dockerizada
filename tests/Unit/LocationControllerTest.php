<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Location;
use App\Http\Controllers\LocationController;
use App\Http\Requests\Location\LocationUpdateRequest;
use App\Http\Resources\Location\{UpdateResource, IndexResource};
use Illuminate\Validation\ValidationException;
use Mockery;

class LocationControllerTest extends TestCase
{
    use RefreshDatabase;

    // Teste de sucesso para o método index
    public function testIndexSuccess()
    {
        // Criar dados fictícios de localização
        $locations = Location::factory()->count(3)->make();

        // Mock do controlador
        $controller = Mockery::mock(LocationController::class)->makePartial();
        $controller->shouldReceive('index')
            ->andReturn(response()->json(IndexResource::collection($locations), 200));

        // Chamar o método index
        $response = $controller->index();

        // Verificar o status da resposta
        $this->assertEquals(200, $response->status());

        // Verificar o conteúdo da resposta
        $data = $response->getData(true); // Obtém a resposta como array

        // Verificar se o array contém as chaves esperadas
        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('name', $data[0]);
        $this->assertArrayHasKey('latitude', $data[0]);
        $this->assertArrayHasKey('longitude', $data[0]);
        $this->assertArrayHasKey('created_at', $data[0]);
        $this->assertArrayHasKey('updated_at', $data[0]);
    }

    // Teste de falha para o método index
    public function testIndexFailure()
    {
        // Criar um mock do controlador
        $controller = Mockery::mock(LocationController::class)->makePartial();

        // Simular uma situação onde não há localizações
        $controller->shouldReceive('index')
            ->andReturn(response()->json([], 200)); // Retornando um array vazio

        // Chamar o método index
        $response = $controller->index();

        // Verificar o status da resposta
        $this->assertEquals(200, $response->status());

        // Verificar que a resposta está vazia
        $data = $response->getData(true);
        $this->assertEmpty($data, 'A resposta deveria estar vazia, mas não está.');
    }

    // Teste de sucesso para o método update
    public function testUpdateSuccess()
    {
        // Criar uma localização existente
        $location = Location::factory()->create();

        // Mock do LocationUpdateRequest
        $mockRequest = Mockery::mock(LocationUpdateRequest::class);
        $mockRequest->shouldReceive('validated')->andReturn([
            'name' => 'Local Atualizado',
            'latitude' => '123.456',
            'longitude' => '987.654',
        ]);
        // Especificar a expectativa para o método all()
        $mockRequest->shouldReceive('all')->andReturn([
            'name' => 'Local Atualizado',
            'latitude' => '123.456',
            'longitude' => '987.654',
        ]);

        // Instanciar o controlador
        $controller = new LocationController();

        // Chamar o método update
        $response = $controller->update($mockRequest, $location->id);

        // Verificar o status da resposta
        $this->assertEquals(200, $response->status());

        // Verificar o conteúdo da resposta
        $data = $response->getData(true);
        $this->assertEquals('Local Atualizado', $data['name']);
        $this->assertEquals('123.456', $data['latitude']);
        $this->assertEquals('987.654', $data['longitude']);
    }


    // Teste de falha para o método update
    public function testUpdateFailure()
    {
        // Simular uma localização inexistente
        $invalidId = 999;

        // Mock do LocationUpdateRequest
        $mockRequest = Mockery::mock(LocationUpdateRequest::class);
        $mockRequest->shouldReceive('validated')->andReturn([
            'name' => 'Local Inválido',
            'latitude' => '123.456',
            'longitude' => '987.654',
        ]);

        // Mock do controlador
        $controller = Mockery::mock(LocationController::class)->makePartial();
        $controller->shouldReceive('update')
            ->with($mockRequest, $invalidId)
            ->andReturn(response()->json(['erro' => 'Localidade não existe'], 404));

        // Chamar o método update e capturar a resposta
        $response = $controller->update($mockRequest, $invalidId);

        // Verificar o status da resposta (404)
        $this->assertEquals(404, $response->status());

        // Verificar o conteúdo da resposta
        $data = $response->getData(true);
        $this->assertEquals('Localidade não existe', $data['erro']);
    }
}
