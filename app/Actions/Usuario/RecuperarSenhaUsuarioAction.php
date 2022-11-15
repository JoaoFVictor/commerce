<?php

namespace App\Actions\Usuario;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class RecuperarSenhaUsuarioAction
{
    public function execute(array $dados): JsonResponse
    {
        $resposta = $this->broker()->sendResetLink($dados);

        return $resposta == Password::RESET_LINK_SENT
            ? $this->enviarLinkResetarSenha($resposta)
            : $this->enviarErroLinkResetarSenha($resposta);
    }

    private function enviarLinkResetarSenha(string $response): JsonResponse
    {
        return response()->json(['message' => trans($response)]);
    }

    private function enviarErroLinkResetarSenha(string $response): void
    {
        throw ValidationException::withMessages([
            'email' => [trans($response)],
        ]);
    }

    private function broker(): PasswordBroker
    {
        return Password::broker();
    }
}
