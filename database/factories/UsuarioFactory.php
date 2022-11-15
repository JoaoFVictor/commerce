<?php

namespace Database\Factories;

use App\Models\Imagem;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'senha' => Hash::make('123abc@@'),
            'status' => true,
            'telefone' => '(38)3215-2201',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'imagem_id' => Imagem::factory()->create()->getKey(),
            'plano' => 'Padrão',
        ];
    }
}
