<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;

    protected $table = 'estoque';

    protected $primaryKey = 'id';

    protected $fillable = [
        'quantidade',
        'produto_id',
    ];

    protected $casts = [
        'produto_id' => 'int',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
