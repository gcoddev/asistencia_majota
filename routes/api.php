<?php

use App\Http\Controllers\API\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return response()->json([
        'success' => true,
        'message' => 'API running successfully!',
        'data'    => [],
        'errors'  => [],
    ], 200);
});

Route::prefix('usuario')->group(function () {
    Route::get('/{ci}', [UsuarioController::class, 'index']);
    Route::get('/{ci}/asistencias/{mes?}/{anio?}', [UsuarioController::class, 'asistencia']);
});
