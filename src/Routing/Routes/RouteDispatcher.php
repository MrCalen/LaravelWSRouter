<?php

namespace Calen\Router\Routing\Routes;

use Calen\Router\Exception\PathNotFoundException;
use Calen\Router\Models\Request;
use Calen\Router\Models\Routing\Route;

class RouteDispatcher
{
    protected $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function dispatch(Request $request) : Route
    {
        $path = $request->getPath();

        $routes = array_filter($this->routes, function (Route $route) use ($path) {
            return $path === $route->getPath();
        });

        $routes = array_values($routes);

        if (!count($routes)) {
            throw new PathNotFoundException();
        }

        return $routes[0];
    }
}