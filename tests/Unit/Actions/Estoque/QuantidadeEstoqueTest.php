<?php

namespace Tests\Unit\Actions\Estoque;

use App\Actions\Estoque\QuantidadeNovaEstoqueAction;
use Tests\TestCase;

class QuantidadeEstoqueTest extends TestCase
{
    private $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = new QuantidadeNovaEstoqueAction();
    }

    /**
     * @test
     */
    public function removerItemDoEstoque()
    {
        $quantidadeEmEstoque = 10;
        $quantidadeRemocao = 3;
        $quantidadeNova = $quantidadeEmEstoque - $quantidadeRemocao;

        $novoEstoque = $this->action->execute($quantidadeEmEstoque, $quantidadeRemocao, true);

        $this->assertEquals($quantidadeNova, $novoEstoque);
    }

    /**
     * @test
     */
    public function adicionarItemDoEstoque()
    {
        $quantidadeEmEstoque = 10;
        $quantidadeRemocao = 3;
        $quantidadeNova = $quantidadeEmEstoque + $quantidadeRemocao;

        $novoEstoque = $this->action->execute($quantidadeEmEstoque, $quantidadeRemocao, false);

        $this->assertEquals($quantidadeNova, $novoEstoque);
    }
}
