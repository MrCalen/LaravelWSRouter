<?php

namespace Calen\Router\Exception;

class ClassNotFoundException extends \Exception
{
    public function __construct($isclass = true)
    {
        $message = $isclass
                   ? "Controller class not found"
                   : "Function of Controller could not be found";
        parent::__construct($message, 500, null);
    }
}