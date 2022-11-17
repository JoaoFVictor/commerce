<?php

namespace App\Rules;

use App\Repository\Cliente\ClienteRepositoryInterface;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ClienteDuplicadoParaUsuario implements Rule
{
    private string $nomeCampo;

    public function __construct(private ?int $cliente, private ClienteRepositoryInterface $clienteRepository)
    {
        $this->cliente = $cliente;
    }

    public function passes($nomeCampo, $valor): bool
    {
        $this->nomeCampo = $nomeCampo;
        $usuarioId = Auth::user()->id;
        $clienteCadastrado = $this->clienteRepository->isClienteCpfCadastradoComUsuario($valor, $usuarioId, $this->cliente);

        return ! $clienteCadastrado;
    }

    public function message(): string
    {
        return "O campo {$this->nomeCampo} já está cadastrado neste usuário.";
    }
}
