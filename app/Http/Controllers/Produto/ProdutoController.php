<?php

namespace App\Http\Controllers\Produto;

use App\Actions\Produto\ApagarProdutoAction;
use App\Actions\Produto\AtualizarProdutoAction;
use App\Actions\Produto\BuscarProdutoAction;
use App\Actions\Produto\BuscarValorTotalProdutoAction;
use App\Actions\Produto\CriarProdutoAction;
use App\Actions\Produto\ListarCodigoBarrasProdutoAction;
use App\Actions\Produto\ListarNomeProdutoAction;
use App\Actions\Produto\ListarProdutoAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Produto\AtualizarProduto;
use App\Http\Requests\Produto\BuscarProduto;
use App\Http\Requests\Produto\CriarProduto;
use App\Http\Resources\Produto\ProdutosResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProdutoController extends Controller
{
    public function __construct(
        private ListarProdutoAction $listarProdutoAction,
        private CriarProdutoAction $criarProdutoAction,
        private BuscarProdutoAction $buscarProdutoAction,
        private ListarNomeProdutoAction $ListarNomeProdutoAction,
        private ListarCodigoBarrasProdutoAction $listarCodigoBarrasProdutoAction,
        private AtualizarProdutoAction $atualizarProdutoAction,
        private ApagarProdutoAction $apagarProdutoAction,
        private BuscarValorTotalProdutoAction $buscarValorTotalProdutoAction,
    ) {
    }

    /**
     * Listar Produtos
     *
     * Retorna todos os registros
     *
     * @group Produtos
     * @queryParam quantidade_minima integer filtra pela quantidade mínima em estoque.
     * @responseFile 200 ApiResposta/ProdutoController/Listar.json
     */
    public function index(Request $request): ResourceCollection
    {
        try {
            $produtos = $this->listarProdutoAction->execute($request->all());

            return ProdutosResource::collection($produtos);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Criar Produto
     *
     * Cria novo Produto
     *
     * @group Produtos
     * @responseFile 201 ApiResposta/ProdutoController/Listar.json
     * @responseFile 422 ApiResposta/ProdutoController/ValidacaoCriar.json
     */
    public function store(CriarProduto $request): JsonResponse
    {
        try {
            $produtos = $this->criarProdutoAction->execute($request->validated());

            return ProdutosResource::collection($produtos)->response()->setStatusCode(HttpFoundationResponse::HTTP_CREATED);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Detalhar Produto
     *
     * Retorna os dados do produto pelo ID
     *
     * @group Produtos
     * @urlParam id integer required O id do registro.
     * @responseFile ApiResposta/ProdutoController/Buscar.json
     * @response 404 {"message": "Produto não encontrado!"}
     * @response 403 {"message": "Usuário sem permissão."}
     */
    public function show(int $produto): ProdutosResource|JsonResponse
    {
        try {
            $produto = $this->buscarProdutoAction->execute($produto);

            return new ProdutosResource($produto);
        } catch (NotFoundHttpException | AccessDeniedHttpException $ex) {
            return Response::json(['message' => $ex->getMessage()], $ex->getStatusCode());
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Listar Produtos pelo nome
     *
     * Retorna todos os registros que se parecerem com o nome
     *
     * @group Produtos
     * @responseFile ApiResposta/ProdutoController/BuscarPorNome.json
     */
    public function buscarPorNome(string $nome, BuscarProduto $request): ResourceCollection|JsonResponse
    {
        try {
            $produto = $this->ListarNomeProdutoAction->execute($nome, $request->validated());

            return ProdutosResource::collection($produto);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Listar Produtos pelo código de barras
     *
     * Retorna todos os registros que batem com o código de barras.
     *
     * @group Produtos
     * @responseFile ApiResposta/ProdutoController/BuscarPorCodBarras.json
     */
    public function buscarPorCodigoBarras(string $codigoBarras, BuscarProduto $request): ResourceCollection|JsonResponse
    {
        try {
            $produto = $this->listarCodigoBarrasProdutoAction->execute($codigoBarras, $request->validated());

            return ProdutosResource::collection($produto);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Atualizar Produto
     *
     * Atualizar dados do Produto pelo ID
     *
     * @group Produtos
     * @urlParam id integer required O id do registro.
     * @responseFile ApiResposta/ProdutoController/Atualizar.json
     * @responseFile 422 ApiResposta/ProdutoController/ValidacaoAtualizar.json
     * @response 404 {"message": "Produto não encontrado!"}
     * @response 403 {"message": "Usuário sem permissão."}
     */
    public function update(AtualizarProduto $request, int $produto): ProdutosResource|JsonResponse
    {
        try {
            $produto = $this->atualizarProdutoAction->execute($produto, $request->validated());

            return new ProdutosResource($produto);
        } catch (NotFoundHttpException | AccessDeniedHttpException $ex) {
            return Response::json(['message' => $ex->getMessage()], $ex->getStatusCode());
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Excluir Produto
     *
     * Exclui o Produto pelo ID
     *
     * @group Produtos
     * @urlParam id integer required O id do registro.
     * @response 200 {"message": "OK"}
     * @response 404 {"message": "Produto não encontrado!"}
     * @response 403 {"message": "Usuário sem permissão."}
     */
    public function destroy(int $produto): JsonResponse
    {
        try {
            $this->apagarProdutoAction->execute($produto);

            return Response::json(['message' => 'Produto excluído com sucesso.'], HttpFoundationResponse::HTTP_OK);
        } catch (NotFoundHttpException | AccessDeniedHttpException $ex) {
            return Response::json(['message' => $ex->getMessage()], $ex->getStatusCode());
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Valor Total de Produtos
     *
     * Retorna a somatoria de valor de todos os produtos
     *
     * @group Produtos
     * @response 200 {"total": "1546,99"}
     */
    public function getValorTotal(): JsonResponse
    {
        try {
            $valorTotal = $this->buscarValorTotalProdutoAction->execute();

            return Response::json(['valor_total' => $valorTotal]);
        } catch (Exception $ex) {
            Log::critical('Controller'.self::class, ['exception' => $ex->getMessage()]);

            return Response::json(['message' => config('messages.error.server')], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
