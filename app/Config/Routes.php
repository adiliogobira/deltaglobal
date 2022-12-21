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
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//$routes->get('/', 'Home::index');
//Rota de listagem de estudantes
$routes->get('/', 'Student::index', ['as' => 'student.index']);
$routes->get('/estudantes/lista', 'Student::list', ['as' => 'student.list']);
//Rota de cadastro de estudantes
$routes->get('/estudantes/cadastro', 'Student::create', ['as' => 'student.create']);
//Rota de edição de estudantes
$routes->get('/estudantes/editar/(:num)', 'Student::edit/$1', ['as' => 'student.edit']);
//Rota de exclusão de estudantes
$routes->get('/estudantes/excluir/(:num)', 'Student::destroy/$1', ['as' => 'student.destroy']);
//Rota de envio de formulario post do cadastro de estudantes
$routes->post('/estudantes/cadastro', 'Student::store', ['as' => 'student.store']);
//Rota de envio de formulario post da edição de estudantes
$routes->post('/estudantes/editar/(:num)', 'Student::update/$1', ['as' => 'student.update']);


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
