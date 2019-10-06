<?php

$router->get('/', function () use ($router) {
    return 'ok';
});


$router->group([
    'prefix' => 'api/v1',
], function($router) {

    // Public
    $router->group(['prefix' => 'auth'], function($router) {
        $router->post('login', 'AuthController@login');
        $router->post('register', 'AuthController@register');
    });

    $router->group(['prefix' => 'tasks'], function($router) {
        $router->get('/', 'TaskController@list');
        $router->get('/{id}', 'TaskController@detail');
    });

    $router->group(['prefix' => 'skills'], function($router) {

        $router->get('/years', 'SkillController@years');
        $router->get('/tree', 'SkillController@tree');

        $router->group(['middleware' => 'auth'], function($router) {
            $router->get('/', 'SkillController@list');
            $router->get('/{id}', 'SkillController@detail');
            $router->post('/', 'SkillController@create');
            $router->put('/{id}', 'SkillController@update');
            $router->delete('/{id}', 'SkillController@delete');
        });

    });

    $router->group(['prefix' => 'graphs'], function($router) {
        $router->get('/', 'GraphController@list');
        $router->get('/{id}', 'GraphController@detail');
    });

    $router->get('/age-groups', 'AgeGroupController@list');
    $router->get('/learning-stages', 'LearningStageController@list');
    $router->get('/axis', 'AxisController@list');

    // Private
    $router->group(['middleware' => 'auth'], function($router) {

        $router->group(['prefix' => 'user'], function($router) {

            $router->get('/', 'UserController@detail');

            $router->get('/tasks', 'UserTaskController@list');
            $router->get('/tasks/{id}', 'UserTaskController@detail');
            $router->post('/tasks', 'UserTaskController@create');
            $router->put('/tasks/{id}', 'UserTaskController@update');
            $router->delete('/tasks/{id}', 'UserTaskController@delete');
            $router->get('/tasks/{id}/publish', 'UserTaskController@publish');
            $router->get('/tasks/{id}/attachment', 'TaskAttachmentController@list');
            $router->post('/tasks/{id}/attachment', 'TaskAttachmentController@create');
            $router->delete('/tasks/{id}/attachment/{attachment_id}', 'TaskAttachmentController@delete');

        });

        $router->group(['prefix' => 'roles'], function($router) {
            $router->get('/', 'RoleController@list');
            $router->get('/{id}', 'RoleController@detail');
            $router->post('/', 'RoleController@create');
            $router->put('/{id}', 'RoleController@update');
            $router->delete('/{id}', 'RoleController@delete');
        });

        $router->get('/permissions', 'PermissionController@list');

        $router->group(['prefix' => 'users'], function($router) {
            $router->get('', 'UsersController@list');
            $router->put('/{id}', 'UsersController@update');
        });

        $router->group(['prefix' => 'reviews'], function($router) {
            $router->get('/', 'ReviewTaskController@list');
            $router->get('/{id}', 'ReviewTaskController@detail');
            $router->post('/{id}/set-status', 'ReviewTaskController@setStatus');
            $router->post('/{id}/comment', 'ReviewTaskController@create');
        });

        $router->group(['prefix' => 'object'], function($router) {
            $router->get('/', 'ObjectController@list');
            $router->get('/tree', 'ObjectController@tree');
            $router->get('/{id}', 'ObjectController@detail');
            $router->post('/', 'ObjectController@create');
            $router->put('/{id}', 'ObjectController@update');
            $router->delete('/{id}', 'ObjectController@delete');
        });

        $router->group(['prefix' => 'graphs'], function($router) {
            $router->post('/', 'GraphController@create');
            $router->put('/{id}', 'GraphController@update');
            $router->delete('/{id}', 'GraphController@delete');
            $router->post('/{id}/node', 'GraphController@createNode');
            $router->delete('/{id}/node/{node_id}', 'GraphController@deleteNode');
            $router->post('/{id}/edge', 'GraphController@addEdge');
            $router->delete('/{id}/edge/{from_id}/{to_id}', 'GraphController@deleteEdge');
            $router->put('/{id}/nodes', 'GraphController@updatePositions');
        });

    });

});
