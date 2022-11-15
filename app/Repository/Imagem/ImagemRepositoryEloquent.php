<?php

namespace App\Repository\Imagem;

use App\Models\Imagem;

class ImagemRepositoryEloquent implements ImagemRepositoryInterface
{
    public function __construct(private Imagem $model)
    {
        $this->model = $model;
    }

    public function criar(string $imagemCaminho, string $descricao): Imagem
    {
        return $this->model->create([
            'caminho' => $imagemCaminho,
            'descricao' => $descricao,
        ]);
    }

    public function apagar(int $imagemId): void
    {
        $this->model->find($imagemId)->delete();
    }
}
