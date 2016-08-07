<?php

namespace Calen\Router\Models;

use \stdClass;
use Ratchet\ConnectionInterface;


class Request
{
    protected $path;
    protected $args;
    protected $conn;

    public function __construct(string $path,
                                stdClass $args,
                                ConnectionInterface $conn)
    {
        $this->conn = $conn;
        $this->path = $path;
        $this->args = $args;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getArgs()
    {
        return $this->args;
    }
}