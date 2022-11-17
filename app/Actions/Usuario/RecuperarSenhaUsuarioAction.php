<?php

namespace App\Actions\Usuario;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class RecuperarSenhaUsuarioAction
{
    public function execute(array $dados): string
    {
        $resposta = $this->broker()->sendResetLink($dados);

        return $resposta == Password::RESET_LINK_SENT
            ? __($resposta)
            : $this->enviarErroLinkResetarSenha($resposta);
    }

    private function enviarErroLinkResetarSenha(string $response): void
    {
        throw ValidationException::withMessages([
            'email' => [__($response)],
        ]);
    }

    private function broker(): PasswordBroker
    {
        return Password::broker();
    }
}
