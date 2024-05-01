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
use App\Http\Controllers\TipoActuacionController;

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

Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified',])->group(
    function () {
        
        Route::get('/', function () {return view('dashboard');})->name('dashboard');
        Route::resource('tasks', \App\Http\Controllers\TasksController::class);
        Route::resource('users', \App\Http\Controllers\UsersController::class);
        
        Route::resource('tipoactuacion',TipoActuacionController::class);

        Route::resource('instrument',InstrumentClass::class);
        Route::resource('calendar',CalendarController::class);

        Route::get('/actuacion/createtocontract/{contratos}', [ActuacionController::class, 'createtocontract'])->name('actuacion.createtocontract');

        Route::get('/actuaciones/{user}/{year}', [ActuacionController::class, 'getTotalActuacionesUsuario'])->name('actuaciones.usuario.anyo');
        Route::get('/actuaciones/{user}/{year}/{type}', [ActuacionController::class, 'getListadoActuacionesUsuarioAndTipo'])->name('actuaciones.usuario.listatipo');

        Route::get('/descargarCalendario/{actuacionId}', [ActuacionController::class, 'descargarCalendario']);

        Route::get('/actuaciones-tipo/{tipoactuacion}', [ActuacionController::class, 'getActuacionesPorTipo'])->name('actuaciones-tipo');
        Route::get('/actuaciones-fecha/{fechaactuacion}', [ActuacionController::class, 'getActuacionesPorFecha'])->name('actuaciones-fecha');
        Route::get('/actuaciones-poblacion/{poblacion}', [ActuacionController::class, 'getActuacionesPorPoblacion'])->name('actuaciones-poblacion');

        Route::post('/notificaractuacionlista', [ActuacionController::class, 'notificarActuacionLista']);
        Route::post('/notificaractuacion', [ActuacionController::class, 'notificarActuacion']);        
        
        Route::resource('actuacion',ActuacionController::class);
        
        Route::resource('contratos',ListadoContratos::class);        
        Route::get('/contratos/{year}',[ListadoContratos::class,'contratosPorAnyo'])->name('contratos.anyo');        
        
        Route::resource('listas',ListaController::class);

        Route::get('/listas/actuacion/{actuacion_id}', [ListaController::class, 'actuacion'])->name('listas.actuacion');

        Route::post('/listauser', [ListasUsersController::class, 'store']);
        Route::post('/listausercar', [ListasUsersController::class, 'storecar']);
        Route::post('/listauserdisp', [ListasUsersController::class, 'setdisponible']);
        Route::delete('/listauserclean/{listaId}', [ListasUsersController::class, 'clean']);
        Route::delete('/listauser/{listaId}/{usuarioId}', [ListasUsersController::class, 'destroy']);   
        
        Route::get('/usersuuid/{user}',[\App\Http\Controllers\UsersController::class,'getuuid']);
});

/*
Route::group(['middleware' => 'auth'], 
    function () {
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
*/

/*Route::get('/greeting/{locale}', function (string $locale) {
    if (! in_array($locale, ['ca_VL', 'es'])) {
        abort(400);
    }
 
    App::setLocale($locale); 
    return view('dashboard');
});*/

Route::get('/greeting/{locale}', function (string $locale) {
    if (! in_array($locale, ['ca_VL', 'es'])) {
        abort(400);
    }

    // Establecer la cookie de preferencia de idioma
    $response = redirect()->route('dashboard')->withCookie(cookie('locale', $locale, 30 * 24 * 60));

    return $response;
});

//Route::get('/search-contratos', ContratosClass::class);

Route::get('/manifest.json', function () {
    $manifestService = app(\App\Services\ManifestService::class);
    $manifest = $manifestService->generate();

    return response($manifest, 200)
        ->header('Content-Type', 'application/json');
});
