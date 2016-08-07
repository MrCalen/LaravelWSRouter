<?php

namespace Calen\Router;

use Calen\Router\Models\Request;
use Calen\Router\Routing\Middleware\MiddlewareHandler;
use Calen\Router\Routing\Routes\RouteDispatcher;
use Calen\Router\Routing\Routes\RouteHandler;
use Ratchet\ConnectionInterface;

use Calen\Router\Exception\JsonDecodeException;
use Calen\Router\Exception\PathNotFoundException;
use Calen\Router\Exception\NoRoutesFoundException;

class Router
{
    protected $routeHandler;
    protected $routeDispatcher;
    protected $middlewareHandler;

    public function __construct()
    {
        $this->routeHandler = new RouteHandler();
        $routes = $this->routeHandler->getRoutes();
        if (empty($routes)) {
            throw new NoRoutesFoundException();
        }
        $this->routeDispatcher = new RouteDispatcher($routes);
        $this->middlewareHandler = new MiddlewareHandler();
        $this->registerMiddlewares();
    }

    private function registerMiddlewares()
    {
        $middlewares = config('router.middlewares');
        foreach ($middlewares as $name => $class) {
            $this->middlewareHandler->registerMiddleware($name, $class);
        }
    }

    public function onMessage(ConnectionInterface $conn, string $message)
    {
        $message = json_decode($message);

        // Protocol used must be json
        if (!$message) {
            throw new JsonDecodeException();
        }

        if (!isset($message->path)) {
            throw new PathNotFoundException();
        }

        $path = $message->path;

        $request = new Request($path, $message, $conn);
        $route = $this->routeDispatcher->dispatch($request);
        $this->middlewareHandler->handle($request, $route);
    }

    public function getMiddlewareHandler()
    {
        return $this->middlewareHandler;
    }

}