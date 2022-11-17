<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected string $table = 'usuarios';

    protected string $primaryKey = 'id';

    protected array $fillable = [
        'nome',
        'email',
        'senha',
        'status',
        'codigo_confirmacao',
        'telefone',
        'imagem_id',
        'plano',
    ];

    protected array $hidden = [
        'senha',
        'codigo_confirmacao',
    ];

    protected array $casts = [
        'status' => 'boolean',
    ];

    public function getPasswordAttribute(): string
    {
        return $this->senha;
    }

    public function setPasswordAttribute($value): void
    {
        $this->attributes['senha'] = $value;
    }

    public function imagem(): BelongsTo
    {
        return $this->belongsTo(Imagem::class);
    }
}
