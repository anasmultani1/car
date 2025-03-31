<?php

namespace Config;

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// Car-related Routes
$routes->get('/carlist', 'CarController::index');
$routes->post('/save-car-and-redirect', 'CarController::saveCarAndRedirect');

// User Authentication Routes
$routes->get('/register', 'UserController::register');
$routes->post('/store', 'UserController::store');
$routes->get('/login', 'UserController::login');
$routes->post('/authenticate', 'UserController::authenticate');
$routes->get('/logout', 'UserController::logout');
$routes->get('/dashboard', 'DashboardController::index');
$routes->get('/delete-car/(:num)', 'DashboardController::deleteCar/$1');
$routes->get('/delete-review/(:num)', 'DashboardController::deleteReview/$1');
$routes->get('/edit-car/(:num)', 'DashboardController::editCar/$1');
$routes->post('/update-car/(:num)', 'DashboardController::updateCar/$1');
$routes->get('/edit-review/(:num)', 'DashboardController::editReview/$1');
$routes->post('/update-review/(:num)', 'DashboardController::updateReview/$1');
$routes->get('/car/(:num)', 'CarController::view/$1');
$routes->get('/car/(:num)', 'CarController::viewCar/$1');