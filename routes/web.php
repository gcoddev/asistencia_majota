<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('inicio');
});
Route::prefix('admin')->middleware('usuario_autenticado')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('inicio');

    Route::resource('roles', RolesController::class, ['names' => 'admin.roles']);
    Route::get('/roles/{id}/permissions', [RolesController::class, 'getPermissions'])->name('admin.roles.permissions');
});

Route::middleware('usuario_no_autenticado')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'postLogin'])->name('post_login');
});
