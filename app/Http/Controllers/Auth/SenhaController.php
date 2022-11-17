<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Usuario\RecuperarSenhaUsuarioAction;
use App\Actions\Usuario\ResetarSenhaFormularioEmailUsuarioAction;
use App\Actions\Usuario\ResetarSenhaFormularioUsuarioAction;
use App\Actions\Usuario\ResetarSenhaUsuarioAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\ResetarSenha as ResetarSenhaRequest;
use App\Http\Requests\Usuario\UsuarioEmail;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

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
    public function recuperarSenha(UsuarioEmail $request, RecuperarSenhaUsuarioAction $action): JsonResponse
    {
        try {
            $mensagem = $action->execute($request->validated());

            return Response::json(['message' => $mensagem]);
        } catch (ValidationException $ex) {
            return Response::json(['messages' => $ex->getMessage(), 'errors' => $ex->errors()], $ex->status);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Processa requisição para resetar senha
     *
     * Processa requisição para resetar senha
     *
     * @group Password
     * @responseFile 422 ApiResposta/Auth/SenhaController/ValidacaoResetarSenha.json
     */
    public function resetarSenha(ResetarSenhaRequest $request, ResetarSenhaUsuarioAction $action): View|JsonResponse
    {
        try {
            $action->execute($request->validated());

            return view('avisos.sucesso')->with(
                ['titulo' => 'Sucesso', 'texto' => config('messages.mail.reset_password')]
            );
        } catch (ValidationException $ex) {
            return Response::json(['messages' => $ex->getMessage(), 'errors' => $ex->errors()], $ex->status);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function resetarSenhaFormulario(ResetarSenhaFormularioEmailUsuarioAction $action): View|JsonResponse
    {
        try {
            return $action->execute();
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function requisicaoFormularioResetar(ResetarSenhaRequest $request, ResetarSenhaFormularioUsuarioAction $action): View|JsonResponse
    {
        try {
            return $action->execute($request->route()->parameter('token'), $request->input('email'));
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
