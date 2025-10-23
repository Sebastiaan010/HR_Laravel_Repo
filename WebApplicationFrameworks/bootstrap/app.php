<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// voeg deze 2 use-statements toe:
use App\Providers\AppServiceProvider;
use App\Providers\AuthServiceProvider;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    // registreer je providers hier:
    ->withProviders([
        AppServiceProvider::class,
        AuthServiceProvider::class,
    ])
    ->create();
