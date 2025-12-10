<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

    $middleware->group('web', [

        // COOKIE + SESSION
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,

        // *** INI YANG PALING PENTING ***
        // Agar database session dapat menyimpan user_id login
        \Illuminate\Session\Middleware\AuthenticateSession::class,

        // ERRORS + BINDING ROUTE
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ]);

    // middleware ALIAS (pisahkan dari group)
    $middleware->alias([
        'auth'  => \App\Http\Middleware\Authenticate::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'role'  => \App\Http\Middleware\RoleAccess::class,

        'admin'     => \App\Http\Middleware\IsAdmin::class,
        'user'      => \App\Http\Middleware\User::class,
        'auditor'   => \App\Http\Middleware\Auditor::class,
    ]);
})
    ->withExceptions(function ($exceptions) {})
    ->create();
