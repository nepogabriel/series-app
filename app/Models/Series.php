<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];
    //protected $primaryKey = 'id'; // Dessa forma posso dizer qual coluna vou referenciar (não consegui usar)
    //protected $with = ['temporadas']; // Sempre que chamar o model Serie também irá o relacionamento com o model Season (temporadas)

    // Fazendo relacionamento com a model de temporada 1-n (1 sério - muitas temporadas)
    public function seasons()
    {
        return $this->hasMany(Season::class, 'series_id', 'id');
    }

    protected static function booted()
    {
        self::addGlobalScope('ordered', function(Builder $queryBuilder) {
            $queryBuilder->orderBy('nome');
        });
    }
}
