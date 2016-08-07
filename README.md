Laravel WS Router
====

The Router provides a good way to do kind or URL routing for websockets.
The library depends on cboden/ratchet which is the WebSocket server used but feel free
to write the same for other WebSocket servers.

The library works based on the fields `path` given in the JSON message. All the configuration
is done via the router.php file published.

The library handles Middlewares, Prefixes namespaces in grouping similarly to Laravel 5 URL routing.

Installation
---

Require Calen/router in your L5 project.
I used PHP7 to write it, so it has a dependency on it.

``` composer require calen/router:dev-master```

Then add the Service Provider in the providers in L5 *config/app.php*:
```
 'providers' => [
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\RouteServiceProvider::class,

    // ...

    Calen\Router\RatchetRouterServiceProvider::class,

 ],
 ```

 Once the ServiceProvider is added, you can publish the configuration file by running artisan:

 ``` php artisan vendor:publish ```

 This will add the config file *router.php* in the config repository.


Configuration
---

You will need to configure the library for it to run correctly. The config file publishes as this:

```
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

```

### Middlewares

The middlewares look the same as the L5's ones.
If you want to provide a middleware on some routes on can add the `middleware` key to the array
given in `group` function.

The middleware must implement the Calen\Router\Routing\Middleware\Middleware interface.

For example:
```
$routes->group(
    [
        'namespace' => 'App\Http\Controllers',
        'middleware' => 'dummy',
        'prefix' => 'CalenApp',
    ], function ($routes) {
        // My routes
    });
```

We add the middleware *dummy* to all the routes given in the closure.

As L5, the middleware are registered in the *config/router.php* file, as a name to the class
 corresponding like this:

 ```
 return [
     'middlewares' => [
         'dummy' => App\WS\Dummyddleware::class,
     ],
     'routes' => function ($routes) {
         $routes->group(['namespace' => 'App\Http\Controllers'], function ($routes) {
             $routes->route('/', 'HomeController@index');
         });
     },
 ];
  ```

####Note:
*If the middleware is not registered, it will not be handled*


### Packagist

My packagist repo is here: [https://packagist.org/packages/calen/router](https://packagist.org/packages/calen/router)