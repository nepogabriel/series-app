<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        //$series = DB::select('SELECT nome FROM series');
        
        //$series = Serie::all();

        // O query() retorna uma query pronta e o "get()" está executando esta query
        $series = Serie::query()->orderBy('nome', 'desc')->get();

        //return view('listar-series', compact($series));
        return view('series.index', ['series' => $series]); // Mesma coisa da linha de cima
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(Request $request)
    {
        //$nomeSerie = $request->input('nome');

        // 1- Primeira forma de salvar no BD
        //DB::insert('INSERT INTO series (nome) VALUES (?)', [$nomeSerie]);
        
        /*
        2- Segunda forma de salvar no BD
        $serie = new Serie();
        $serie->nome = $nomeSerie;
        $serie->save();
        */

        // Busca todos os dados, porém filtra no $fillable no Model
        Serie::create($request->all());

        // Busca somente o campo nome
        //Serie::create($request->only(['nome']));

        // Busca todos os campos com exceção do token 
        //Serie::create($request->except(['_token']));

        //return redirect()->route('series.index'); - Também funciona
        return to_route('series.index');
    }
}