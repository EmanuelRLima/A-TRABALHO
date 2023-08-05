<?php

namespace App\Models;

use App\Models\Scopes\OrderById;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCategory extends Model
{
    protected $fillable = [
        'name',
    ];

    public const ADM = 1;
    public const EMPRESA = 2;
    public const TRABALHADOR = 3;
    public const CONTADOR = 4;
    public const RECRUTADOR = 5;
    
    // ORDENAÇÃO PADRÃO POR ID
	
    public function user()
    {
        $this->belongsTo(User::class);
    }

}
