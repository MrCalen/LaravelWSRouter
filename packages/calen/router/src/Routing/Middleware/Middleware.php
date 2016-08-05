<?php

namespace Calen\Router\Routing\Middleware;

use Calen\Router\Models\Request;

abstract class Middleware
{
    public abstract function handle(Request $request, \Closure $next);
}