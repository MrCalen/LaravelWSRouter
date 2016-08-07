<?php

namespace Calen\Router\Server;

use Calen\Router\Router;
use Ratchet\MessageComponentInterface;
use Calen\Router\Models\ServerWatcher;
use Ratchet\ConnectionInterface;

class Server implements MessageComponentInterface
{

    protected $watcher = null;
    protected $router = null;

    public function __construct(ServerWatcher $watcher = null)
    {
        $this->watcher = $watcher;
        if ($this->watcher) {
            $this->watcher->setServer($this);
        }

        $this->router = new Router();

        // FIXME: put this in the config file
        $this->router
            ->getMiddlewareHandler()
            ->registerMiddleware("test",\App\Http\Middleware\TestMiddleware::class);
    }


    function onOpen(ConnectionInterface $conn)
    {
        if ($this->watcher) {
            $this->watcher->onOpen($conn);
        }
    }

    function onClose(ConnectionInterface $conn)
    {
        if ($this->watcher) {
            $this->watcher->onClose($conn);
        }
    }


    function onError(ConnectionInterface $conn, \Exception $e)
    {
        if ($this->watcher) {
            $this->watcher->onError($conn, $e);
        }
    }

    function onMessage(ConnectionInterface $from, $msg)
    {
        if ($this->watcher) {
            $this->watcher->onMessage($from, $msg);
        }

        $this->router->onMessage($from, $msg);
    }

    public function getRouter()
    {
        return $this->router;
    }
}