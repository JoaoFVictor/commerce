<?php

namespace App\Http\Requests\Produto;

use Illuminate\Foundation\Http\FormRequest;

class BuscarProduto extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'has_estoque' => ['nullable', 'boolean'],
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function queryParameters(): array
    {
        return [
            'has_estoque' => [
                'description' => 'Produto em estoque.',
                'example' => true,
            ],
        ];
    }
}
