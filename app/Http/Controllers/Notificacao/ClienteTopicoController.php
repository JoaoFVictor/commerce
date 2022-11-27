<?php

namespace App\Http\Controllers\Notificacao;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notificacao\ClienteTopico\ClienteTopicoAtualizar;
use App\Http\Requests\Notificacao\ClienteTopico\ClienteTopicoCriar;
use App\Http\Resources\Notificacao\ClienteTopico\ClienteTopicoResource;
use App\Models\Notificacao\NotificacaoClienteTopico;
use App\Repository\Notificacao\NotificacaoClienteTopicoRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ClienteTopicoController extends Controller
{
    public function __construct(private NotificacaoClienteTopicoRepositoryInterface $clienteTopicoRepository)
    {
    }

    /**
     * Listar dados Topicos de Cliente
     *
     * Retorna todos os registros
     *
     * @group Notificacao
     * @responseFile ApiResposta/Notificacao/ClienteTopicoController/Listar.json
     */
    public function index(): JsonResource|JsonResponse
    {
        try {
            $clienteTopicos = $this->clienteTopicoRepository->paginar();

            return ClienteTopicoResource::collection($clienteTopicos);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Criar novo Topicos de Cliente
     *
     * Criar um registro
     *
     * @group Notificacao
     * @responseFile 201 ApiResposta/Notificacao/ClienteTopicoController/Criar.json
     * @responseFile 422 ApiResposta/Notificacao/ClienteTopicoController/ValidacaoCriar.json
     */
    public function store(ClienteTopicoCriar $request): JsonResource|JsonResponse
    {
        try {
            $novo = $this->clienteTopicoRepository->criar($request->validated());

            return (new ClienteTopicoResource($novo))->response()->setStatusCode(HttpFoundationResponse::HTTP_CREATED);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Buscar Topicos de Cliente
     *
     * Retorna os dados do Topicos de Cliente
     *
     * @group Notificacao
     * @urlParam id integer required O id do registro.
     * @responseFile ApiResposta/Notificacao/ClienteTopicoController/Buscar.json
     * @response 404 {"message": "No query results for model [App\\Models\\Notificacao\\ClienteTopico]"}
     */
    public function show(NotificacaoClienteTopico $clienteTopico): JsonResource|JsonResponse
    {
        try {
            return new ClienteTopicoResource($clienteTopico);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Atualizar Topicos de Cliente
     *
     * Atualizar dados do Topicos de Cliente
     *
     * @group Notificacao
     * @urlParam id integer required O id do registro.
     * @responseFile ApiResposta/Notificacao/ClienteTopicoController/Atualizar.json
     * @responseFile 422 ApiResposta/Notificacao/ClienteTopicoController/ValidacaoAtualizar.json
     * @response 404 {"message": "No query results for model [App\\Models\\Notificacao\\ClienteTopico]"}
     */
    public function update(ClienteTopicoAtualizar $request, NotificacaoClienteTopico $clienteTopico): JsonResource|JsonResponse
    {
        try {
            $clienteTopicoAtualizado = $this->clienteTopicoRepository->atualizar($clienteTopico->id, $request->validated());

            return new ClienteTopicoResource($clienteTopicoAtualizado);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Excluir Topicos de Cliente
     *
     * Exclui o Topicos de Cliente
     *
     * @group Notificacao
     * @urlParam id integer required O id do registro.
     * @response 200 {"message": "OK"}
     * @response 404 {"message": "No query results for model [App\\Models\\Notificacao\\ClienteTopico]"}
     */
    public function destroy(NotificacaoClienteTopico $clienteTopico): JsonResponse
    {
        try {
            $this->clienteTopicoRepository->apagar($clienteTopico->id);

            return Response::json(['message' => 'Ok.']);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
