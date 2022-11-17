<?php

namespace App\Actions\Usuario;

use App\Repository\Usuario\UsuarioRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;

class VerificarEmailUsuarioAction
{
    public function __construct(private UsuarioRepositoryInterface $usuarioRepository)
    {
    }

    public function execute(string $usuarioId, string $hash): void
    {
        $usuario = $this->usuarioRepository->buscar($usuarioId);

        if (! hash_equals($usuarioId, (string) $usuario->id)) {
            throw new AuthorizationException();
        }

        if (! hash_equals($hash, sha1($usuario->getEmailForVerification()))) {
            throw new AuthorizationException();
        }

        if ($usuario->markEmailAsVerified()) {
            event(new Verified($usuario));
        }
    }
}
