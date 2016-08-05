<?php

namespace Calen\Router\Models;

use Closure;

class RouteGroup
{
    protected $prefix;
    protected $middleware;


    protected $parts = [];

    protected $upRoutes = [];

    protected $parent;

    public function __construct(array $params, self $parent = null)
    {
        array_map(
            function ($k) use ($params) {
                $this->{$k} = $params[$k];
            },
            array_keys($params)
        );
        $this->parent = $parent;
    }

    public function route(string $path, $controller)
    {
        $route = new Route($path, $controller);
        $this->parts[] = $route;
    }

    public function group(array $params, Closure $closure)
    {
        $group = new RouteGroup($params, $this);
        $this->parts[] = $group;
        $closure->call($group, $group);
    }

    public function getMiddleware()
    {
        return $this->middleware;
    }

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function up($_)
    {
        foreach ($this->parts as $part) {
            $newroutes = $part->up($this);

            if (is_a($part, RouteGroup::class)) {
                array_map(
                    function ($route) {
                        $route->up($this);
                    }, $newroutes
                );
            }

            $this->upRoutes = array_merge($this->upRoutes, $newroutes);
        }

        return $this->upRoutes;
    }
}