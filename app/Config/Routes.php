<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// $routes->get('/', 'Home::index');

$routes->get('/', 'ProductController::index');
// $routes->post('product/add', 'ProductController::add');
// $routes->get('product/fetch', 'ProductController::fetch');
// $routes->get('product/edit/(:num)', 'ProductController::edit/$1');
// $routes->get('product/delete/(:num)', 'ProductController::delete/$1');
// $routes->get('product/detail/(:num)', 'ProductController::detail/$1');
// $routes->post('product/update', 'ProductController::update');

$routes->group('product', function ($routes) {
    $routes->get('finalSubmit', 'ProductController::inserDataInDataBase');
    $routes->get('/', 'ProductController::index');
    $routes->post('add', 'ProductController::add');
    $routes->get('fetch', 'ProductController::fetch');
    $routes->get('edit/(:num)', 'ProductController::edit/$1');
    $routes->get('delete/(:num)', 'ProductController::delete/$1');
    $routes->get('detail/(:num)', 'ProductController::detail/$1');
    $routes->post('update', 'ProductController::update');
});
