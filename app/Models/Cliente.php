<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cliente extends Model
{
    use HasFactory;

    protected string $primaryKey = 'id';

    protected string $table = 'clientes';

    protected array $fillable = [
        'nome',
        'telefone',
        'bairro',
        'rua',
        'numero',
        'cpf',
        'usuario_id',
    ];

    public function usuario(): HasOne
    {
        return $this->hasOne(Usuario::class, 'id', 'usuario_id');
    }
}
