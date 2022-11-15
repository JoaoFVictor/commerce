<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'telefone',
        'bairro',
        'rua',
        'numero',
        'cpf',
        'usuario_id',
    ];

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id', 'usuario_id');
    }
}
