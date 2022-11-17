<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
{
    use HasFactory;

    protected string $table = 'imagens';

    protected string $primaryKey = 'id';

    protected array $fillable = [
        'caminho',
        'descricao',
    ];
}
