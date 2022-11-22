<?php

namespace App\Http\Requests\Produto;

use App\Rules\CodigoDeBarrasUnicoParaUsuario;
use Illuminate\Foundation\Http\FormRequest;

class CriarProduto extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $regraCodigoBarras = function () {
            $regra = new CodigoDeBarrasUnicoParaUsuario();

            return $regra->setProdutos($this->input('produtos'));
        };

        return [
            'produtos' => ['required', 'array', $regraCodigoBarras()],
            'produtos.*.codigo_barras' => ['required', 'string', 'max:128'],
            'produtos.*.nome' => ['required', 'string', 'max:60'],
            'produtos.*.marca' => ['required', 'string', 'max:25'],
            'produtos.*.validade' => ['nullable', 'date_format:d-m-Y'],
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function bodyParameters(): array
    {
        return [
            'produtos' => [
                'description' => 'Listas de produto para cadastro.',
                'example' => '[]',
            ],
            'produtos.*.codigo_barras' => [
                'description' => 'Código de barras do produto.',
                'example' => '7898357417892',
            ],
            'produtos.*.nome' => [
                'description' => 'Nome do produto.',
                'example' => 'vassoura',
            ],
            'produtos.*.marca' => [
                'description' => 'Marca do produto.',
                'example' => 'apple',
            ],
            'produtos.*.validade' => [
                'description' => 'Data de validade do produto.',
                'example' => '2025-04-29',
            ],
        ];
    }
}
