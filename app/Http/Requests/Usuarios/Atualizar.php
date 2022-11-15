<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

class Atualizar extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email'],
            'telefone' => ['required', 'string', 'max:14', 'regex:/^\([1-9]{2}\)[0-9]{4,5}-[0-9]{4}$/'],
            'imagem' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'plano' => ['required', 'string', 'max:50'],
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function bodyParameters(): array
    {
        return [
            'nome' => [
                'description' => 'Nome do usuário.',
                'example' => 'Davi Golias',
            ],
            'email' => [
                'description' => 'E-amil do usuário.',
                'example' => 'davigolias@email.com',
            ],
            'telefone' => [
                'description' => 'Telefone do usuário.',
                'example' => '(38)980028922',
            ],
            'imagem' => [
                'description' => 'Imagem do usuário.',
                'example' => __DIR__.'/queijo.jpg',
            ],
            'plano' => [
                'description' => 'Plano do usuário.',
                'example' => 'Branco',
            ],
        ];
    }
}
