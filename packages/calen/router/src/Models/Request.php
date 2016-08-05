<?php

namespace Calen\Router\Models;

use \stdClass;

class Request
{
    protected $path;
    protected $args;

    public function __construct(string $path, stdClass $args)
    {
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