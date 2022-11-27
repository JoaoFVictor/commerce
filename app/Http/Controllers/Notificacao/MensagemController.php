<?php

namespace App\Http\Controllers\Notificacao;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notificacao\Mensagem\MensagemAtualizar;
use App\Http\Requests\Notificacao\Mensagem\MensagemCriar;
use App\Http\Resources\Notificacao\Mensagem\MensagemResource;
use App\Models\Notificacao\NotificacaoMensagem;
use App\Repository\Notificacao\NotificacaoMensagemRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class MensagemController extends Controller
{
    public function __construct(private NotificacaoMensagemRepositoryInterface $notificacaoMensagemRepository)
    {
    }

    /**
     * Listar dados Mensagem
     *
     * Retorna todos os registros
     *
     * @group Notificacao
     * @responseFile ApiResposta/Notificacao/MensagemController/Listar.json
     */
    public function index(): JsonResource|JsonResponse
    {
        try {
            $clienteTopicos = $this->notificacaoMensagemRepository->paginar();

            return MensagemResource::collection($clienteTopicos);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Criar novo registro de Mensagem
     *
     * Cria novo registro de Mensagem
     *
     * @group Notificacao
     * @responseFile 201 ApiResposta/Notificacao/MensagemController/Criar.json
     * @responseFile 422 ApiResposta/Notificacao/MensagemController/ValidacaoCriar.json
     */
    public function store(MensagemCriar $request): JsonResource|JsonResponse
    {
        try {
            $mensagem = $this->notificacaoMensagemRepository->criar($request->validated());

            return (new MensagemResource($mensagem))->response()->setStatusCode(HttpFoundationResponse::HTTP_CREATED);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Buscar Mensagem
     *
     * Retorna os dados da Mensagem
     *
     * @group Notificacao
     * @urlParam id integer required O id do registro.
     * @responseFile ApiResposta/Notificacao/MensagemController/Buscar.json
     * @response 404 {"message": "No query results for model [App\\Models\\Notificacao\\Mensagem]"}
     */
    public function show(NotificacaoMensagem $mensagem): JsonResource|JsonResponse
    {
        try {
            return new MensagemResource($mensagem);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Atualizar Mensagem
     *
     * Atualizar dados da Mensagem
     *
     * @group Notificacao
     * @urlParam id integer required O id do registro.
     * @responseFile ApiResposta/Notificacao/MensagemController/Atualizar.json
     * @responseFile 422 ApiResposta/Notificacao/MensagemController/ValidacaoAtualizar.json
     * @response 404 {"message": "No query results for model [App\\Models\\Notificacao\\Mensagem]"}
     */
    public function update(MensagemAtualizar $request, NotificacaoMensagem $mensagem): JsonResource|JsonResponse
    {
        try {
            $mensagemAtualizado = $this->notificacaoMensagemRepository->atualizar($mensagem->id, $request->validated());

            return new MensagemResource($mensagemAtualizado);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Excluir Mensagem
     *
     * Exclui o Mensagem
     *
     * @group Notificacao
     * @urlParam id integer required O id do registro.
     * @response 200 {"message": "OK"}
     * @response 404 {"message": "No query results for model [App\\Models\\Notificacao\\Mensagem]"}
     */
    public function destroy(NotificacaoMensagem $mensagem): JsonResponse
    {
        try {
            $this->notificacaoMensagemRepository->apagar($mensagem->id);

            return Response::json(['message' => 'Ok']);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
