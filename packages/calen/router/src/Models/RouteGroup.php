<?php

namespace Calen\Router\Models;

use Closure;

class RouteGroup implements RoutePart
{
    protected $prefix;
    protected $middleware;

    protected $parts = [];

    protected $upRoutes = [];

    protected $parent;

    public function __construct(array $params, self $parent = null)
    {
        $this->fillArgs('prefix', $params);
        $this->fillArgs('middleware', $params);
        $this->parent = $parent;
    }

    private function fillArgs(string $attr, array $args)
    {
        if (isset($args[$attr])) {
            $this->{$attr} = $args[$attr];
        }
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

    public function up(RouteGroup $_ = null)
    {
        foreach ($this->parts as $part) {
            $newroutes = $part->up($this);

            // Is child is a group, up'ed routes
            // have to be up'ed again to get the new prefix and middleware
            if (is_a($part, RouteGroup::class)) {
                array_map(function ($route) { $route->up($this); }, $newroutes);
            }

            $this->upRoutes = array_merge($this->upRoutes, $newroutes);
        }

        return $this->upRoutes;
    }
}