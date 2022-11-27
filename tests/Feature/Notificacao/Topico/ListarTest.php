<?php

namespace Tests\Feature\Notificacao\Topico;

use App\Models\Notificacao\NotificacaoMensagem;
use App\Models\Usuario;
use Tests\TestCase;

class ListarTest extends TestCase
{
    private const ROTA = 'notificacao.topico.index';

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();

        NotificacaoMensagem::factory()->create();

        $response = $this->actingAs($usuario)->getJson(route(self::ROTA));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nome',
                    ],
                ],
            ]);
    }
}
