<?php

namespace App\Rules;

use App\Models\Cliente;
use Illuminate\Contracts\Validation\Rule;

class ClienteDuplicadoParaUsuario implements Rule
{
    private string $nomeCampo;

    private ?int $cliente;

    public function __construct(?int $cliente = null)
    {
        $this->cliente = $cliente;
    }

    public function passes($nomeCampo, $valor)
    {
        $this->nomeCampo = $nomeCampo;
        $clienteCadastrado = Cliente::where('cpf', $valor)
            ->where('usuario_id', auth('sanctum')->user()->getAuthIdentifier());

        if (is_int($this->cliente)) {
            $clienteCadastrado = $clienteCadastrado->where('id', '!=', $this->cliente);
        }
        if ($clienteCadastrado->exists()) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return "O campo {$this->nomeCampo} já está cadastrado neste usuário.";
    }
}
