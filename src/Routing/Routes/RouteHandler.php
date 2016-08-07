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
            include 'Routes.php';
        });

        $this->routes = $this->routes->up(null);
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}