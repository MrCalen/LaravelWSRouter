<?php

namespace Calen\Router;

use Calen\Router\Routing\Routes\RouteHandler;
use Ratchet\ConnectionInterface;

class Router
{
    protected $routeHandler;

    public function __construct()
    {
        $this->routeHandler = new RouteHandler();
        
    }

    public function onMessage(ConnectionInterface $conn, string $message)
    {
        $message = json_decode($message);
        if (!$message) {
            throw new JsonDecodeException();
        }
    }
}