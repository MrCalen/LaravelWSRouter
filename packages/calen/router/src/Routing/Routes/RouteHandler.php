<?php

namespace Calen\Router\Routing\Routes;

use Calen\Router\Models\RouteGroup;

class RouteHandler
{
    protected $routes = null;

    public function __construct()
    {
        $this->routes = new RouteGroup([]);
        $this->routes->group([], function (RouteGroup $routes) {
            include 'Routes.php';
        });

        $routes = $this->routes->up(null);
        var_dump($routes);

    }
}