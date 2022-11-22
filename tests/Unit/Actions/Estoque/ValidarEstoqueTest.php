<?php

namespace Tests\Unit\Actions\Estoque;

use App\Actions\Estoque\ValidarEstoqueAction;
use App\Models\Produto;
use App\Repository\Produto\ProdutoRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class ValidarEstoqueTest extends TestCase
{
    /**
     * @test
     */
    public function estoqueValido()
    {
        $quantidadeEmEstoque = 10;
        $produto = [
            'quantidade' => 3,
        ];

        $resultado = app(ValidarEstoqueAction::class)->execute($quantidadeEmEstoque, $produto, true);

        $this->assertEquals(null, $resultado);
    }

    /**
     * @test
     */
    public function estoqueInvalido()
    {
        $this->expectException(HttpException::class);

        $produto = new Produto();
        $produto->nome = 'teste';
        $quantidadeEmEstoque = 3;
        $produtoDados = [
            'quantidade' => 10,
            'id' => 1,
        ];
        $stub = $this->createMock(ProdutoRepositoryInterface::class);
        $stub->method('buscar')
            ->willReturn($produto);
        $action = new ValidarEstoqueAction($stub);

        $action->execute($quantidadeEmEstoque, $produtoDados, true);
    }
}
