<?php

return [
    'middlewares' => [
        // 'test' => App\WS\AuthMiddleware::class,
    ],
    'routes' => function ($routes) {
        $routes->group(['namespace' => 'App\Http\Controllers'], function ($routes) {
            $routes->route('/', 'HomeController@index');
        });
    },
];