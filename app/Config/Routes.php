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
$routes->setAutoRoute(true);
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
$routes->get('/Admin/Login', 'Auth::index');
$routes->post('/Admin/Check', 'Auth::login');
$routes->get('/Admin/Logout', 'Auth::logout');
// forgotPassword route
$routes->get('/Admin/forgotPassword', 'Auth::forgotPasswordForm');
$routes->post('/Admin/resetCheck', 'Auth::resetCheck');

// Route Dasboard Admin
$routes->get('/Admin', 'Admin\Admin::index');
$routes->get('/Admin/PreviewPdf', 'Admin\Admin::previewPdf');

// ROUTING CRUD DATA ADMIN
// route get all admin data
$routes->get('/Admin/Admin', 'Admin\Admin::admin');
// route search data admin
$routes->get('/Admin/Admin/search', 'Admin\Admin::search');
// route form & insert admin data
$routes->get('/Admin/Admin/formInsert', 'Admin\Admin::formInsert');
$routes->post('/Admin/Admin/Insert', 'Admin\Admin::insert');
// route form & update admin data
$routes->get('/Admin/Admin/formEdit/(:num)', 'Admin\Admin::formUpdate/$1');
$routes->post('/Admin/Admin/Update/(:num)', 'Admin\Admin::update/$1');
// route delete single user data 
$routes->delete('/Admin/Admin/(:num)', 'Admin\Admin::delete/$1');

// ROUTING CRUD DATA USER
// route get all user data 
$routes->get('/Admin/User', 'Admin\User::index');
// route delete single user data 
$routes->delete('/Admin/User/(:num)', 'Admin\User::delete/$1');
// route search data user
$routes->get('/Admin/User/search', 'Admin\User::search');
// route form & insert user data 
$routes->get('/Admin/User/formInsert', 'Admin\User::formInsert');
$routes->post('/Admin/User/insert', 'Admin\User::insert');
// route form & update user data 
$routes->get('/Admin/User/formEdit/(:segment)', 'Admin\User::formEdit/$1');
$routes->post('/Admin/User/update/(:num)', 'Admin\User::update/$1');
// route get single user 
$routes->get('/Admin/User/(:num)', 'Admin\User::detail/$1');

// ROUTING ABSEN
// route get all absen data 
$routes->get('/Admin/Absensi', 'Admin\Absen::index');
// route get insert & form absen 
$routes->get('/Admin/Absensi/formInsert', 'Admin\Absen::formInsert');
$routes->post('/Admin/Absensi/insert', 'Admin\Absen::insert');
// routes get detail absen data
$routes->get('/Admin/Absensi/(:num)', 'Admin\Absen::detail/$1');
// routes export data absen ke excel
$routes->get('/Admin/Absensi/export', 'Admin\Absen::export');
// route search absen data
$routes->get('/Admin/Absensi/search', 'Admin\Absen::search');

// ROUTING IZIN
// route get all data izin
$routes->get('/Admin/Izin', 'Admin\Izin::index');
// route get insert & form izin 
$routes->get('/Admin/Izin/formIzin', 'Admin\Izin::formIzin');
$routes->post('/Admin/Izin/insert', 'Admin\Izin::insert');
// route delete single izin data
$routes->delete('/Admin/Izin/(:num)', 'Admin\Izin::delete/$1');
// route form & update izin data 
$routes->get('/Admin/Izin/formEdit/(:segment)', 'Admin\Izin::formEdit/$1');
$routes->post('/Admin/Izin/update/(:num)', 'Admin\Izin::update/$1');
// route search izin data
$routes->get('/Admin/Izin/search', 'Admin\Izin::search');
// route get single izin data 
$routes->get('/Admin/Izin/(:num)', 'Admin\Izin::detail/$1');


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
