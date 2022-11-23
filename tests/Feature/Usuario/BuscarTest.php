<?php

namespace Tests\Feature\Usuario;

use App\Models\Usuario;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BuscarTest extends TestCase
{
    private const ROTA = 'usuarios.show';

    private Usuario $usuario;

    public function setUp(): void
    {
        parent::setUp();
        $this->usuario = Usuario::factory()->create();
    }

    public function testFalhaUsuarioNaoLogado()
    {
        $response = $this->getJson(route(self::ROTA));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testSucesso()
    {
        $response = $this->actingAs($this->usuario)->getJson(route(self::ROTA));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'nome',
                    'email',
                    'status',
                    'telefone',
                    'plano',
                    'imagem',
                ],
            ]);
    }
}
