<?php

namespace App\Http;

use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // Глобальные middleware
    ];

    protected $middlewareGroups = [
        // Группы middleware
    ];

    protected $routeMiddleware = [
        'admin' => AdminMiddleware::class,
        // другие middleware...
    ];
}
