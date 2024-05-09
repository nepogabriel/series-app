<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormsRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Support\Facades\DB;

class EloquentSeriesRepository implements SeriesRepository
{
    public function add(SeriesFormsRequest $request): Series
    {
        return DB::transaction(function() use($request, &$serie) {
            // Busca todos os dados, porém filtra no $fillable no Model
            $serie = Series::create($request->all());

            $seasons = [];
            for ($i = 1; $i <= $request->seasonsQty; $i++) {
                $seasons[] = [
                    'series_id' => $serie->id,
                    'number' => $i,
                ];
            }
            Season::insert($seasons);

            $episodes = [];
            foreach ($serie->seasons as $season) {
                for ($j = 1; $j <= $request->episodesPerSeason; $j++) {
                    $episodes[] = [
                        'season_id' => $season->id,
                        'number' => $j,
                    ];
                }
            }
            Episode::insert($episodes);

            return $serie;
        }, 5); // esse parâmetro "5" é chamado de deadlock, ou seja, quantas vezes irá tentar executar essa transação
    }
}