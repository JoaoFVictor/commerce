<?php

namespace App\Models\Notificacao;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NotificacaoClienteTopico extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'clientes_topicos';

    protected $fillable = [
        'titulo',
        'conteudo',
        'cliente_id',
        'topico_id',
    ];

    public function cliente(): HasOne
    {
        return $this->hasOne(Cliente::class, 'id', 'cliente_id');
    }

    public function topico(): HasOne
    {
        return $this->hasOne(NotificacaoTopico::class, 'id', 'topico_id');
    }
}
