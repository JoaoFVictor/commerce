<?php

namespace App\Actions\Usuario;

use Illuminate\Contracts\View\View;

class ResetarSenhaFormularioUsuarioAction
{
    public function execute(string $token, string $email): View
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $email]
        );
    }
}
