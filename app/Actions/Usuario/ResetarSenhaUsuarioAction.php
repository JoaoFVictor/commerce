<?php

namespace App\Actions\Usuario;

use App\Models\Usuario;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ResetarSenhaUsuarioAction
{
    public function execute(array $dados): void
    {
        $resposta = $this->broker()->reset($dados, function ($user, $password) {
            $this->resetarSenha($user, $password);
        });

        if ($resposta != Password::PASSWORD_RESET) {
            $this->enviarRespostaErro($resposta);
        }
    }

    private function resetarSenha(Usuario $user, string $password): void
    {
        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        event(new PasswordReset($user));
    }

    private function enviarRespostaErro($resposta): void
    {
        throw ValidationException::withMessages(['email' => [__($resposta)]]);
    }

    private function broker(): PasswordBroker
    {
        return Password::broker();
    }
}
