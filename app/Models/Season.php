<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['number'];

    // Fazendo relacionamento com a model serie 1-n (1 sério - muitas temporadas)
    public function series() {
        return $this->belongsTo(Serie::class);
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }
}
