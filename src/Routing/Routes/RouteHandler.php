<?php

namespace Calen\Router\Routing\Routes;

use Calen\Router\Models\Routing\RouteGroup;

class RouteHandler
{
    protected $routes = null;

    public function __construct()
    {
        $this->routes = new RouteGroup([]);
        $this->routes->group([], function (RouteGroup $routes) {
            $closure = config('router.routes');
            $closure->call($this, $routes);
        });

        $this->routes = $this->routes->up(null);
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}