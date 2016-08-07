<?php

namespace Calen\Router\Models;

use Calen\Router\Server\Server;
use Ratchet\MessageComponentInterface;

abstract class ServerWatcher implements MessageComponentInterface
{
    protected $server = null;

    public function getServer() : Server
    {
        return $this->server;
    }

    public function setServer(Server $server)
    {
        $this->server = $server;
    }
}