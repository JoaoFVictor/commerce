<?php

namespace App\Actions\Usuario;

use App\Models\Usuario;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ResetarSenhaUsuarioAction
{
    public function execute(array $dados): View
    {
        $response = $this->broker()->reset($dados, function ($user, $password) {
            $this->resetarSenha($user, $password);
        });

        return $response == Password::PASSWORD_RESET ? $this->enviarRespostaSucesso($response) : $this->enviarRespostaErro($response);
    }

    private function resetarSenha(Usuario $user, string $password): void
    {
        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        event(new PasswordReset($user));
    }

    private function enviarRespostaSucesso()
    {
        return view('avisos.sucesso')->with(
            ['titulo' => 'Sucesso', 'texto' => config('messages.mail.reset_password')]
        );
    }

    private function enviarRespostaErro($response): void
    {
        throw ValidationException::withMessages(['email' => [trans($response)]]);
    }

    private function broker(): PasswordBroker
    {
        return Password::broker();
    }
}
