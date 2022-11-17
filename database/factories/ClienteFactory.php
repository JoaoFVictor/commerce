<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->name(),
            'telefone' => '(38)3221-8686',
            'bairro' => $this->faker->word(25),
            'rua' => $this->faker->streetName(),
            'numero' => $this->faker->buildingNumber(),
            'cpf' => '01234567890',
            'usuario_id' => Usuario::factory()->create()->id,
        ];
    }
}
