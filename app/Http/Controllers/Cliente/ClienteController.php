<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cliente\ClienteAtualizar;
use App\Http\Requests\Cliente\ClienteCriar;
use App\Http\Resources\Cliente\ClienteResource;
use App\Models\Cliente;
use App\Repository\Cliente\ClienteRepositoryInterface;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class ClienteController extends Controller
{
    public function __construct(private ClienteRepositoryInterface $clienteRepository)
    {
    }

    /**
     * Listagem de Clientes
     *
     * Retorna todos os registros
     *
     * @group Clientes
     * @responseFile 201 ApiResposta/ClienteController/Listar.json
     */
    public function index(): JsonResource|JsonResponse
    {
        try {
            $clientes = $this->clienteRepository->paginar();

            return ClienteResource::collection($clientes);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Criar novo Cliente
     *
     * Cria novo Cliente
     *
     * @group Clientes
     * @responseFile 201 ApiResposta/ClienteController/Criar.json
     * @responseFile 422 ApiResposta/ClienteController/ValidacaoCriar.json
     */
    public function store(ClienteCriar $request): JsonResource|JsonResponse
    {
        try {
            $novo = $this->clienteRepository->criar($request->validated());

            return (new ClienteResource($novo))->response()->setStatusCode(201);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Buscar Cliente
     *
     * Retorna os dados do Cliente pelo ID
     *
     * @group Clientes
     * @urlParam cliente integer required O id do registro.
     * @responseFile ApiResposta/ClienteController/Buscar.json
     * @response 404 {"message": "No query results for model [App\\Models\\Cliente]"}
     */
    public function show(Cliente $cliente): JsonResource|JsonResponse
    {
        try {
            return new ClienteResource($cliente);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Buscar Clientes pelo Nome
     *
     * Buscar os dados do Cliente pelo Nome
     *
     * @group Clientes
     * @urlParam nome string required O nome do registro.
     * @responseFile ApiResposta/ClienteController/BuscarPeloNome.json
     * @response 404 {"message": "No query results for model [App\\Models\\Cliente]"}
     */
    public function ListarPeloNome(string $nome): JsonResource|JsonResponse
    {
        try {
            $clientes = $this->clienteRepository->ListarPeloNome($nome);

            return ClienteResource::collection($clientes);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Atualizar dados do Cliente
     *
     * Atualizar dados do Cliente
     *
     * @group Clientes
     * @urlParam cliente int required O id do registro.
     * @responseFile ApiResposta/ClienteController/Atualizar.json
     * @responseFile 422 ApiResposta/ClienteController/ValidacaoAtualizar.json
     * @response 404 {"message": "No query results for model [App\\Models\\Cliente]"}
     */
    public function update(ClienteAtualizar $request, Cliente $cliente): JsonResource|JsonResponse
    {
        try {
            $clienteAtualizado = $this->clienteRepository->atualizar($cliente->id, $request->validated());

            return new ClienteResource($clienteAtualizado);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Excluir Cliente
     *
     * Exclui o Cliente
     *
     * @group Clientes
     * @urlParam cliente integer required O id do registro.
     * @response 200 {"message": "OK"}
     * @response 404 {"message": "No query results for model [App\\Models\\Cliente]"}
     */
    public function destroy(Cliente $cliente): JsonResponse
    {
        try {
            $this->clienteRepository->apagar($cliente->id);

            return response()->json(['message' => 'Cliente excluído com sucesso.']);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
