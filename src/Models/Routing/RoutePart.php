<?php

namespace Calen\Router\Models\Routing;

interface RoutePart
{
    public function up(RouteGroup $group = null);
}