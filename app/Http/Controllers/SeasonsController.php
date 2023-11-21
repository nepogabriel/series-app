<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Models\Series;
use Illuminate\Http\Request;

class SeasonsController extends Controller
{
    public function index(Series $series)
    {
        // Esta sintaxe eu não tenho nenhuma informação da série
        /*$seasons = Season::query()
            ->with('episodes')
            ->where('serie_id', $series)
            ->get();*/

        // Esta sintaxe é o relacionamento de seasons
        $seasons = $series->seasons()->with('episodes')->get();

        // Esta sintaxe é uma collection
        //$seasons = $series->seasons;
        
        return view('seasons.index')->with('seasons', $seasons)->with('series', $series);
    }
}
