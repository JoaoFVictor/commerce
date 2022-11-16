<?php

namespace App\Http\Controllers\Usuario;

use App\Actions\Usuario\AtualizarUsuarioAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\Atualizar as Request;
use App\Http\Resources\Usuario\UsuariosResource as Resource;
use Illuminate\Support\Facades\Auth;

class DadosController extends Controller
{
    /**
     * Buscar dados de usuário
     *
     * Retorna todos os dados de usuário
     *
     * @group Usuário
     * @responseFile ApiResposta/Usuario/DadosController/Detalhar.json
     */
    public function show()
    {
        return new Resource(auth()->user());
    }

    /**
     * Buscar dados de usuário
     *
     * Retorna todos os dados de usuário
     *
     * @group Usuário
     * @responseFile ApiResposta/Usuario/DadosController/Detalhar.json
     * @responseFile 422 ApiResposta/Usuario/DadosController/ValidacaoAtualizar.json
     */
    public function update(Request $request, AtualizarUsuarioAction $action)
    {
        return $action->execute($request);
    }

    /**
     * Buscar dados de usuário
     *
     * Retorna todos os dados de usuário
     *
     * @group Usuário
     * @response 200 {"message": "Usuário excluído"}
     */
    public function destroy()
    {
        $usuario = Auth::user();
        $usuario->delete();

        return response()->json(['message' => 'Usuário excluído']);
    }
}
