<?php

use App\Http\Middleware\UsuarioAutenticado;
use App\Http\Middleware\UsuarioNoAutenticado;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'usuario_autenticado' => UsuarioAutenticado::class,
            'usuario_no_autenticado' => UsuarioNoAutenticado::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
