<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    protected $table = 'usuarios';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nome',
        'email',
        'senha',
        'status',
        'codigo_confirmacao',
        'telefone',
        'imagem_id',
        'plano',
    ];

    protected $hidden = [
        'senha',
        'codigo_confirmacao',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getPasswordAttribute()
    {
        return $this->senha;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['senha'] = $value;
    }

    public function produto()
    {
        return $this->hasMany(Produto::class);
    }

    public function social()
    {
        return $this->hasOne(Social::class);
    }

    public function menu()
    {
        return $this->hasMany(Menu::class);
    }

    public function imagem()
    {
        return $this->belongsTo(Imagem::class);
    }
}
