<?php

namespace Tests\Feature\Cliente;

use App\Models\Cliente;
use App\Models\Usuario;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ApagarTest extends TestCase
{
    private const ROTA = 'cliente.destroy';

    public function testFalhaUsuarioNaoLogado()
    {
        $usuario = Usuario::factory()->create();
        $clienteUm = Cliente::factory()->create([
            'usuario_id' => $usuario->id,
        ]);

        $response = $this->deleteJson(route(self::ROTA, $clienteUm->id));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testFalhaClienteNaoEncontrado()
    {
        $usuario = Usuario::factory()->create();
        $idInvalido = 0;

        $response = $this->actingAs($usuario)->deleteJson(route(self::ROTA, $idInvalido));

        $response->assertStatus(Response::HTTP_NOT_FOUND)
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

        $response = $this->actingAs($usuario)->deleteJson(route(self::ROTA, $clienteNovo->id));

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
            ]);
    }
}
