<?php

namespace Tests\Feature\Notificacao\ClienteTopico;

use App\Models\Notificacao\NotificacaoClienteTopico;
use App\Models\Usuario;
use Tests\TestCase;

class BuscarTest extends TestCase
{
    private const ROTA = 'notificacao.clientes.topicos.show';

    private const ID_INVALIDO = 0;

    public function testMensagemNaoEncontrada()
    {
        $usuario = Usuario::factory()->create();
        $response = $this->actingAs($usuario)->getJson(route(self::ROTA, self::ID_INVALIDO));

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();
        $clienteTopico = NotificacaoClienteTopico::factory()->create();
        $response = $this->actingAs($usuario)->getJson(route(self::ROTA, $clienteTopico->getKey()));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'cliente_id',
                    'cliente_nome',
                    'topico_id',
                    'topico_nome',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }
}
