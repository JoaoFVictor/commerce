<?php

namespace App\Actions\Usuario;

use Auth;

class ReenviarEmailVerificacaoUsuarioAction
{
    public function execute(): bool
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return false;
        }
        Auth::user()->sendEmailVerificationNotification();

        return true;
    }
}
