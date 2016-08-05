<?php

namespace Calen\Router;

use \Exception;

class PathNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct("Could not find path for url routing", 500, null);
    }
}