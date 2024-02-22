<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Livewire\Instrument\InstrumentClass;

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
});

Route::get('/greeting/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'es'])) {
        abort(400);
    }
 
    App::setLocale($locale); 
    return view('dashboard');
});

//Route::resource('instrument',\App\Http\Controllers\InstrumentController::class);

Route::resource('instrument',InstrumentClass::class);

//Route::get('/instrument/show', ShowInstrument::class)->name('instrument.show');
//Route::get('/instrument/create', CreateInstrument::class)->name('instrument.create');

