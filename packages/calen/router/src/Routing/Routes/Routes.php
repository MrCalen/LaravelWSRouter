<?php

use Calen\Router\Models\Routing\RouteGroup;

$routes->group(['namespace' => 'App\Http\Controllers'], function (RouteGroup $routes) {
    $routes->route('/test', 'HomeController@index');
    $routes->group(['prefix' => '/A', 'namespace' => 'App\Calen'], function (RouteGroup $group) {
        $group->group(['prefix' => '/B'], function (RouteGroup $group) {
            $group->route('/testAB', 'zde');
            $group->group(['prefix' => '/C'], function (RouteGroup $group) {
                $group->route('/test', 'aze');
            });
        });
        $group->route('/testA', 'azef');
    });
});