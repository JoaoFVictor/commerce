<?php

namespace App\Http\Controllers\Usuario;

use App\Actions\Usuario\AtualizarUsuarioAction;
use App\Exceptions\ImagemInvalida;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\Atualizar as Request;
use App\Http\Resources\Usuario\UsuariosResource as Resource;
use App\Repository\Usuario\UsuarioRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

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
    public function show(): JsonResource|JsonResponse
    {
        try {
            return new Resource(Auth::user());
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
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
    public function update(Request $request, AtualizarUsuarioAction $action): JsonResource|JsonResponse
    {
        try {
            $usuario = Auth::user();
            $usuarioAtualizado = $action->execute($usuario->id, $request->validated());

            return new Resource($usuarioAtualizado);
        } catch (ImagemInvalida $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => $ex->getMessage()], $ex->getCode());
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Buscar dados de usuário
     *
     * Retorna todos os dados de usuário
     *
     * @group Usuário
     * @response 200 {"message": "Usuário excluído"}
     */
    public function destroy(UsuarioRepositoryInterface $usuarioRepository): JsonResource|JsonResponse
    {
        try {
            $usuario = Auth::user();
            $usuarioRepository->apagar($usuario->id);

            return response()->json(['message' => 'Usuário excluído']);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
