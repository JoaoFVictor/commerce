<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produto';
    protected $primaryKey = 'id';
    protected $fillable = [
        'codigo_barras',
        'nome',
        'marca',
        'preco_custo',
        'preco_venda',
        'validade',
        'usuario_id',
    ];
    protected $casts = [
        'preco_custo' => 'float',
        'preco_venda' => 'float',
        'usuario_id' => 'int',
    ];

    public function getValidadeAttribute($value)
    {
        if ($value) {
            return Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y');
        }
    }

    public function setValidadeAttribute($value)
    {
        if ($value != null) {
            $this->attributes['validade'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
        }
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function estoque()
    {
        return $this->hasOne(Estoque::class, 'produto_id');
    }
}
