<?php

namespace Database\Factories;

use App\Models\Estoque;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstoqueFactory extends Factory
{
    protected $model = Estoque::class;

    public function definition()
    {
        return [
            'quantidade' => 24,
            'produto_id' => Produto::factory()->create()->getKey(),
        ];
    }
}
