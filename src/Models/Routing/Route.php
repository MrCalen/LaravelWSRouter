<?php

namespace Calen\Router\Models\Routing;

use Calen\Router\Exception\RouteBadFormatedException;

class Route implements RoutePart
{
    protected $path;
    protected $controller;
    protected $controllerFct;

    protected $middlewares = [];

    public function __construct(string $path, string $controller)
    {
        $this->path = $path;
        $parts = explode('@', $controller);
        if (count($parts) != 2) {
            throw new RouteBadFormatedException($controller);
        }

        $this->controller = $parts[0];
        $this->controllerFct = $parts[1];
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

    public function getControllerFct()
    {
        return $this->controllerFct;
    }
}