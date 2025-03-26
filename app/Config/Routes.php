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
$routes->get('/register', 'UserController::register');         // Display Registration Page
$routes->post('/store', 'UserController::store');               // Store New User
$routes->get('/login', 'UserController::login');                // Display Login Page
$routes->post('/authenticate', 'UserController::authenticate'); // Authenticate User
$routes->get('/logout', 'UserController::logout');              // User Logout

// Dashboard Routes (Admin & User Dashboard)
$routes->get('/dashboard', 'DashboardController::index');

// Car Edit & Delete Routes
$routes->get('/edit-car/(:num)', 'DashboardController::editCar/$1');
$routes->post('/update-car/(:num)', 'DashboardController::updateCar/$1');
$routes->get('/delete-car/(:num)', 'DashboardController::deleteCar/$1');

// Review Edit & Delete Routes
$routes->get('/edit-review/(:num)', 'DashboardController::editReview/$1');
$routes->post('/update-review/(:num)', 'DashboardController::updateReview/$1');
$routes->get('/delete-review/(:num)', 'DashboardController::deleteReview/$1');

// Database Test Route (if you still need it)
$routes->get('/dbtest', 'DatabaseTest::index');
