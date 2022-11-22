<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

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

    public function getValidadeAttribute($value): ?string
    {
        if ($value) {
            return Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y');
        }
    }

    public function setValidadeAttribute($value): void
    {
        if ($value != null) {
            $this->attributes['validade'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
        }
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    public function estoque(): HasOne
    {
        return $this->hasOne(Estoque::class, 'produto_id');
    }
}
