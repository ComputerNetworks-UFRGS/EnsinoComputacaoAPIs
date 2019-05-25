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

    // Public

    $router->group(['prefix' => 'tasks'], function($router) {
        $router->get('/', 'TaskController@list');
        $router->get('/{id}', 'TaskController@detail');
    });

    $router->group(['prefix' => 'skills'], function($router) {
        $router->get('/years', 'SkillController@years');
        $router->get('/tree', 'SkillController@tree');
    });

    $router->group(['prefix' => 'graphs'], function($router) {
        $router->get('/', 'GraphController@list');
        $router->get('/{id}', 'GraphController@detail');
        $router->put('/{id}', 'GraphController@update');
    });

    // Private

    $router->group(['middleware' => 'auth'], function($router) {

        $router->group(['prefix' => 'user'], function($router) {

            $router->get('/', 'UserController@detail');

            $router->get('/tasks', 'UserTaskController@list');
            $router->get('/tasks/{id}', 'UserTaskController@detail');
            $router->post('/tasks', 'UserTaskController@create');
            $router->put('/tasks/{id}', 'UserTaskController@update');
            $router->delete('/tasks/{id}', 'UserTaskController@delete');

        });

        $router->group(['prefix' => 'roles'], function($router) {
            $router->get('', 'RoleController@list');
            $router->get('/{id}', 'RoleController@detail');
            $router->post('', 'RoleController@create');
            $router->put('/{id}', 'RoleController@update');
            $router->delete('/{id}', 'RoleController@delete');
        });

        $router->get('/permissions', 'PermissionController@list');

        $router->group(['prefix' => 'users'], function($router) {
            $router->get('', 'UsersController@list');
            $router->put('/{id}', 'UsersController@update');
        });

    });

});
