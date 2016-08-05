<?php

namespace Calen\Router\Models;

interface RoutePart
{
    public function up(RouteGroup $group = null);
}