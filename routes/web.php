<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VoteazaPropuneController;

// use App\Http\Controllers\Apps\AppsAplicatieController;
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
Auth::routes(['register' => false, 'password.request' => false, 'reset' => false]);


Route::redirect('/', '/acasa');

Route::resource('voteaza-si-propune', App\Http\Controllers\VoteazaPropuneController::class)->only([
    'create', 'store'
]);
Route::get('voteaza-si-propune/inregistrare-tombola-pasul-1', [App\Http\Controllers\VoteazaPropuneController::class, 'inregistrareTombolaPasul1']);
Route::post('voteaza-si-propune/inregistrare-tombola-pasul-1', [App\Http\Controllers\VoteazaPropuneController::class, 'postInregistrareTombolaPasul1']);
Route::get('voteaza-si-propune/inregistrare-tombola-pasul-2', [App\Http\Controllers\VoteazaPropuneController::class, 'inregistrareTombolaPasul2'])->name('inregistrareTombolaPasul2');

Route::get('/cronjobs/extragere-castigator-tombola/{key}', [App\Http\Controllers\CronJobController::class, 'extragereCastigatorTombola']);

Route::middleware(['auth'])->group(function () {
    // Route::get('/', function () {
    //     return view('piese');
    // });

    Route::redirect('/', '/piese/categorie/Top International');

    Route::resource('piese', App\Http\Controllers\PiesaController::class,  ['parameters' => ['piese' => 'piesa']]);

    Route::resource('artisti', App\Http\Controllers\ArtistController::class,  ['parameters' => ['artisti' => 'artist']]);

    Route::resource('propuneri', App\Http\Controllers\PropunereController::class,  ['parameters' => ['propuneri' => 'propunere']]);

    Route::get('/piese/categorie/{categorie}', [App\Http\Controllers\PiesaController::class, 'index']);

    Route::resource('tombole', App\Http\Controllers\TombolaController::class,  ['parameters' => ['tombole' => 'tombola']]);
});
