<?php

namespace Calen\Router\Models\Routing;

class Route implements RoutePart
{
    protected $path;
    protected $controller;

    protected $middlewares = [];

    public function __construct(string $path, string $controller)
    {
        $this->path = $path;
        $this->controller = $controller;
    }

    public function up(RouteGroup $group = null) : array
    {
        if (($middleware = $group->getMiddleware())) {
            array_unshift($this->middlewares, $middleware);
        }

        if (($prefix = $group->getPrefix())) {
            $this->path = $prefix . '/' . ltrim($this->path, '/');
            // Add slash if it is missing
            if ($this->path[0] !== '/') {
                $this->path = '/' . $this->path;
            }
        }

        if (($namespace = $group->getNamespace())) {
            $this->controller = $namespace . '\\' . ltrim($this->controller, '\\');
        }

        return [$this];
    }

    public function getPath() : string
    {
        return $this->path;
    }

    public function getMiddlewares() : array
    {
        return $this->middlewares;
    }

    public function getController() : string
    {
        return $this->controller;
    }
}