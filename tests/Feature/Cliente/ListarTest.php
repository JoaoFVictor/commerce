<?php

namespace Tests\Feature\Cliente;

use App\Models\Usuario;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ListarTest extends TestCase
{
    private const ROTA = 'cliente.index';

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
        $usuario = Usuario::factory()->create();

        $response = $this->actingAs($usuario)->getJson(route(self::ROTA));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nome',
                        'telefone',
                        'bairro',
                        'rua',
                        'numero',
                        'cpf',
                    ],
                ],
            ]);
    }
}
