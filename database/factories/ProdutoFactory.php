<?php

namespace Database\Factories;

use App\Models\Produto;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    protected $model = Produto::class;

    public function definition()
    {
        return [
            'codigo_barras' => $this->faker->ean13(),
            'nome' => $this->faker->name(),
            'marca' => $this->faker->text(24),
            'preco_custo' => 10,
            'preco_venda' => 15,
            'validade' => now()->format('d-m-Y'),
            'usuario_id' => Usuario::factory()->create()->getKey(),
        ];
    }
}
