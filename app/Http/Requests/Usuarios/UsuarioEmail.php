<?php

namespace App\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioEmail extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'max:50', 'exists:usuarios,email'],
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
        ];
    }
}
