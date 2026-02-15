<?php
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/auth/processLogin', 'Auth::processLogin');
$routes->get('/logout', 'Auth::logout');
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

$routes->get('/activity', 'Activity::index', ['filter' => 'auth']);
$routes->get('/activity/create', 'Activity::create', ['filter' => 'auth']);
$routes->post('/activity/store', 'Activity::store', ['filter' => 'auth']);
$routes->get('/activity/edit/(:num)', 'Activity::edit/$1', ['filter' => 'auth']);
$routes->post('/activity/update/(:num)', 'Activity::update/$1', ['filter' => 'auth']);

$routes->get('/monitoring', 'Monitoring::index', ['filter' => 'auth']);

$routes->get('/validation', 'Validation::index', ['filter' => 'auth']);
$routes->post('/validation/update', 'Validation::updateStatus', ['filter' => 'auth']);

$routes->get('/grades', 'Grades::index', ['filter' => 'auth']);
$routes->get('/grades/export', 'Grades::export', ['filter' => 'auth']);

// User Management Routes
$routes->group('users', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Users::index');
    $routes->get('create', 'Users::create');
    $routes->post('store', 'Users::store');
    $routes->get('edit/(:num)', 'Users::edit/$1');
    $routes->post('update/(:num)', 'Users::update/$1');
    $routes->get('delete/(:num)', 'Users::delete/$1');
    $routes->get('reset-password/(:num)', 'Users::resetPassword/$1');
    $routes->get('import', 'Users::import');
    $routes->post('process-import', 'Users::processImport');
});

// Class Management Routes
$routes->group('classes', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Classes::index');
    $routes->get('create', 'Classes::create');
    $routes->post('store', 'Classes::store');
    $routes->get('edit/(:num)', 'Classes::edit/$1');
    $routes->post('update/(:num)', 'Classes::update/$1');
    $routes->get('delete/(:num)', 'Classes::delete/$1');
});

// Institution Profile Routes
$routes->group('institution', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'InstitutionController::index');
    $routes->post('update', 'InstitutionController::update');
});

// User Profile Routes
$routes->group('profile', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'ProfileController::index');
    $routes->post('update', 'ProfileController::update');
});
