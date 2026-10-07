<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
//use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        $middleware->web(append: [
            \App\Http\Middleware\UserActivity::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'api/midtrans/notification',
            'user-banks',
            'seller-withdraw',
            'user-withdrawals'
        ]);

        //$middleware->api(prepend: [
       // EnsureFrontendRequestsAreStateful::class,]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e, \Illuminate\Http\Request $request) {
            if (!$request->expectsJson()) {
                return back()->with('error', 'Terlalu banyak permintaan pengiriman email. Mohon tunggu 1 menit sebelum mencoba lagi.');
            }
        });
    })->create();

if (isset($_ENV['VERCEL']) || getenv('VERCEL') || isset($_SERVER['VERCEL'])) {
    $app->useStoragePath('/tmp/storage');
}

return $app;
