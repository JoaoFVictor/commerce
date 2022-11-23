<?php

namespace Tests\Feature\Notificacao\ClienteTopico;

use App\Models\Notificacao\NotificacaoClienteTopico;
use App\Models\Usuario;
use Tests\TestCase;

class ApagarTest extends TestCase
{
    private const ROTA = 'notificacao.clientes.topicos.destroy';

    private const ID_INVALIDO = 0;

    public function testClienteTopicoNaoEncontrada()
    {
        $usuario = Usuario::factory()->create();
        $response = $this->actingAs($usuario)->deleteJson(route(self::ROTA, self::ID_INVALIDO));

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testUsuarioInvalido()
    {
        $clienteTopico = NotificacaoClienteTopico::factory()->create();
        $response = $this->deleteJson(route(self::ROTA, $clienteTopico->getKey()));

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();
        $clienteTopico = NotificacaoClienteTopico::factory()->create();
        $response = $this->actingAs($usuario)->deleteJson(route(self::ROTA, $clienteTopico->getKey()));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
            ]);
    }
}
