<?php

namespace App\Http\Controllers\Notificacao;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notificacao\ClienteMensagem\ClienteMensagemCriar;
use App\Http\Resources\Notificacao\ClienteMensagem\ClienteMensagemResource;
use App\Repository\Notificacao\NotificacaoClienteMensagemRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ClienteMensagemController extends Controller
{
    public function __construct(private NotificacaoClienteMensagemRepositoryInterface $notificacaoClienteMensagemRepository)
    {
    }

    /**
     * Cria nova mensagem do Cliente
     *
     * Cria nova mensagem do Cliente
     *
     * @group Notificacao
     * @responseFile 201 ApiResposta/Notificacao/ClienteMensagemController/Criar.json
     * @responseFile 422 ApiResposta/Notificacao/ClienteMensagemController/ValidacaoCriar.json
     */
    public function store(ClienteMensagemCriar $request): JsonResource|JsonResponse
    {
        try {
            $novo = $this->notificacaoClienteMensagemRepository->criar($request->validated());

            return (new ClienteMensagemResource($novo))->response()->setStatusCode(HttpFoundationResponse::HTTP_CREATED);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
