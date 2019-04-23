<?php

$router->get('/', function () use ($router) {
    return 'ok';
});

$router->group(['prefix' => 'auth'], function($router) {
    $router->post('login', 'AuthController@login');
    $router->post('register', 'AuthController@register');
});

$router->group([
    'prefix' => 'api/v1',
], function($router) {

    $router->group(['prefix' => 'tasks'], function($router) {
        $router->get('/', 'TaskController@list');
        $router->get('/{id}', 'TaskController@detail');
    });

    $router->get('/skills/years', 'SkillController@years');
    $router->get('/skills/tree', 'SkillController@tree');

    $router->group(['prefix' => 'graphs'], function($router) {
        $router->get('/', 'GraphController@list');
        $router->get('/{id}', 'GraphController@detail');
    });

    $router->group([
        'middleware' => 'auth',
    ], function($router) {

        $router->group(['prefix' => 'user'], function($router) {

            $router->get('/', 'UserController@detail');
            $router->get('/tasks', 'TaskController@userList');
            $router->get('/tasks/{id}', 'TaskController@userDetail');
            $router->post('/tasks', 'TaskController@create');
            $router->put('/tasks/{id}', 'TaskController@update');
            $router->delete('/tasks/{id}', 'TaskController@delete');

        });

    });


});
