<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Usuario\AutenticarUsuarioAction;
use App\Actions\Usuario\CadastrarUsuarioAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\UsuarioCriar;
use App\Http\Requests\Usuario\UsuarioLogar;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

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
    public function cadastro(UsuarioCriar $request, CadastrarUsuarioAction $action): JsonResponse
    {
        try {
            $action->execute($request->only(['nome', 'senha', 'email', 'telefone']));

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_CREATED);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
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
    public function login(UsuarioLogar $request, AutenticarUsuarioAction $action): JsonResponse
    {
        try {
            $token = $action->execute($request);

            return Response::json(['token' => $token]);
        } catch (ValidationException $ex) {
            return Response::json(['messages' => $ex->getMessage(), 'errors' => $ex->errors()], $ex->status);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
