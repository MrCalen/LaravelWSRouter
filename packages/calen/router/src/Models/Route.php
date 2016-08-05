<?php

namespace Calen\Router\Models;

class Route
{
    protected $path;
    protected $controller;

    public function __construct(string $path, string $controller)
    {
        $this->path = $path;
        $this->controller = $controller;
        var_dump($this->path);
    }
}