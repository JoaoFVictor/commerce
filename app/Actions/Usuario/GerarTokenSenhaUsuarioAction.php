<?php

namespace App\Actions\Usuario;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Password;

class GerarTokenSenhaUsuarioAction
{
    private $usuario;

    private $token;

    public function execute(string $email): array
    {
        $this->broker()->sendResetLink(['email' => $email], function ($usuario, $token) {
            $this->usuario = $usuario;
            $this->token = $token;
        });

        return [$this->usuario, $this->token];
    }

    private function broker(): PasswordBroker
    {
        return Password::broker();
    }
}
