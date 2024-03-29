<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Livewire\Instrument\InstrumentClass;
use App\Livewire\Contratos\ListadoContratos;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ActuacionController;
use App\Http\Controllers\ContratosController;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\ListasUsersController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::group(['middleware' => 'auth'], function () {
    Route::resource('tasks', \App\Http\Controllers\TasksController::class);
    Route::resource('users', \App\Http\Controllers\UsersController::class);

    Route::resource('instrument',InstrumentClass::class);
    Route::resource('calendar',CalendarController::class);

    Route::get('/actuacion/createtocontract/{contratos}', [ActuacionController::class, 'createtocontract'])->name('actuacion.createtocontract');
    Route::resource('actuacion',ActuacionController::class);

    Route::resource('contratos',ListadoContratos::class);

    Route::resource('listas',ListaController::class);

    Route::get('/listas/actuacion/{actuacion_id}', [ListaController::class, 'actuacion'])->name('listas.actuacion');

    Route::post('/listauser', [ListasUsersController::class, 'store']);
    Route::delete('/listauser/{listaId}/{usuarioId}', [ListasUsersController::class, 'destroy']);


});

Route::get('/greeting/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'es'])) {
        abort(400);
    }
 
    App::setLocale($locale); 
    return view('dashboard');
});






//Route::get('/search-contratos', ContratosClass::class);

Route::get('/manifest.json', function () {
    $manifestService = app(\App\Services\ManifestService::class);
    $manifest = $manifestService->generate();

    return response($manifest, 200)
        ->header('Content-Type', 'application/json');
});
