<?php

namespace Tests\Feature\Notificacao\Mensagem;

use App\Models\Notificacao\NotificacaoMensagem;
use App\Models\Usuario;
use Tests\TestCase;

class BuscarTest extends TestCase
{
    private const ROTA = 'notificacao.mensagem.show';

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
        $mensagem = NotificacaoMensagem::factory()->create();
        $response = $this->actingAs($usuario)->getJson(route(self::ROTA, $mensagem->getKey()));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'titulo',
                    'conteudo',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }
}
