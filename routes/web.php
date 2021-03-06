<?php

use Laravel\Lumen\Routing\Router;

/** @var Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// example.com/api
$router->group([
    'prefix' => '/api'
], function () use ($router) {

    // example.com/api/log
    $router->group([
        'prefix' => '/log'
    ], function () use ($router) {
        $router->post('/create', 'LogController@create');

        $router->post('/import', 'ImportFileController@import');
    });
});


$router->get('/request/per/consumer', 'ReportController@requestPerConsumer');
$router->get('/request/per/service', 'ReportController@requestPerService');
$router->get('/latency/per/service', 'ReportController@averageLatencyPerService');
