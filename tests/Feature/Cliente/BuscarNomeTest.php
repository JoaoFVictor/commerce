<?php

namespace Tests\Feature\Cliente;

use App\Models\Cliente;
use App\Models\Usuario;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BuscarNomeTest extends TestCase
{
    private const ROTA = 'cliente.listar.nome';

    public function testFalhaUsuarioNaoLogado()
    {
        $usuario = Usuario::factory()->create();
        $clienteUm = Cliente::factory()->create([
            'usuario_id' => $usuario->id,
        ]);

        $response = $this->getJson(route(self::ROTA, $clienteUm->nome));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();
        $cliente = Cliente::factory()->create();

        $response = $this->actingAs($usuario)->getJson(route(self::ROTA, $cliente->nome));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [],
            ]);
    }
}
