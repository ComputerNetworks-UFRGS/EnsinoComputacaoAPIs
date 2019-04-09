<?php
use App\Models\TopicType;

$router->get('/', function () use ($router) {
    return 'ok';
});

$router->get('/version', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'auth'], function($router) {
    $router->post('login', 'AuthController@login');
    $router->post('register', 'AuthController@register');
});

$router->group([
    'prefix' => 'api/v1',
    'middleware' => 'auth'
], function($router) {

    $router->group(['prefix' => 'task'], function($router) {

        $router->get('/', 'TaskController@list');

    });

    $router->group(['prefix' => 'topic'], function($router) {

        $router->get('/', 'TopicController@list');

    });

});
