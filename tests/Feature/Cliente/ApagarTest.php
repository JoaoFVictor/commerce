<?php

namespace Tests\Feature\Cliente;

use App\Models\Cliente;
use App\Models\Usuario;
use Tests\TestCase;

class ApagarTest extends TestCase
{
    private const ROTA = 'cliente.destroy';

    public function testFalhaUsuarioNaoLogado()
    {
        $usuario = Usuario::factory()->create();
        $clienteUm = Cliente::factory()->create([
            'usuario_id' => $usuario->getKey(),
        ]);

        $response = $this->deleteJson(route(self::ROTA, $clienteUm->getKey()));

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testFalhaClienteNaoEncontrado()
    {
        $usuario = Usuario::factory()->create();
        $idInvalido = 0;

        $response = $this->actingAs($usuario)->deleteJson(route(self::ROTA, $idInvalido));

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
                'exception',
                'file',
                'line',
                'trace' => [],
            ]);
    }

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();
        $clienteNovo = Cliente::factory()->create();

        $response = $this->actingAs($usuario)->deleteJson(route(self::ROTA, $clienteNovo->getKey()));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
            ]);
    }
}
