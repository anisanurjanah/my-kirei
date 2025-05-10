<?php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\TrimStrings;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\TrustProxies;
use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckOutletCode;
use App\Http\Middleware\AuthenticateCustomer;
use App\Http\Middleware\DynamicSessionConfig;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\StartSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(TrimStrings::class);
        $middleware->append(TrustProxies::class);
        $middleware->web(append: [
            StartSession::class,
            HandleInertiaRequests::class,
            DynamicSessionConfig::class,
            VerifyCsrfToken::class,
        ]);
        $middleware->alias([
            'auth' => Authenticate::class,
            'auth.customer' => AuthenticateCustomer::class,
            'guest' => RedirectIfAuthenticated::class,
            'role' => CheckRole::class,
            'check.outlet.code' => CheckOutletCode::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
