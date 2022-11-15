<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cliente\ClienteAtualizar;
use App\Http\Requests\Cliente\ClienteCriar;
use App\Http\Resources\Cliente\ClienteResource;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Listagem de Clientes
     *
     * Retorna todos os registros
     *
     * @group Clientes
     * @responseFile 201 ApiResposta/ClienteController/Listar.json
     */
    public function index()
    {
        return ClienteResource::collection(Cliente::simplePaginate(15));
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
    public function store(ClienteCriar $request)
    {
        $novo = Cliente::create($request->validated());

        return (new ClienteResource($novo))->response()->setStatusCode(201);
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
    public function show(Cliente $cliente)
    {
        return new ClienteResource($cliente);
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
    public function buscarPeloNome(string $nome)
    {
        $clientes = Cliente::where('nome', 'ILIKE', "%{$nome}%")->get();

        return ClienteResource::collection($clientes);
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
    public function update(ClienteAtualizar $request, Cliente $cliente)
    {
        $cliente->update($request->validated());

        return new ClienteResource($cliente);
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
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return response()->json(['message' => 'Cliente excluído com sucesso.']);
    }
}
