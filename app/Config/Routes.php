<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('api', ['namespace' => 'App\API\V1'], static function ($routes) {
    $routes->get('/', 'ApiSample::index');
});

$routes->get('/', 'ApiSample::index', ['namespace' => 'App\API\V1']);
