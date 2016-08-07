<?php

namespace Calen\Router\Routing\Middleware;

use Calen\Router\Models\Request;

interface Middleware
{
    public function handle(Request $request, \Closure $next);
}