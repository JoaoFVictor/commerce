<?php

namespace Tests\Unit\Actions\Produto;

use App\Actions\Produto\ApagarProdutoAction;
use App\Models\Produto;
use App\Repository\Produto\ProdutoRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class ApagarProdutoEstoqueTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->produtoRepositoryStub = $this->createMock(ProdutoRepositoryInterface::class);
    }
    /**
     * @test
     */
    public function usuarioDiferenteDoUsuarioProduto()
    {
        $this->expectException(AccessDeniedHttpException::class);
        $produtoId = 10;
        $produtoUsuarioId = 2;
        $usuarioId = 1;
        $produto = new Produto();
        $produto->id = $produtoId;
        $produto->usuario_id = $produtoUsuarioId;
        Auth::shouldReceive('id')->once()->andReturn($usuarioId);
        $this->produtoRepositoryStub
            ->expects(self::once())
            ->method('buscar')
            ->with($produtoId)
            ->willReturn($produto);
        $action = new ApagarProdutoAction($this->produtoRepositoryStub);

        $action->execute($produtoId, $produtoUsuarioId);
    }

    /**
     * @test
     */
    public function produtoNaoEncontrado()
    {
        $this->expectException(NotFoundHttpException::class);
        $produtoId = 10;
        $produtoUsuarioId = 2;
        Auth::shouldReceive('id')->once()->andReturn($produtoUsuarioId);
        $this->produtoRepositoryStub
            ->expects(self::once())
            ->method('buscar')
            ->with($produtoId)
            ->willReturn(null);

        $action = new ApagarProdutoAction($this->produtoRepositoryStub);

        $action->execute($produtoId, $produtoUsuarioId);
    }

    /**
     * @test
     */
    public function apagarProdutoJuntoEstoque()
    {
        $produtoId = 10;
        $produtoUsuarioId = 3;
        $novaProduto = new Produto();
        $novaProduto->id = 3;
        $novaProduto->usuario_id = 3;
        Auth::shouldReceive('id')->once()->andReturn($produtoUsuarioId);
        $this->produtoRepositoryStub->expects(self::once())
            ->method('buscar')
            ->willReturn($novaProduto);
        $this->produtoRepositoryStub->expects(self::once())
            ->method('apagarJuntoEstoque');
        $action = new ApagarProdutoAction($this->produtoRepositoryStub);

        $resultado = $action->execute($produtoId, $produtoUsuarioId);

        $this->assertEquals(null, $resultado);
    }
}
