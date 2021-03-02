<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Dashboard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'User::index', ['filter' => 'auth']);
$routes->get('/kpi', 'User::kpi', ['filter' => 'auth']);
$routes->get('/login', 'Auth::index');
$routes->get('/register', 'Auth::register');
$routes->get('/tambahkpi', 'User::tambahkpi', ['filter' => 'auth']);
$routes->get('/getKpiByUser', 'User::getKpiByUser', ['filter' => 'auth']);
$routes->get('/getsop/(:num)', 'User::getSop/$1', ['filter' => 'auth']);
$routes->get('/sop/(:num)', 'User::sop/$1', ['filter' => 'auth']);
$routes->get('/ganti_password', 'Auth::gantiPassword', ['filter' => 'auth']);

//admin
$routes->get('/getListKpi', 'Admin::getListKpi', ['filter' => 'auth']);



$routes->post('/simpankpi', 'User::simpankpi');
$routes->post('/hapuskpi', 'User::hapuskpi');
$routes->post('/updatekpi', 'User::updatekpi');
$routes->post('/simpansop', 'User::simpansop');
$routes->post('/hapussop', 'User::hapussop');
$routes->post('/updatesop', 'User::updatesop');
$routes->post('/ganti_password', 'Auth::gantiPasswordAction');

//admin
$routes->get('/admin', 'Admin::index', ['filter' => 'auth']);
$routes->get('/admin/kpi', 'Admin::kpi', ['filter' => 'auth']);
$routes->get('/admin/kpi', 'Admin::kpi', ['filter' => 'auth']);
$routes->get('/admin/ganti_password', 'Auth::gantiPassword', ['filter' => 'auth']);

$routes->post('/admin/getKpiByUser', 'Admin::getKpiByUser');
$routes->post('/admin/getSop', 'Admin::sop');


//Auth
$routes->get('/logout', 'Auth::logout');
$routes->post('/login', 'Auth::login');
$routes->post('/daftar', 'Auth::prosesDaftar');



/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
