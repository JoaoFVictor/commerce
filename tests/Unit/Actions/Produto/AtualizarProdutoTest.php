<?php

namespace Tests\Unit\Actions\Produto;

use App\Actions\Produto\AtualizarProdutoAction;
use App\Adapter\DTO\Estoque\EstoqueDTO;
use App\Adapter\DTO\Produto\ProdutoDTO;
use App\Models\Produto;
use App\Repository\Estoque\EstoqueRepositoryInterface;
use App\Repository\Produto\ProdutoRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class AtualizarProdutoTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->produtoRepositoryStub = $this->createMock(ProdutoRepositoryInterface::class);
        $this->estoqueRepositoryStub = $this->createMock(EstoqueRepositoryInterface::class);
    }

    /**
     * @test
     */
    public function falhaUsuarioDiferenteDoUsuarioProduto()
    {
        $this->expectException(AccessDeniedHttpException::class);
        $produtoId = 10;
        $usuarioId = 1;
        Auth::shouldReceive('id')->once()->andReturn($usuarioId);
        $produto = new Produto();
        $produto->id = $produtoId;
        $produto->usuario_id = 3;

        $dados = [
            'codigo_barras' => 'Codigo Barras Teste',
            'nome' => 'Nome teste',
            'marca' => 'Marca teste',
            'preco_venda' => 10,
            'preco_custo' => 10,
            'validade' => '10-02-2022',
        ];
        $this->produtoRepositoryStub
            ->expects(self::once())
            ->method('buscar')
            ->with($produtoId)
            ->willReturn($produto);
        $action = new AtualizarProdutoAction($this->produtoRepositoryStub, $this->estoqueRepositoryStub);
        $action->execute($produtoId, $dados, null);
    }

    /**
     * @test
     */
    public function falhaProdutoNaoEncontrado()
    {
        $this->expectException(NotFoundHttpException::class);
        $produtoId = 10;
        $usuarioId = 1;
        Auth::shouldReceive('id')->once()->andReturn($usuarioId);

        $dados = [
            'codigo_barras' => 'Codigo Barras Teste',
            'nome' => 'Nome teste',
            'marca' => 'Marca teste',
            'preco_venda' => 10,
            'preco_custo' => 10,
            'validade' => '10-02-2022',
        ];
        $this->produtoRepositoryStub
            ->expects(self::once())
            ->method('buscar')
            ->with($produtoId)
            ->willReturn(null);
        $action = new AtualizarProdutoAction($this->produtoRepositoryStub, $this->estoqueRepositoryStub);
        $action->execute($produtoId, $dados, null);
    }

    /**
     * @test
     */
    public function sucessoAtualizarProdutoEEstoque()
    {
        $produtoId = 10;
        $usuarioId = 1;
        $produtoEstoqueId = 6;
        Auth::shouldReceive('id')->once()->andReturn($usuarioId);
        $produto = new Produto();
        $produto->id = $produtoId;
        $produto->codigo_barras = 'teste';
        $produto->nome = 'teste';
        $produto->marca = 'teste';
        $produto->preco_custo = 10;
        $produto->preco_venda = 15;
        $produto->validade = '10-02-2022';
        $produto->usuario_id = $usuarioId;
        $dados = [
            'codigo_barras' => 'Codigo Barras Teste',
            'nome' => 'Nome teste',
            'marca' => 'Marca teste',
            'preco_venda' => 10,
            'preco_custo' => 10,
            'validade' => '10-02-2022',
            'quantidade' => 10,
        ];
        $produtoDTO = new ProdutoDTO(
            produtoId: $produto->id,
            codigoBarras: $dados['codigo_barras'],
            nome: $dados['nome'],
            marca: $dados['marca'],
            precoCusto: $dados['preco_custo'],
            precoVenda: $dados['preco_venda'],
            validade: $dados['validade'],
        );
        $estoqueDTO = new EstoqueDTO(
            estoqueId: $produtoEstoqueId,
            produtoId: $produto->id,
            quantidade: $dados['quantidade'],
        );

        $this->produtoRepositoryStub
            ->expects(self::once())
            ->method('buscar')
            ->with($produtoId)
            ->willReturn($produto);
        $this->produtoRepositoryStub
            ->expects(self::once())
            ->method('atualizar')
            ->with($produtoDTO)
            ->willReturn($produto);
        $this->estoqueRepositoryStub
            ->expects(self::once())
            ->method('atualizar')
            ->with($estoqueDTO);

        $action = new AtualizarProdutoAction($this->produtoRepositoryStub, $this->estoqueRepositoryStub);
        $retorno = $action->execute($produtoId, $dados, $produtoEstoqueId);
        $this->assertEquals($retorno, $produto);
    }
}
