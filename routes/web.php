<?php

use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\SeasonsController;
use App\Http\Controllers\SeriesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/series');
});

Route::resource('/series', SeriesController::class)
    ->except(['show']);

//Route::resource('/series', SeriesController::class)
    //->only(['index', 'create', 'store', 'edit', 'update']);

// Também é possível utilizar no resource 
Route::delete('/series/destroy/{series}', [SeriesController::class, 'destroy'])
    ->name('series.destroy');

/* Substituido pelo código acima. - Linha 21.
Route::controller(SeriesController::class)->group(function() {
    Route::get('/series', 'index')->name('series.index');
    Route::get('/series/criar', 'create')->name('series.create');
    Route::post('/series/salvar', 'store')->name('series.store');
}); */

Route::get('/series/{series}/seasons', [SeasonsController::class, 'index'])->name('seasons.index');

Route::get('seasons/{season}/episodes', [EpisodesController::class, 'index'])->name('episodes.index');
Route::post('seasons/{season}/episodes', function(\Illuminate\Http\Request $request) {
    dd($request->all());
});