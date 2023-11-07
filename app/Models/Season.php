<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    // Fazendo relacionamento com a model serie 1-n (1 sério - muitas temporadas)
    public function series() {
        return $this->belongsTo(Serie::class);
    }
}
