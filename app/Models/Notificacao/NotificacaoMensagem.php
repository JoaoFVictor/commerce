<?php

namespace App\Models\Notificacao;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacaoMensagem extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'mensagens';

    protected $fillable = [
        'titulo',
        'conteudo',
        'usuario_id',
        'topico_id',
    ];

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id', 'usuario_id');
    }

    public function topico()
    {
        return $this->hasOne(NotificacaoTopico::class, 'id', 'topico_id');
    }
}
