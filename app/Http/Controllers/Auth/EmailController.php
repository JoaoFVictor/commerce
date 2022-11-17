<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Usuario\ReenviarEmailVerificacaoUsuarioAction;
use App\Actions\Usuario\VerificarEmailUsuarioAction;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

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
    public function reenviarEmail(ReenviarEmailVerificacaoUsuarioAction $action): JsonResponse
    {
        try {
            $isEmailEnviado = $action->execute();
            if ($isEmailEnviado) {
                return Response::json(['message' => 'Email reenviado.']);
            }

            return Response::json(['message' => 'Email já está verificado.']);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function verificarEmail(Request $request, VerificarEmailUsuarioAction $action): View|JsonResponse
    {
        try {
            $action->execute($request->route('id'), $request->route('hash'));

            return view('avisos.sucesso')->with(
                ['titulo' => 'Sucesso', 'texto' => config('messages.mail.verify')]
            );
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
