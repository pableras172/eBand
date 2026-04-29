<?php

use App\Http\Controllers\Central\TenantAccessController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TenantAccessController::class, 'index'])->name('tenant-access.index');
Route::post('/tenant/access', [TenantAccessController::class, 'store'])->name('tenant-access.store');
