<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Home::index');
$routes->post('/insert', 'Home::insert');

// ROUTING LOGIN SYSTEM ADMIN
// route login & logout
$routes->get('/Admin/Login', 'Auth::index', ['filter'=>'LogedIn']);
$routes->post('/Admin/Check', 'Auth::login');
$routes->get('/Admin/Logout', 'Auth::logout', ['filter'=>'Login']);
// forgotPassword route
$routes->get('/Admin/forgotPassword', 'Auth::forgotPasswordForm');
$routes->post('/Admin/resetCheck', 'Auth::resetCheck');


$routes->get('/Admin', 'Admin\Admin::index', ['filter'=>'Login']);

// ROUTING CRUD DATA ADMIN
// route get all admin data
$routes->get('/Admin/Admin', 'Admin\Admin::admin', ['filter'=>'CEO']);
// route form & insert admin data
$routes->get('/Admin/Admin/formInsert', 'Admin\Admin::formInsert', ['filter'=>'CEO']);
$routes->post('/Admin/Admin/Insert', 'Admin\Admin::insert', ['filter'=>'CEO']);
// route form & update admin data
$routes->get('/Admin/Admin/formEdit/(:num)', 'Admin\Admin::formUpdate/$1', ['filter'=>'CEO']);
$routes->post('/Admin/Admin/Update/(:num)', 'Admin\Admin::update/$1', ['filter'=>'CEO']);
// route delete single user data 
$routes->delete('/Admin/Admin/(:num)', 'Admin\Admin::delete/$1', ['filter'=>'CEO']);

// ROUTING CRUD DATA USER
// route get all user data 
$routes->get('/Admin/User', 'Admin\User::user', ['filter'=>'Login']);
// route delete single user data 
$routes->delete('/Admin/User/(:num)', 'Admin\User::delete/$1', ['filter'=>'HRCEO']);
// route form & insert user data 
$routes->get('/Admin/User/formInsert', 'Admin\User::formInsert', ['filter'=>'HRCEO']);
$routes->post('/Admin/User/insertData', 'Admin\User::insert', ['filter'=>'HRCEO']);
// route form & update user data 
$routes->get('/Admin/User/formEdit/(:segment)', 'Admin\User::formEdit/$1', ['filter'=>'HRCEO']);
$routes->post('/Admin/User/updateData/(:num)', 'Admin\User::update/$1', ['filter'=>'HRCEO']);
// route get single user 
$routes->get('/Admin/User/(:num)', 'Admin\User::detail/$1', ['filter'=>'Login']);

// ROUTING ABSEN
// route get all absen data 
$routes->get('/Admin/Absensi', 'Admin\Absen::absen', ['filter'=>'Login']);
// route get insert & form absen 
$routes->get('/Admin/Absensi/formInsert', 'Admin\Absen::formInsert', ['filter'=>'Login']);
$routes->post('/Admin/Absensi/insert', 'Admin\Absen::insert', ['filter'=>'Login']);
// routes get detail absen data
$routes->get('/Admin/Absensi/(:num)', 'Admin\Absen::detail/$1', ['filter'=>'Login']);


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
