<?php

namespace App\Http\Controllers\Notificacao;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notificacao\Topico\TopicoAtualizar;
use App\Http\Requests\Notificacao\Topico\TopicoCriar;
use App\Http\Resources\Notificacao\Topico\TopicoResource;
use App\Models\Notificacao\NotificacaoTopico;
use App\Repository\Notificacao\NotificacaoTopicoRepositoryInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class TopicoController extends Controller
{
    public function __construct(private NotificacaoTopicoRepositoryInterface $notificacaoTopicoRepository)
    {
    }

    /**
     * Listar dados Topico
     *
     * Retorna todos os registros
     *
     * @group Notificacao
     * @responseFile ApiResposta/Notificacao/TopicoController/Listar.json
     */
    public function index(): JsonResource|JsonResponse
    {
        try {
            $topicos = $this->notificacaoTopicoRepository->paginar();

            return TopicoResource::collection($topicos);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Criar novo Topico
     *
     * Cria novo Topico
     *
     * @group Notificacao
     * @responseFile 201 ApiResposta/Notificacao/TopicoController/Criar.json
     * @responseFile 422 ApiResposta/Notificacao/TopicoController/ValidacaoCriar.json
     */
    public function store(TopicoCriar $request): JsonResource|JsonResponse
    {
        try {
            $topico = $this->notificacaoTopicoRepository->criar($request->validated());

            return (new TopicoResource($topico))->response()->setStatusCode(HttpFoundationResponse::HTTP_CREATED);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Buscar Topico
     *
     * Retorna os dados Topico
     *
     * @group Notificacao
     * @urlParam id integer required O id do registro.
     * @responseFile ApiResposta/Notificacao/TopicoController/Buscar.json
     * @response 404 {"message": "No query results for model [App\\Models\\Notificacao\\Topico]"}
     */
    public function show(NotificacaoTopico $topico): JsonResource|JsonResponse
    {
        try {
            return new TopicoResource($topico);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Atualizar Topico
     *
     * Atualizar dados Topico
     *
     * @group Notificacao
     * @urlParam id integer required O id do registro.
     * @responseFile ApiResposta/Notificacao/TopicoController/Criar.json
     * @responseFile 422 ApiResposta/Notificacao/TopicoController/ValidacaoAtualizar.json
     * @response 404 {"message": "No query results for model [App\\Models\\Notificacao\\Topico]"}
     */
    public function update(TopicoAtualizar $request, NotificacaoTopico $topico): JsonResource|JsonResponse
    {
        try {
            $topicoAtualizado = $this->notificacaoTopicoRepository->atualizar($topico->id, $request->validated());

            return new TopicoResource($topicoAtualizado);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Excluir Topico
     *
     * Exclui o Topico
     *
     * @group Notificacao
     * @urlParam id integer required O id do registro.
     * @response 200 {"message": "OK"}
     * @response 404 {"message": "No query results for model [App\\Models\\Notificacao\\Topico]"}
     */
    public function destroy(NotificacaoTopico $topico): JsonResponse
    {
        try {
            $this->notificacaoTopicoRepository->apagar($topico->id);

            return Response::json(['message' => 'Ok']);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
