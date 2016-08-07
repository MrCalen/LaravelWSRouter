<?php

namespace Calen\Router\Exception;

class RouteBadFormatedException extends \Exception
{
    public function __construct($got)
    {
        parent::__construct("Route format must respect (.+)@(.+) format"
            . ". Got : ${got}", 500, null);
    }
}