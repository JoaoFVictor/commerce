<?php

namespace App\Models\Notificacao;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacaoMensagemCliente extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'mensagens_clientes';

    protected $fillable = [
        'visualizada',
        'cliente_id',
        'mensagem_id',
    ];

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'id', 'cliente_id');
    }

    public function mensagem()
    {
        return $this->hasOne(NotificacaoMensagem::class, 'id', 'mensagem_id');
    }
}
