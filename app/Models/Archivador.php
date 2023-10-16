<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Archivador extends Model
{
    use HasFactory;

    public function area(): BelongsTo
    {
        return $this->belongsTo(Dependencia::class, 'idDependencia', 'id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idUser', 'id');
    }
    
}
