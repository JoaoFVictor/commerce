<?php

namespace App\Repository\Imagem;

use App\Models\Imagem;

interface ImagemRepositoryInterface
{
    public function criar(string $imagemCaminho, string $descricao): Imagem;

    public function apagar(int $imagemId): void;
}
