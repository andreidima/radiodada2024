<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Apps\AplicatieController;
use App\Http\Controllers\Apps\ActualizareController;
use App\Http\Controllers\Apps\PontajController;

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


Route::group(['middleware' => 'auth'], function () {
    Route::view('/acasa', 'acasa');

    Route::resource('/apps/aplicatii', AplicatieController::class)->parameters(['aplicatii' => 'aplicatie']);
    Route::resource('/apps/actualizari', ActualizareController::class)->parameters(['actualizari' => 'actualizare']);
    Route::resource('/apps/pontaje', PontajController::class)->parameters(['pontaje' => 'pontaj']);
});
