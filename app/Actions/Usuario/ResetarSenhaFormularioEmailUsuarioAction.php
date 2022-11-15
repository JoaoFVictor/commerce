<?php

namespace App\Actions\Usuario;

use Illuminate\Contracts\View\View;

class ResetarSenhaFormularioEmailUsuarioAction
{
    public function execute(): View
    {
        return view('auth.passwords.email');
    }
}
