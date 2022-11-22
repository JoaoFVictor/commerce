<?php

namespace Tests\Unit\Actions\Produto;

use App\Actions\Produto\ListarProdutoAction;
use App\Repository\Produto\ProdutoRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ListarProdutoTest extends TestCase
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

        $action = new ListarProdutoAction($this->produtoRepositoryStub);
        $action->execute([]);
    }

    /**
     * @test
     */
    public function sucessoComQuantidadeMinima()
    {
        $usuarioId = 1;
        Auth::shouldReceive('id')->once()->andReturn($usuarioId);
        $quantidadeMinima = 10;
        $dados = [
            'quantidade_minima' => $quantidadeMinima,
        ];

        $action = new ListarProdutoAction($this->produtoRepositoryStub);
        $action->execute($dados);
    }
}
