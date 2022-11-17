<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioToken extends Model
{
    use HasFactory;

    protected string $table = 'personal_access_tokens';
}
