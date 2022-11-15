<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Usuario\ReenviarEmailVerificacaoUsuarioAction;
use App\Actions\Usuario\VerificarEmailUsuarioAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Reenviar email de confirmação de conta
     *
     * Reenviar email de confirmação de conta
     *
     * @group Email
     * @response 200 {"message": "Email já está verificado."}
     * @response 200 {"message": "Email reenviado."}
     */
    public function reenviarEmail(ReenviarEmailVerificacaoUsuarioAction $action)
    {
        return $action->execute();
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function verificarEmail(Request $request, VerificarEmailUsuarioAction $action)
    {
        return $action->execute($request->route('id'), $request->route('hash'));
    }
}
