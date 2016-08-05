<?php

namespace Calen\Router\Models;

use Closure;

class RouteGroup
{
    protected $prefix;
    protected $middleware;

    protected $routes = [];
    protected $groups = [];

    public function __construct(array $params)
    {
        array_map(
            function ($k) use ($params) {
                $this->{ $k } = $params[$k];
            },
            array_keys($params)
        );
    }

    public function route(string $path, $controller)
    {
        $route = new Route($path, $controller);
        $this->routes[] = $route;
    }

    public function group(array $params, Closure $closure)
    {
        $group = new RouteGroup($params);
        $this->groups[] = $group;
        $closure->call($this, $group);
    }

}