<?php

namespace App\Actions\Usuario;

use App\Repository\Cliente\ClienteRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidarClienteUsuarioAction
{
    public function __construct(private ClienteRepositoryInterface $clienteRepository)
    {
    }

    public function execute(array $dados): void
    {
        $usuarioId = $dados['usuario_id'];
        $clienteId = $dados['cliente_id'];

        $clienteIdValido = $this->clienteRepository->isClienteUsuario($clienteId, $usuarioId);

        if (! $clienteIdValido) {
            throw new HttpException(403, 'cliente_id não pertence a esse usuário.');
        }
    }
}
