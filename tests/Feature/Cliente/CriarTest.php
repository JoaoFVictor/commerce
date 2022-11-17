<?php

namespace Tests\Feature\Cliente;

use App\Models\Cliente;
use App\Models\Usuario;
use Tests\TestCase;

class CriarTest extends TestCase
{
    private const ROTA = 'cliente.store';

    public function testFalhaUsuarioNaoLogado()
    {
        $response = $this->postJson(route(self::ROTA));

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testFalhaValoresGrandes()
    {
        $usuario = Usuario::factory()->create();
        $valoresGrandes = str_pad('', 101, 'A');
        $novosDados = [
            'nome' => $valoresGrandes,
            'telefone' => $valoresGrandes,
            'bairro' => $valoresGrandes,
            'rua' => $valoresGrandes,
            'numero' => $valoresGrandes,
            'cpf' => $valoresGrandes,
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $novosDados);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'nome',
                    'telefone',
                    'bairro',
                    'rua',
                    'numero',
                    'cpf',
                ],
            ]);
    }

    public function testFalhaCampoObrigatorio()
    {
        $usuario = Usuario::factory()->create();
        $novosDados = [
            'nome' => null,
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $novosDados);

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
        $novosDadosIncorreto = [
            'nome' => 13,
            'telefone' => 13,
            'bairro' => 13,
            'rua' => 13,
            'numero' => 13,
            'cpf' => 13,
        ];

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $novosDadosIncorreto);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'nome',
                    'telefone',
                    'bairro',
                    'rua',
                    'numero',
                    'cpf',
                ],
            ]);
    }

    public function testFalhaCpfRegistradoNoMesmoUsuario()
    {
        $usuario = Usuario::factory()->create();
        Cliente::factory()->create([
            'usuario_id' => $usuario->id,
        ]);
        $clienteNovo = Cliente::factory()->make([
            'usuario_id' => $usuario->id,
        ]);

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $clienteNovo->toArray());

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'cpf',
                ],
            ]);
    }

    public function testFalhaCpfInvalido()
    {
        $usuario = Usuario::factory()->create();
        $clienteNovo = Cliente::factory()->make([
            'cpf' => '11111111111',
        ]);

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $clienteNovo->toArray());

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'cpf',
                ],
            ]);
    }

    public function testFalhaTelefoneInvalido()
    {
        $usuario = Usuario::factory()->create();
        $clienteNovo = Cliente::factory()->make([
            'telefone' => '3832152201',
        ]);

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $clienteNovo->toArray());

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'telefone',
                ],
            ]);
    }

    public function testSucesso()
    {
        $usuario = Usuario::factory()->create();
        $clienteNovo = Cliente::factory()->make();

        $response = $this->actingAs($usuario)->postJson(route(self::ROTA), $clienteNovo->toArray());

        $response->assertStatus(201)
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
