<?php

namespace Tests\Feature\Notificacao\Topico;

use App\Models\Notificacao\NotificacaoTopico;
use App\Models\Usuario;
use Tests\TestCase;

class BuscarTest extends TestCase
{
    private const ROTA = 'notificacao.topico.show';

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
        $topico = NotificacaoTopico::factory()->create();
        $response = $this->actingAs($usuario)->getJson(route(self::ROTA, $topico->getKey()));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'nome',
                ],
            ]);
    }
}
