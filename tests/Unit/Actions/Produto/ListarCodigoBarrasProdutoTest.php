<?php

namespace Tests\Unit\Actions\Produto;

use App\Actions\Produto\ListarCodigoBarrasProdutoAction;
use App\Repository\Produto\ProdutoRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ListarCodigoBarrasProdutoTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->produtoRepositoryStub = $this->createMock(ProdutoRepositoryInterface::class);
    }

    /**
     * @test
     */
    public function sucessoSemEstoque()
    {
        $usuarioId = 1;
        Auth::shouldReceive('id')->once()->andReturn($usuarioId);

        $codigoBarras = '123';
        $dados = [];
        $produtoId = 1;
        $filtro = [
            'codigo_barras' => $codigoBarras,
        ];
        $produtos = new Paginator([], 10, 1);

        $this->produtoRepositoryStub
            ->expects(self::once())
            ->method('listar')
            ->with($produtoId, $filtro, null)
            ->willReturn($produtos);
        $action = new ListarCodigoBarrasProdutoAction($this->produtoRepositoryStub);
        $action->execute($codigoBarras, $dados);
    }

    /**
     * @test
     */
    public function sucessoComEstoque()
    {
        $usuarioId = 1;
        Auth::shouldReceive('id')->once()->andReturn($usuarioId);

        $codigoBarras = '123';
        $produtoId = 1;
        $dados = [
            'has_estoque' => true,
        ];
        $filtro = [
            'codigo_barras' => $codigoBarras,
        ];
        $produtos = new Paginator([], 10, 1);
        $this->produtoRepositoryStub
            ->expects(self::once())
            ->method('listar')
            ->with($produtoId, $filtro, 0)
            ->willReturn($produtos);

        $action = new ListarCodigoBarrasProdutoAction($this->produtoRepositoryStub);
        $action->execute($codigoBarras, $dados);
    }
}
