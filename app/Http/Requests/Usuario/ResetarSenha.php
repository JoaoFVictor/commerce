<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetarSenha extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'exists:usuarios,email', 'email', 'max:100'],
            'password' => ['filled', 'string', 'confirmed', Password::defaults(), 'min:8', 'max:18'],
            'password_confirmation' => ['required_with:password', 'string', Password::defaults(), 'min:8', 'max:18'],
            'token' => ['required_with:password', 'string', 'max:255'],
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
            'password' => [
                'description' => 'Senha nova do usuário.',
                'example' => 'senhanova@@',
            ],
            'password_confirmation' => [
                'description' => 'Confirmação da senha nova do usuário.',
                'example' => 'senhanova@@',
            ],
            'token' => [
                'description' => 'token do usuário.',
                'example' => '13|HfI40OFYLjWEahpM4QgWEvdqbXbVRpPIelNehKq0',
            ],
        ];
    }
}
