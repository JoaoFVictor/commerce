<?php

namespace Tests\Unit\Actions\Produto;

use App\Actions\Produto\BuscarValorTotalProdutoAction;
use App\Models\Produto;
use App\Repository\Produto\ProdutoRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BuscarValorTotalProdutoTest extends TestCase
{
    protected function setUp(): void
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
        $valorTotal = 10.0;

        $novaProduto = new Produto();
        $novaProduto->id = 3;
        $this->produtoRepositoryStub
            ->expects(self::once())
            ->method('buscarValorTotal')
            ->willReturn($valorTotal);
        $action = new BuscarValorTotalProdutoAction($this->produtoRepositoryStub);

        $resposta = $action->execute();

        $this->assertEquals($valorTotal, $resposta);
    }
}
