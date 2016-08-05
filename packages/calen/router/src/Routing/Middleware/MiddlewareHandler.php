<?php

namespace Calen\Router\Routing\Middleware;

use Calen\Router\Models\Request;
use Calen\Router\Models\Routing\Route;

class MiddlewareHandler
{
    protected $middlewares = [];

    public function registerMiddleware(string $name, string $middlewareClass)
    {
        $this->middlewares[$name] = $middlewareClass;
    }

    public function handle(Request $request, Route $route)
    {
        dd($request);
    }
}