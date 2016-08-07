<?php

namespace Calen\Router\Routing\Middleware;

use Calen\Router\Exception\ClassNotFoundException;
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
        if ($i >= count($middlewares) - 1) {
            return;
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
        $middleware->handle(
            $request,
            function () use ($request, $middlewares, $i) {
                $this->next($request, $middlewares, $i + 1);
            }
        );
    }

    public function handle(Request $request, Route $route)
    {
        $middlewares = $route->getMiddlewares();
        $this->next($request, $middlewares, 0);
        // All middleware are passed

        $controller = $route->getController();
        $function = $route->getControllerFct();

        if (!class_exists($controller)) {
            throw new ClassNotFoundException();
        }
        $controller = new $controller();

        if (!method_exists($controller, $function)) {
            throw new ClassNotFoundException(false);
        }

        $controller->$function($request);

    }
}