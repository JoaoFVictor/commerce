<?php

namespace App\Http\Requests\Produto;

use App\Rules\CodigoDeBarrasUnicoParaUsuario;
use Illuminate\Foundation\Http\FormRequest;

class AtualizarProduto extends FormRequest
{
    private const URL_SEGMENTO_PRODUTO_ID = 2;

    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $regraCodigoBarras = function () {
            $regra = new CodigoDeBarrasUnicoParaUsuario();

            return $regra->setNomeProduto($this->input('nome'))->setProduto($this->segment(self::URL_SEGMENTO_PRODUTO_ID));
        };

        return [
            'codigo_barras' => ['string', 'filled', 'max:128', $regraCodigoBarras()],
            'nome' => ['string', 'filled', 'max:60'],
            'marca' => ['string', 'filled', 'max:25'],
            'preco_venda' => ['numeric', 'filled', 'gte:0'],
            'preco_custo' => ['numeric', 'filled', 'gte:0'],
            'validade' => ['nullable', 'date_format:d-m-Y'],
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function bodyParameters(): array
    {
        return [
            'codigo_barras' => [
                'description' => 'Código de barras do produto.',
                'example' => '7898357417892',
            ],
            'nome' => [
                'description' => 'Nome do produto.',
                'example' => 'vassoura',
            ],
            'preco_venda' => [
                'description' => 'Preço de venda do produto.',
                'example' => 10.20,
            ],
            'preco_custo' => [
                'description' => 'Preço de custo do produto.',
                'example' => 5.20,
            ],
            'marca' => [
                'description' => 'Marca do produto.',
                'example' => 'apple',
            ],
            'validade' => [
                'description' => 'Data de validade do produto.',
                'example' => '2025-04-29',
            ],
        ];
    }
}
