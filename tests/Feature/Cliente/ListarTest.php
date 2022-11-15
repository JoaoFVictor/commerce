<?php

namespace Tests\Feature\Cliente;

use App\Models\Usuario;
use Tests\TestCase;

class ListarTest extends TestCase
{
    private const ROTA = 'cliente.index';

    public function testFalhaUsuarioNaoLogado()
    {
        $response = $this->getJson(route(self::ROTA));

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();

        $response = $this->actingAs($usuario)->getJson(route(self::ROTA));

        $response->assertStatus(200)
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
