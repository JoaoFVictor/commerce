<?php

namespace Tests\Feature\Notificacao\Mensagem;

use App\Models\Notificacao\NotificacaoMensagem;
use App\Models\Usuario;
use Tests\TestCase;

class ApagarTest extends TestCase
{
    private const ROTA = 'notificacao.mensagem.destroy';

    private const ID_INVALIDO = 0;

    public function testMensagemNaoEncontrada()
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
        $mensagem = NotificacaoMensagem::factory()->create();
        $response = $this->deleteJson(route(self::ROTA, $mensagem->getKey()));

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();
        $mensagem = NotificacaoMensagem::factory()->create();
        $response = $this->actingAs($usuario)->deleteJson(route(self::ROTA, $mensagem->getKey()));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
            ]);
    }
}
