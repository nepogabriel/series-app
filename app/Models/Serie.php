<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];
    protected $primaryKey = 'id'; // Dessa forma posso dizer qual coluna vou referenciar

    // Fazendo relacionamento com a model de temporada 1-n (1 sério - muitas temporadas)
    public function temporadas()
    {
        return $this->hasMany(Season::class, 'series_id', 'id');
    }
}
