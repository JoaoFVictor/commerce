<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Usuario\AutenticarUsuarioAction;
use App\Actions\Usuario\CadastrarUsuarioAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usuarios\UsuarioCriar;
use App\Http\Requests\Usuarios\UsuarioLogar;

class UsuarioController extends Controller
{
    /**
     * Criar novo usuário
     *
     * Cria novo usuário
     *
     * @group Auth
     * @responseFile 422 ApiResposta/Auth/UsuarioController/ValidacaoCriar.json
     * @response 201 {"message": "Conta criada."}
     */
    public function cadastro(UsuarioCriar $request, CadastrarUsuarioAction $action)
    {
        return $action->execute($request->only(['nome', 'senha', 'email', 'telefone']));
    }

    /**
     * Logar no App
     *
     * Logar no App
     *
     * @group Auth
     * @responseFile 422 ApiResposta/Auth/UsuarioController/ValidacaoLogin.json
     * @response 200 {"token": "13|HfI40OFYLjWEahpM4QgWEvdqbXbVRpPIelNehKq0"}
     */
    public function login(UsuarioLogar $request, AutenticarUsuarioAction $action)
    {
        return $action->execute($request);
    }
}
