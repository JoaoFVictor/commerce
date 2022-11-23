<?php

namespace App\Models\Notificacao;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificacaoTopico extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'topicos';

    protected $fillable = [
        'nome',
    ];
}
