<?php

namespace Tests\Feature\Notificacao\Topico;

use App\Models\Notificacao\NotificacaoTopico;
use App\Models\Usuario;
use Tests\TestCase;

class ApagarTest extends TestCase
{
    private const ROTA = 'notificacao.topico.destroy';

    private const ID_INVALIDO = 0;

    public function testTopicoNaoEncontrada()
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
        $topico = NotificacaoTopico::factory()->create();
        $response = $this->deleteJson(route(self::ROTA, $topico->getKey()));

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();
        $topico = NotificacaoTopico::factory()->create();
        $response = $this->actingAs($usuario)->deleteJson(route(self::ROTA, $topico->getKey()));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
            ]);
    }
}
