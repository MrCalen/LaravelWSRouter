<?php

use Calen\Router\Models\RouteGroup;

$routes->route('/test', 'HomeController@index');
$routes->group(['prefix' => '/A'], function (RouteGroup $group) {
    $group->group(['prefix' => '/B'], function (RouteGroup $group) {
        $group->route('/testAB', 'zde');
        $group->group(['prefix' => '/C'], function (RouteGroup $group) {
           $group->route('/test', 'aze');
        });
    });
    $group->route('/testA', 'azef');
});