<?php

namespace Tests\Unit\Actions\Produto;

use App\Actions\Produto\ListarNomeProdutoAction;
use App\Repository\Produto\ProdutoRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ListarNomeProdutoTest extends TestCase
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

        $produtoNome = 'Nome Teste';
        $dados = [];
        $produtoId = 1;
        $filtro = [
            'nome' => $produtoNome,
        ];
        $produtos = new Paginator([], 10, 1);

        $this->produtoRepositoryStub
            ->expects(self::once())
            ->method('listar')
            ->with($produtoId, $filtro, null)
            ->willReturn($produtos);
        $action = new ListarNomeProdutoAction($this->produtoRepositoryStub);
        $action->execute($produtoNome, $dados);
    }

    /**
     * @test
     */
    public function sucessoComEstoque()
    {
        $usuarioId = 1;
        Auth::shouldReceive('id')->once()->andReturn($usuarioId);

        $produtoNome = 'Nome Teste';
        $produtoId = 1;
        $dados = [
            'has_estoque' => true,
        ];
        $filtro = [
            'nome' => $produtoNome,
        ];
        $produtos = new Paginator([], 10, 1);
        $this->produtoRepositoryStub
            ->expects(self::once())
            ->method('listar')
            ->with($produtoId, $filtro, 0)
            ->willReturn($produtos);

        $action = new ListarNomeProdutoAction($this->produtoRepositoryStub);
        $action->execute($produtoNome, $dados);
    }
}
