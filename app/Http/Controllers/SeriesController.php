<?php

namespace App\Http\Controllers;
use App\Http\Requests\SeriesFormsRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        //$series = DB::select('SELECT nome FROM series');
        
        //$series = Serie::all();

        // O query() retorna uma query pronta e o "get()" está executando esta query
        //$series = Serie::query()->orderBy('nome', 'desc')->get();

        $series = Series::with('seasons')->get(); // with() neste caso é para trazer o relacionamento com o Model Season (temporadas)

        // Resgatando mensagem de sucesso na sessão
        //$mensagemSucesso = $request->session()->has(); // has() verifica se o dado existe na sessão
        $mensagemSucesso = $request->session()->get('mensagem.sucesso'); // Resgatando mensagem sem verificar se existe, caso não irá retornar null

        // Removendo a mensagem de sucesso (usando o session()->flash não precisa remover, pois flash() dura apenas 1 request)
        //$request->session()->forget('mensagem.sucesso');

        //return view('listar-series', compact($series));
        return view('series.index', ['series' => $series])
            ->with('mensagemSucesso', $mensagemSucesso); // Mesma coisa da linha de cima
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormsRequest $request)
    {
        // Ajuda a debugar
        //dd($request->all());


        /* Substituido pelo SeriesFormsRequest
        $request->validate([
            'nome' => ['required', 'min:3']
        ]); */

        //$nomeSerie = $request->input('nome');

        // 1- Primeira forma de salvar no BD
        //DB::insert('INSERT INTO series (nome) VALUES (?)', [$nomeSerie]);
        
        /*
        2- Segunda forma de salvar no BD
        $serie = new Serie();
        $serie->nome = $nomeSerie;
        $serie->save();
        */

        
        // Busca somente o campo nome
        //Serie::create($request->only(['nome']));

        // Busca todos os campos com exceção do token 
        //Serie::create($request->except(['_token']));

        $serie = DB::transaction(function() use($request, &$serie) {
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

        /* Substituido pelo código acima (Reduzindo muito a quantidade de queries executadas)
        for ($i = 1; $i <= $request->seasonsQty; $i++) {
            $season = $serie->seasons()->create([
                'number' => $i,
            ]);

            for ($j = 1; $j <= $request->episodesPerSeason; $j++) {
                $season->episodes()->create([
                    'number' => $j,
                ]);
            }
        }*/

        //return redirect()->route('series.index'); - Também funciona
        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$serie->nome}' criada com sucesso!"); // Utilizando o flash() diretamente no redirecionamento
    }

    public function destroy(Series $series)
    {
        //Serie::destroy($request->id);
        $series->delete();

        // Adicionar mensagem na sessão
        //$request->session()->put('mensagem.sucesso', 'Série removida com sucesso!');

        // Adicionar dado na sessão com flash(), ao resgatar o dado o memso será removido da sessão automaticamente
        //session()->flash('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso!");

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso!"); // Utilizando o flash() diretamente no redirecionamento
    }

    public function edit(Series $series)
    {
        return view('series.edit')->with('series', $series);
    }

    public function update(Series $series, SeriesFormsRequest $request)
    {
        /*
        $series->nome = $request->nome;
        */

        // É necessário o $fillable para funcionar
        $series->fill($request->all());
        $series->save();
        

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' atualizada com sucesso!");
    }
}