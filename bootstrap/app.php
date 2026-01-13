<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 1. Mendaftarkan Alias Middleware 'role'
        // Ini agar Laravel mengenali Route::middleware(['role:admin'])
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // 2. Konfigurasi CSRF (Opsional)
        // Sebaiknya jangan kecualikan 'login' kecuali Anda punya alasan teknis yang kuat.
        // Jika ingin tetap mengecualikan, gunakan format array di bawah ini:
        $middleware->validateCsrfTokens(except: [
            // 'login', 
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();