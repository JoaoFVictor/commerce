<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UsuarioCriar extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function passedValidation(): void
    {
        $this->merge([
            'senha' => Hash::make($this->input('senha')),
        ]);
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'max:100', 'email', 'unique:usuarios'],
            'telefone' => ['required', 'string', 'max:14', 'regex:/^\([1-9]{2}\)[0-9]{4,5}-[0-9]{4}$/'],
            'senha' => ['required', 'string', 'min:8', 'max:20'],
            'lembrar' => ['nullable', 'boolean'],
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
                'example' => 'Pedro Paulo',
            ],
            'email' => [
                'description' => 'Email do usuário.',
                'example' => 'email@email.com',
            ],
            'telefone' => [
                'description' => 'telefone do usuário.',
                'example' => '(38)3221-2011',
            ],
            'senha' => [
                'description' => 'Senha do usuário.',
                'example' => 'senha@@@',
            ],
            'lembrar' => [
                'description' => 'Lembrar do usuário.',
                'example' => false,
            ],
        ];
    }
}
