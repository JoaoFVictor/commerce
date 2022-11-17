<?php

namespace Tests\Feature\Cliente;

use App\Models\Cliente;
use App\Models\Usuario;
use Tests\TestCase;

class DetalharTest extends TestCase
{
    private const ROTA = 'cliente.show';

    public function testFalhaUsuarioNaoLogado()
    {
        $usuario = Usuario::factory()->create();
        $clienteUm = Cliente::factory()->create([
            'usuario_id' => $usuario->id,
        ]);

        $response = $this->getJson(route(self::ROTA, $clienteUm->id));

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testFalhaClienteNaoEncontrado()
    {
        $idInvalido = 0;
        $usuario = Usuario::factory()->create();

        $response = $this->actingAs($usuario)->getJson(route(self::ROTA, $idInvalido));

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();
        $clienteNovo = Cliente::factory()->create();

        $response = $this->actingAs($usuario)->getJson(route(self::ROTA, $clienteNovo->id));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'nome',
                    'telefone',
                    'bairro',
                    'rua',
                    'numero',
                    'cpf',
                ],
            ]);
    }
}
