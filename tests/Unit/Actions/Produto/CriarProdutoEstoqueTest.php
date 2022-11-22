<?php

namespace Tests\Unit\Actions\Produto;

use App\Actions\Produto\CriarProdutoAction;
use App\Models\Estoque;
use App\Models\Produto;
use App\Repository\Estoque\EstoqueRepositoryInterface;
use App\Repository\Produto\ProdutoRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class CriarProdutoEstoqueTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->produtoRepository = $this->createMock(ProdutoRepositoryInterface::class);
        $this->estoqueRepository = $this->createMock(EstoqueRepositoryInterface::class);
        $this->action = new CriarProdutoAction($this->produtoRepository, $this->estoqueRepository);
        $this->dados = [
            'produtos' => [
                [
                    'codigo_barras' => 'E1W5Q61EW5Q6E1WQ65',
                    'nome' => 'Produto Teste',
                    'marca' => 'Marca Teste',
                    'validade' => '01-01-2030',
                ],
            ],
        ];
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
        $novaEstoque = new Estoque();
        $novaEstoque->id = 1;
        $novaEstoque->produto_id = 3;
        $this->produtoRepository->expects(self::once())
            ->method('criar')
            ->willReturn($novaProduto);
        $this->estoqueRepository->expects(self::once())
            ->method('criar')
            ->willReturn($novaEstoque);

        $resposta = $this->action->execute($this->dados);

        $this->assertEquals($resposta, [$novaProduto]);
    }

    /**
     * @test
     */
    public function falha()
    {
        $this->expectException(HttpException::class);
        DB::shouldReceive('transaction')
            ->andReturn(true);
        $novaProduto = new Produto();
        $novaProduto->id = 3;
        $novaEstoque = new Estoque();
        $novaEstoque->id = 1;
        $novaEstoque->produto_id = 3;

        $this->action->execute($this->dados);
    }
}
