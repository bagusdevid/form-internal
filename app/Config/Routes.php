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
$routes->post('/apiAddProcess', 'Home::apiAddProcess');
$routes->post('/apiEditProcess', 'Home::apiEditProcess');
$routes->post('/apiGetAll', 'Home::apiGetAll');
$routes->post('/apiGetById', 'Home::apiGetById');
$routes->get('/delete/(:num)', 'Home::delete/$1');
$routes->get('/login', 'Auth::index');
$routes->get('/logout', 'Auth::logout');
$routes->post('/login/verify', 'Auth::verify');
$routes->get('/users', 'Users::index');
$routes->get('/users/delete/(:num)', 'Users::delete/$1');
$routes->get('/users/reset_passwd/(:num)', 'Users::resetPasswd/$1');
$routes->get('/users/change_passwd', 'Users::changePasswd');
$routes->post('/users/changePasswdProcess', 'Users::changePasswdProcess');
$routes->post('/users/store', 'Users::store');
$routes->post('/api/users', 'Users::apiGetAll');
$routes->post('/api/users/store', 'Users::store');
$routes->post('/api/users/changepasswd', 'Users::apiChangePasswd');
$routes->get('/api/users/(:num)', 'Users::getById/$1');
$routes->get('/setting', 'Home::setting');
$routes->post('/api/setting/smtp', 'Home::getSMTPSetting');
$routes->post('/api/setting', 'Home::getRecipients');
$routes->post('/api/setting/store', 'Home::apiSettingStore');
$routes->post('/api/setting/smtp/store', 'Home::storeSMTP');
$routes->post('/api/setting/specific/store', 'Home::storeSpecificRecipient');

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
