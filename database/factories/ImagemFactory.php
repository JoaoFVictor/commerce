<?php

namespace Database\Factories;

use App\Models\Imagem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImagemFactory extends Factory
{
    protected $model = Imagem::class;

    public function definition()
    {
        return [
            'caminho' => $this->faker->imageUrl(),
            'descricao' => $this->faker->sentence(),
        ];
    }
}
