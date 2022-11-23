<?php

namespace Tests\Feature\Notificacao\Topico;

use App\Models\Notificacao\NotificacaoTopico;
use App\Models\Usuario;
use Tests\TestCase;

class AtualizarTest extends TestCase
{
    private const ROTA = 'notificacao.topico.update';

    private const ID_INVALIDO = 0;

    public function testFalhaValoresGrandes()
    {
        $usuario = Usuario::factory()->create();
        $topico = NotificacaoTopico::factory()->create();
        $valoresGrandes = str_pad('', 101, 'A');
        $novosDados = [
            'nome' => $valoresGrandes,
        ];

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $topico->getKey()), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'nome',
                ],
            ]);
    }

    public function testFalhaTiposValores()
    {
        $usuario = Usuario::factory()->create();
        $topico = NotificacaoTopico::factory()->create();
        $dadosIncorreto = [
            'nome' => 13,
        ];

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $topico->getKey()), $dadosIncorreto);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'nome',
                ],
            ]);
    }

    public function testUsuarioInvalido()
    {
        $topico = NotificacaoTopico::factory()->create();
        $response = $this->putJson(route(self::ROTA, $topico->getKey()));

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testFalhaTopicoNaoEncontrado()
    {
        $usuario = Usuario::factory()->create();
        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, self::ID_INVALIDO));

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();
        $topico = NotificacaoTopico::factory()->create();
        $dados = [
            'nome' => 'titulo',
        ];

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $topico->getKey()), $dados);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'nome',
                ],
            ]);
    }
}
