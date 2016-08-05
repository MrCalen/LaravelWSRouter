<?php

namespace Calen\Router\Models;

class Route
{
    protected $path;
    protected $controller;

    protected $middlewares = [];

    public function __construct(string $path, string $controller)
    {
        $this->path = $path;
        $this->controller = $controller;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function up(RouteGroup $group)
    {
        if (($middleware = $group->getMiddleware())) {
            array_unshift($this->middlewares, $middleware);
        }

        if (($prefix = $group->getPrefix())) {
            $this->path = $prefix . $this->path;
        }

        return [$this];
    }
}