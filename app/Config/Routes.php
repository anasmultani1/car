<?php

namespace Config;

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// Home Route
$routes->get('/', 'Home::index');

// Car-related Routes
$routes->get('/carlist', 'CarController::index');            // Display all cars
$routes->get('/add-car', 'CarController::create');            // Form to add a new car
$routes->post('/save-car', 'CarController::save');            // Save new car data

// Review-related Routes
$routes->post('/save-review', 'ReviewController::save');      // Save a review for a car


// User Authentication Routes
$routes->get('/register', 'UserController::register');
$routes->post('/store', 'UserController::store');
$routes->get('/login', 'UserController::login');
$routes->post('/authenticate', 'UserController::authenticate');
$routes->get('/logout', 'UserController::logout');