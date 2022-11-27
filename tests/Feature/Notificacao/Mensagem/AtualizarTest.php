<?php

namespace Tests\Feature\Notificacao\Mensagem;

use App\Models\Notificacao\NotificacaoMensagem;
use App\Models\Notificacao\NotificacaoTopico;
use App\Models\Usuario;
use Tests\TestCase;

class AtualizarTest extends TestCase
{
    private const ROTA = 'notificacao.mensagem.update';

    private const ID_INVALIDO = 0;

    public function testFalhaValoresGrandes()
    {
        $usuario = Usuario::factory()->create();
        $mensagem = NotificacaoMensagem::factory()->create();
        $valoresGrandes = str_pad('', 101, 'A');
        $novosDados = [
            'titulo' => $valoresGrandes,
            'conteudo' => $valoresGrandes,
            'usuario_id' => Usuario::factory()->create(),
            'topico_id' => NotificacaoTopico::factory()->create(),
        ];

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $mensagem->getKey()), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'titulo',
                    'conteudo',
                ],
            ]);
    }

    public function testFalhaCampoObrigatorio()
    {
        $usuario = Usuario::factory()->create();
        $mensagem = NotificacaoMensagem::factory()->create();
        $novosDados = [
            'titulo' => null,
            'conteudo' => null,
            'usuario_id' => null,
            'topico_id' => null,
        ];

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $mensagem->getKey()), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'titulo',
                    'conteudo',
                    'usuario_id',
                    'topico_id',
                ],
            ]);
    }

    public function testFalhaTiposValores()
    {
        $usuario = Usuario::factory()->create();
        $mensagem = NotificacaoMensagem::factory()->create();
        $dadosIncorreto = [
            'titulo' => 13,
            'conteudo' => 13,
            'usuario_id' => 'valor',
            'topico_id' => 'valor',
        ];

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $mensagem->getKey()), $dadosIncorreto);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'titulo',
                    'conteudo',
                    'usuario_id',
                    'topico_id',
                ],
            ]);
    }

    public function testUsuarioInvalido()
    {
        $mensagem = NotificacaoMensagem::factory()->create();
        $response = $this->putJson(route(self::ROTA, $mensagem->getKey()));

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testCampoUsuarioInvalido()
    {
        $usuario = Usuario::factory()->create();
        $mensagem = NotificacaoMensagem::factory()->create();
        $dadosIncorreto = [
            'titulo' => 'titulo',
            'conteudo' => 'conteudo',
            'usuario_id' => self::ID_INVALIDO,
            'topico_id' => NotificacaoTopico::factory()->create(),
        ];

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $mensagem->getKey()), $dadosIncorreto);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'usuario_id',
                ],
            ]);
    }

    public function testCampoTopicoInvalido()
    {
        $usuario = Usuario::factory()->create();
        $mensagem = NotificacaoMensagem::factory()->create();
        $dadosIncorreto = [
            'titulo' => 'titulo',
            'conteudo' => 'conteudo',
            'usuario_id' => Usuario::factory()->create(),
            'topico_id' => self::ID_INVALIDO,
        ];

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $mensagem->getKey()), $dadosIncorreto);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'topico_id',
                ],
            ]);
    }

    public function testFalhaMensagemNaoEncontrado()
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
        $mensagem = NotificacaoMensagem::factory()->create();
        $dadosCorretos = [
            'titulo' => 'titulo',
            'conteudo' => 'conteudo',
            'usuario_id' => Usuario::factory()->create()->getKey(),
            'topico_id' => NotificacaoTopico::factory()->create()->getKey(),
        ];

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $mensagem->getKey()), $dadosCorretos);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'titulo',
                    'conteudo',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }
}
