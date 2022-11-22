<?php

namespace Tests\Feature\Cliente;

use App\Models\Cliente;
use App\Models\Usuario;
use Symfony\Component\HttpFoundation\Response;
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

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testFalhaClienteNaoEncontrado()
    {
        $idInvalido = 0;
        $usuario = Usuario::factory()->create();

        $response = $this->actingAs($usuario)->getJson(route(self::ROTA, $idInvalido));

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();
        $clienteNovo = Cliente::factory()->create();

        $response = $this->actingAs($usuario)->getJson(route(self::ROTA, $clienteNovo->id));

        $response->assertStatus(Response::HTTP_OK)
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
