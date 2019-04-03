<?php
use App\User;

$router->get('/', function () use ($router) {
    return User::get();
});

$router->get('/version', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'auth'], function($router) {
    $router->post('login', 'AuthController@login');
    $router->post('register', 'AuthController@register');
});

$router->get('/auth', ['middleware' => 'auth', function () use ($router) {
    return 'auth ok?';
}]);


