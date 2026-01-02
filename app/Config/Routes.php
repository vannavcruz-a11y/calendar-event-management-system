<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// AUTH
$routes->get('/', 'AuthController::index');
$routes->get('login', 'AuthController::index');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

// CAMPUS
$routes->get('campus', 'CampusController::select');
$routes->get('campus/(:num)', 'CampusController::dashboard/$1');

// EVENT
$routes->get('campus/(:num)/events/create', 'EventController::create/$1');
$routes->post('campus/event/store', 'EventController::store');
$routes->get('event/(:num)/attendance/view', 'AttendanceController::view/$1');

$routes->get('event/edit/(:num)', 'EventController::edit/$1');
$routes->post('events/update/(:num)', 'EventController::update/$1');

$routes->post('event/delete/(:num)', 'EventController::delete/$1');



// Attendance routes
$routes->get('event/(:num)/attendance/upload', 'AttendanceController::upload/$1');  // Upload form
$routes->post('event/(:num)/attendance/store', 'AttendanceController::store/$1');   // Store CSV
$routes->get('event/(:num)/attendance/export', 'AttendanceController::export/$1');  // Export CSV
// Campus-level attendance
$routes->get('campus/(:num)/attendance/view', 'AttendanceController::campusView/$1');
$routes->get('campus/(:num)/attendance/export', 'AttendanceController::campusExport/$1');


// USG DASHBOARD
$routes->get('usg/dashboard', 'USGController::dashboard');

$routes->get('usg', 'USGController::dashboard');
$routes->get('usg/campus/(:num)', 'USGController::campusEvents/$1');
$routes->get('usg/campus/(:num)/events', 'USGController::campusEvents/$1');
$routes->get('usg/event/(:num)', 'USGController::eventSummary/$1');

$routes->get('usg/campus/(:num)', 'USGController::campusEvents/$1');
$routes->get('usg/campus/(:num)/events', 'USGController::campusEvents/$1');


$routes->get('generate_hash', 'HashController::generate');


// Campus Add Account
// Correct route syntax with backslashes for namespace
$routes->get('campus/(:num)/add-account', '\App\Controllers\CampusController::addAccount/$1');
$routes->post('campus/(:num)/add-account', '\App\Controllers\CampusController::storeAccount/$1');

$routes->get('campus/(:num)/add-account', 'CampusController::addAccount/$1');
$routes->post('campus/(:num)/store-account', 'CampusController::storeAccount/$1');


$routes->get('usg/students/(:num)', 'StudentController::index/$1');
$routes->get('usg/students/add/(:num)', 'StudentController::create/$1');
$routes->post('usg/students/store', 'StudentController::store');


$routes->post('usg/students/upload', 'StudentController::upload');

// Student login
// Student login
$routes->get('student/login', 'StudentController::login');
$routes->post('student/authenticate', 'StudentController::authenticate');


// Change password
$routes->get('student/change-password', 'StudentController::changePassword');
$routes->post('student/change-password', 'StudentController::updatePassword');


$routes->get('student/dashboard', 'StudentController::dashboard');
$routes->get('student/calendar', 'StudentController::calendar');
$routes->post('attendance/save', 'StudentController::saveAttendance');




$routes->get('student/delete/(:num)', 'StudentController::delete/$1');

$routes->get('attendance/delete/(:num)', 'AttendanceController::delete/$1');
$routes->get('student/delete/(:num)', 'StudentController::delete/$1');

// Attendance delete all for an event
$routes->get('attendance/deleteAll/(:num)', 'AttendanceController::deleteAll/$1');
$routes->get('student/deleteAll/(:num)', 'StudentController::deleteAll/$1');

$routes->post('event/(:num)/attendance/manual_store', 'AttendanceController::manualStore/$1');
$routes->get('calendar', 'CalendarController::index');
$routes->get('calendar/events', 'CalendarController::getEvents');
$routes->get('calendar', 'CalendarController::index');     // Show the calendar view
$routes->get('calendar/events', 'CalendarController::events'); // Fetch events as JSON
$routes->get('campus/(:num)/calendar', 'CalendarController::index/$1');
$routes->get('campus/(:num)/calendar/events', 'CalendarController::events/$1');
