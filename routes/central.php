<?php

use App\Http\Controllers\Central\TenantAccessController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DemoAccessController;
use App\Http\Controllers\MasInfoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Central Routes (eband.app)
|--------------------------------------------------------------------------
|
| Rutas accesibles desde el dominio central (eband.app).
| Muestra la landing de venta y gestión de acceso a las bandas.
|
*/

// Landing page de venta
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Acceso de miembros a su banda (mediante código que redirige a xxx.eband.app)
Route::get('/acceso', [TenantAccessController::class, 'index'])->name('tenant-access.index');
Route::get('/login', [TenantAccessController::class, 'index'])->name('login');
Route::post('/tenant/access', [TenantAccessController::class, 'store'])->name('tenant-access.store');

// Enlaces de cortesía para la landing
Route::get('/register', fn () => redirect('/#contact'))->name('central.register');
Route::get('/dashboard', fn () => redirect()->route('tenant-access.index', ['code' => 'demo']))->name('central.dashboard');

// Formulario de contacto
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Acceso a demo instantánea
Route::post('/demo-access', [DemoAccessController::class, 'store'])
    ->middleware(['throttle:demo-access'])
    ->name('demo.access');

// Información y solicitud comercial
Route::get('/masinfo', [MasInfoController::class, 'create'])->name('masinfo.create');
Route::post('/masinfo', [MasInfoController::class, 'store'])->name('masinfo.store');
