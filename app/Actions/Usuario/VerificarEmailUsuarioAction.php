<?php

namespace App\Actions\Usuario;

use App\Models\Usuario;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;

class VerificarEmailUsuarioAction
{
    public function execute(string $usuarioId, string $hash)
    {
        $usuario = Usuario::find($usuarioId);

        if (! hash_equals($usuarioId, (string) $usuario->getKey())) {
            throw new AuthorizationException();
        }

        if (! hash_equals($hash, sha1($usuario->getEmailForVerification()))) {
            throw new AuthorizationException();
        }

        if ($usuario->markEmailAsVerified()) {
            event(new Verified($usuario));
        }

        return view('avisos.sucesso')->with(
            ['titulo' => 'Sucesso', 'texto' => config('messages.mail.verify')]
        );
    }
}
