<?php

namespace Tests\Unit\Actions\Produto;

use App\Actions\Produto\BuscarProdutoAction;
use App\Models\Produto;
use App\Repository\Produto\ProdutoRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class BuscarProdutoEstoqueTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->produtoRepositoryStub = $this->createMock(ProdutoRepositoryInterface::class);
    }

    /**
     * @test
     */
    public function sucesso()
    {
        $usuarioId = 1;
        Auth::shouldReceive('id')->once()->andReturn($usuarioId);
        $novaProduto = new Produto();
        $novaProduto->id = 3;
        $novaProduto->usuario_id = $usuarioId;
        $this->produtoRepositoryStub
            ->expects(self::once())
            ->method('buscar')
            ->willReturn($novaProduto);
        $action = new BuscarProdutoAction(
            $this->produtoRepositoryStub
        );

        $resposta = $action->execute($novaProduto->id);

        $this->assertEquals($resposta, $novaProduto);
    }

    /**
     * @test
     */
    public function falhaProdutoNaoEncontrado()
    {
        $this->expectException(NotFoundHttpException::class);
        $usuarioId = 1;
        Auth::shouldReceive('id')->once()->andReturn($usuarioId);
        $produtoId = 2;

        $this->produtoRepositoryStub
            ->expects(self::once())
            ->method('buscar')
            ->willReturn(null);
        $action = new BuscarProdutoAction(
            $this->produtoRepositoryStub
        );

        $action->execute($produtoId);
    }

    /**
     * @test
     */
    public function falhaUsuarioSemPermissao()
    {
        $this->expectException(AccessDeniedHttpException::class);
        $usuarioId = 1;
        Auth::shouldReceive('id')->once()->andReturn($usuarioId);
        $novaProduto = new Produto();
        $novaProduto->id = 3;
        $novaProduto->usuario_id = 3;

        $this->produtoRepositoryStub
            ->expects(self::once())
            ->method('buscar')
            ->willReturn($novaProduto);
        $action = new BuscarProdutoAction(
            $this->produtoRepositoryStub
        );

        $resposta = $action->execute($novaProduto->id);

        $this->assertEquals($resposta, $novaProduto);
    }
}
