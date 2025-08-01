<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckUserRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
   ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            //
        ]);

        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'role' => CheckUserRole::class, // Register your custom middleware here
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
