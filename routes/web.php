<?php

use App\Http\Controllers\AsistenciasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompensacionesController;
use App\Http\Controllers\DeduccionesController;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\DesignacionesController;
use App\Http\Controllers\DetalleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SalarioController;
use App\Http\Controllers\SueldosController;
use App\Http\Controllers\UsuariosController;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return redirect()->route('inicio');
});
Route::prefix('admin')->middleware('usuario_autenticado')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('inicio');

    Route::resource('/usuarios', UsuariosController::class, ['names' => 'admin.usuarios']);
    Route::resource('/detalle', DetalleController::class, ['names' => 'admin.detalle']);
    Route::resource('/departamentos', DepartamentosController::class, ['names' => 'admin.departamentos']);
    Route::resource('/designaciones', DesignacionesController::class, ['names' => 'admin.designaciones']);
    Route::resource('/permisos', PermisosController::class, ['names' => 'admin.permisos']);
    Route::resource('/sueldos', SueldosController::class, ['names' => 'admin.sueldos']);
    Route::resource('/compensaciones', CompensacionesController::class, ['names' => 'admin.compensaciones']);
    Route::resource('/deducciones', DeduccionesController::class, ['names' => 'admin.deducciones']);
    Route::resource('/asistencias', AsistenciasController::class, ['names' => 'admin.asistencias']);
    Route::put('/asistencias/nota/{id}', [AsistenciasController::class, 'updateNote'])->name('admin.asistencias.updateNote');

    Route::resource('/roles', RolesController::class, ['names' => 'admin.roles']);
    Route::put('/permission', [RolesController::class, 'putPermission'])->name('admin.permission.update');

    Route::resource('/perfil', PerfilController::class, ['names' => 'admin.perfil']);
    Route::resource('/salarios', SalarioController::class, ['names' => 'admin.salarios']);

    Route::get('/sueldos/pdf/{id}', [SueldosController::class, 'reciboPDF'])->name('admin.sueldos.pdf');
    Route::get('/sueldos/print/{id}', [SueldosController::class, 'reciboPrint'])->name('admin.sueldos.print');

    Route::prefix('pdf')->group(function () {
        Route::get('/usuarios', [ReportesController::class, 'usuarios'])->name('admin.pdf.usuarios');
        Route::get('/permisos', [ReportesController::class, 'permisos'])->name('admin.pdf.permisos');
        Route::get('/sueldos', [ReportesController::class, 'sueldos'])->name('admin.pdf.sueldos');
        Route::get('/asistencias/{mes?}/{anio?}/{id?}', [ReportesController::class, 'asistencias'])->name('admin.pdf.asistencias');
    });
});

Route::middleware('usuario_no_autenticado')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'postLogin'])->name('post_login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/captcha', function () {
    $chars  = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
    $length = 5;
    $phrase = '';

    for ($i = 0; $i < $length; $i++) {
        $phrase .= $chars[rand(0, strlen($chars) - 1)];
    }

    $builder = new CaptchaBuilder($phrase);
    $builder->build();

    Session::put('captcha', $builder->getPhrase());

    return response($builder->output())->header('Content-Type', 'image/jpeg');
})->name('captcha');
