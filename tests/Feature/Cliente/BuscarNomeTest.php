<?php

namespace Tests\Feature\Cliente;

use App\Models\Cliente;
use App\Models\Usuario;
use Tests\TestCase;

class BuscarNomeTest extends TestCase
{
    private const ROTA = 'cliente.buscar.nome';

    public function testFalhaUsuarioNaoLogado()
    {
        $usuario = Usuario::factory()->create();
        $clienteUm = Cliente::factory()->create([
            'usuario_id' => $usuario->getKey(),
        ]);

        $response = $this->getJson(route(self::ROTA, $clienteUm->nome));

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();
        $cliente = Cliente::factory()->create();

        $response = $this->actingAs($usuario)->getJson(route(self::ROTA, $cliente->nome));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [],
            ]);
    }
}