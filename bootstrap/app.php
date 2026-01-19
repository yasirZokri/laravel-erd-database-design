<?php

use App\Http\Middleware\AdminAuthenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // هنا نسجل الميدلوير باسم alias
        $middleware->alias([
            'auth.admin' => AdminAuthenticate::class, // هذا الاسم نستخدمه في أي Route
        ]);

        // إذا أحببت، يمكن تسجيل ميدلوير عام لكل الطلبات
        $middleware->prepend([
            // Middleware::class, // مثال: Global middleware يمكن وضعه هنا

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // يمكنك تخصيص إدارة الاستثناءات هنا
    })
    ->create();
