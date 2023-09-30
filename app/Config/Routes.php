<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('v1', ['namespace' => 'App\Api\v1', 'filter' => 'tokens'], static function ($routes) {
    $routes->get('/', 'ApiSample::index');
});

// Adaptar despues
$routes->get('/access/token', static function() {
    $token = auth()->user()->generateAccessToken(service('request')->getVar('token_name'));

    return json_encode(['token' => $token->raw_token]);
});

service('auth')->routes($routes);
