<?php

use App\Http\Controllers\AsistenciasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompensacionesController;
use App\Http\Controllers\DeduccionesController;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\DesignacionesController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SueldosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('inicio');
});
Route::prefix('admin')->middleware('usuario_autenticado')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('inicio');

    Route::resource('/usuarios', UsuariosController::class, ['names' => 'admin.usuarios']);
    Route::resource('/departamentos', DepartamentosController::class, ['names' => 'admin.departamentos']);
    Route::resource('/designaciones', DesignacionesController::class, ['names' => 'admin.designaciones']);
    Route::resource('/permisos', PermisosController::class, ['names' => 'admin.permisos']);
    Route::resource('/sueldos', SueldosController::class, ['names' => 'admin.sueldos']);
    Route::resource('/compensaciones', CompensacionesController::class, ['names' => 'admin.compensaciones']);
    Route::resource('/deducciones', DeduccionesController::class, ['names' => 'admin.deducciones']);
    Route::resource('/asistencias', AsistenciasController::class, ['names' => 'admin.asistencias']);

    Route::resource('roles', RolesController::class, ['names' => 'admin.roles']);
    Route::get('/roles/{id}/permissions', [RolesController::class, 'getPermissions'])->name('admin.roles.permissions');
});

Route::middleware('usuario_no_autenticado')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'postLogin'])->name('post_login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
