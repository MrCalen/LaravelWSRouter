<?php

namespace Calen\Router;

use Exception;

class JsonDecodeException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Could not decode json message", 500, null);
    }

}