<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Usuario\RecuperarSenhaUsuarioAction;
use App\Actions\Usuario\ResetarSenhaFormularioEmailUsuarioAction;
use App\Actions\Usuario\ResetarSenhaFormularioUsuarioAction;
use App\Actions\Usuario\ResetarSenhaUsuarioAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usuarios\ResetarSenha as ResetarSenhaRequest;
use App\Http\Requests\Usuarios\UsuarioEmail;

class SenhaController extends Controller
{
    /**
     * Enviar link para resetar a senha do usuário para o Email
     *
     * Envia link para resetar a senha do usuário para o Email
     *
     * @group Password
     * @responseFile 422 ApiResposta/Auth/SenhaController/ValidacaoRequest.json
     * @response {"message": "Enviamos seu link de redefinição de senha por e-mail!"}
     */
    public function recuperarSenha(UsuarioEmail $request, RecuperarSenhaUsuarioAction $action)
    {
        return $action->execute($request->validated());
    }

    /**
     * Processa requisição para resetar senha
     *
     * Processa requisição para resetar senha
     *
     * @group Password
     * @responseFile 422 ApiResposta/Auth/SenhaController/ValidacaoResetarSenha.json
     */
    public function resetarSenha(ResetarSenhaRequest $request, ResetarSenhaUsuarioAction $action)
    {
        return $action->execute($request->validated());
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function resetarSenhaFormulario(ResetarSenhaFormularioEmailUsuarioAction $action)
    {
        return $action->execute();
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function requisicaoFormularioResetar(ResetarSenhaRequest $request, ResetarSenhaFormularioUsuarioAction $action)
    {
        return $action->execute($request->route()->parameter('token'), $request->input('email'));
    }
}
