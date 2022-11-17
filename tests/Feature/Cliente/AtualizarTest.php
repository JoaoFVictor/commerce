<?php

namespace Tests\Feature\Cliente;

use App\Models\Cliente;
use App\Models\Usuario;
use Tests\TestCase;

class AtualizarTest extends TestCase
{
    private const ROTA = 'cliente.update';

    public function testFalhaUsuarioNaoLogado()
    {
        $usuario = Usuario::factory()->create();
        $clienteUm = Cliente::factory()->create([
            'usuario_id' => $usuario->id,
        ]);

        $response = $this->putJson(route(self::ROTA, $clienteUm->id));

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testFalhaValoresGrandes()
    {
        $usuario = Usuario::factory()->create();
        $clienteRegistrado = Cliente::factory()->create([
            'usuario_id' => $usuario->id,
        ]);

        $valoresGrandes = str_pad('', 101, 'A');

        $dadosIncorretos = [
            'nome' => $valoresGrandes,
            'telefone' => $valoresGrandes,
            'bairro' => $valoresGrandes,
            'rua' => $valoresGrandes,
            'numero' => $valoresGrandes,
            'cpf' => $valoresGrandes,
        ];

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $clienteRegistrado->id), $dadosIncorretos);

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

    public function testFalhaClienteNaoEncontrado()
    {
        $usuario = Usuario::factory()->create();
        $idInvalido = 0;

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $idInvalido));

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function testFalhaTiposValores()
    {
        $usuario = Usuario::factory()->create();
        $clienteRegistrado = Cliente::factory()->create([
            'usuario_id' => $usuario->id,
        ]);

        $dadosIncorretos = [
            'nome' => 13,
            'telefone' => 13,
            'bairro' => 13,
            'rua' => 13,
            'numero' => 13,
            'cpf' => 13,
        ];

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $clienteRegistrado->id), $dadosIncorretos);

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
        $clienteUm = Cliente::factory()->create([
            'usuario_id' => $usuario->id,
        ]);
        $clienteDois = Cliente::factory()->create([
            'cpf' => '46021295013',
            'usuario_id' => $usuario->id,
        ]);

        $dadosIncorretos = [
            'cpf' => $clienteUm->cpf,
        ];

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $clienteDois->id), $dadosIncorretos);

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
        $cliente = Cliente::factory()->create([
            'usuario_id' => $usuario->id,
        ]);

        $dadosIncorretos = [
            'cpf' => '11111111111',
        ];

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $cliente->id), $dadosIncorretos);

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
        $cliente = Cliente::factory()->create([
            'usuario_id' => $usuario->id,
        ]);

        $dadosIncorretos = [
            'telefone' => '3832152201',
        ];

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $cliente->id), $dadosIncorretos);

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
        $clienteNovo = Cliente::factory()->create();

        $response = $this->actingAs($usuario)->putJson(route(self::ROTA, $clienteNovo->id));

        $response->assertStatus(200)
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
