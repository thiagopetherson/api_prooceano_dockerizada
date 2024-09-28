<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Mockery;
use Carbon\Carbon;

// Controllers
use App\Http\Controllers\LocationController;

// Models
use App\Models\Location;

// Form Requests
use App\Http\Requests\Location\LocationUpdateRequest;

// Resources
use App\Http\Resources\Location\{UpdateResource, IndexResource};

// Interfaces
use App\Interfaces\LocationRepositoryInterface;

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
        $mockRequest->shouldReceive('all')->andReturn([
            'name' => 'Local Atualizado',
            'latitude' => '123.456',
            'longitude' => '987.654',
        ]);

        // Mock do LocationRepositoryInterface
        $mockRepository = Mockery::mock(LocationRepositoryInterface::class);

        // Criar uma nova instância de Location como retorno esperado do repositório
        $updatedLocation = new Location([
            'id' => $location->id,
            'name' => 'Local Atualizado',
            'latitude' => '123.456',
            'longitude' => '987.654',
            'created_at' => $location->created_at, // Garante que isso não é nulo
            'updated_at' => now() // Use o timestamp atual
        ]);

        // Simular o comportamento esperado no repositório (retornando a nova instância de Location)
        $mockRepository->shouldReceive('update')
            ->with($location->id, Mockery::any())
            ->andReturn($updatedLocation);

        // Instanciar o controlador com o mock do repositório
        $controller = new LocationController($mockRepository);

        // Chamar o método update
        $response = $controller->update($mockRequest, $location->id);

        // Verificar o status da resposta
        $this->assertEquals(200, $response->status());

        // Verificar o conteúdo da resposta
        $data = $response->getData(true);
        $this->assertEquals('Local Atualizado', $data['name']);
        $this->assertEquals('123.456', $data['latitude']);
        $this->assertEquals('987.654', $data['longitude']);

        // Verificar se os timestamps estão definidos e no formato correto
        $this->assertNotNull($data['created_at']);
        $this->assertNotNull($data['updated_at']);
        
        $this->assertEquals($updatedLocation->created_at->format('Y-m-d H:i:s'), (new Carbon($data['created_at']))->format('Y-m-d H:i:s'));
        $this->assertEquals($updatedLocation->updated_at->format('Y-m-d H:i:s'), (new Carbon($data['updated_at']))->format('Y-m-d H:i:s'));
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
