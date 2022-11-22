<?php

namespace App\Http\Requests\Produto;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoFiltro extends FormRequest
{
    public function authorize()
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'quantidade_minima' => ['nullable', 'numeric', 'gte:0'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'quantidade_minima' => [
                'description' => 'Filtro de Quantidade Minima de Estoque.',
                'example' => 14,
            ],
        ];
    }
}
