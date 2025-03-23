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
$routes->get('/register', 'UserController::register');         // Display registration form
$routes->post('/store', 'UserController::store');               // Save new user registration
$routes->get('/login', 'UserController::login');                // Display login form
$routes->post('/authenticate', 'UserController::authenticate'); // User login process
$routes->get('/logout', 'UserController::logout');              // User logout
$routes->get('/dbtest', 'DatabaseTest::index');

