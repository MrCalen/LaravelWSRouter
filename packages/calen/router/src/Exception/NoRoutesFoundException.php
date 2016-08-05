<?php

namespace Calen\Router\Exception;

use \Exception;

class NoRoutesFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct("No routes found", 500, null);
    }
}