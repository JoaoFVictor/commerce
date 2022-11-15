<?php

namespace App\Actions\Usuario;

use App\Models\Cliente;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidarClienteUsuarioAction
{
    public function execute(array $dados): void
    {
        $usuarioId = $dados['usuario_id'];
        $clienteId = $dados['cliente_id'];

        $clienteIdValido = Cliente::where('usuario_id', $usuarioId)->where('id', $clienteId)->exists();

        if (! $clienteIdValido) {
            throw new HttpException(403, 'cliente_id não pertence a esse usuário.');
        }
    }
}
