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

    private function next(Request $request, $middlewares, $i)
    {
        if ($i >= count($middlewares)) {
            // FIXME: Handle request controller and function
        }

        $middlewareName = $middlewares[$i];

        // If specified middleware has not been registered
        // Just skip it
        if (!isset($this->middlewares[$middlewareName])) {
            $this->next($request, $middlewares, ++$i);
            return;
        }

        $middlewareClass = $this->middlewares[$middlewareName];
        $middleware = new $middlewareClass();
        $middleware->handle($request, function () use ($request, $middlewares, $i) {
            $this->next($request, $middlewares, ++$i);
        });
    }

    public function handle(Request $request, Route $route)
    {
        $middlewares = $route->getMiddlewares();
        $this->next($request, $middlewares, 0);
    }
}