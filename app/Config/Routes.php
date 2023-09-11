<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('api', ['namespace' => 'App\API'], static function ($routes) {
    $routes->group('v1', ['namespace' => 'App\API\V1'], static function ($routes) {
        $routes->get('/', 'ApiSample::index');
    });
});

$routes->get('/', 'ApiSample::index', ['namespace' => 'App\API\V1']);

$routes->get('api/v1/protected', 'ApiSample::protected', [
    'filter' => 'tokens',
    'namespace' => 'App\API\V1'
]);
