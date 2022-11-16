<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioLogar extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'max:100', 'exists:usuarios'],
            'senha' => ['required', 'string', 'min:8', 'max:20'],
        ];
    }

    /**
     * @codeCoverageIgnore
     */
    public function bodyParameters(): array
    {
        return [
            'email' => [
                'description' => 'Email do usuário.',
                'example' => 'email@email.com',
            ],
            'senha' => [
                'description' => 'Senha do usuário.',
                'example' => 'senha@@',
            ],
        ];
    }
}
