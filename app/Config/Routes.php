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
$routes->get('/', 'AuthController::index');
$routes->get('/auth/logout', 'AuthController::logout');

$routes->post('/auth/loginUser', 'AuthController::loginUser');

$routes->group('', ['filter' => 'AuthCheck'], function($routes){
    $routes->get('/admin/dashboard', 'HomeController::index');
    $routes->get('/admin/users', 'UserController::index');

    /**
     * Users routes
     */
    $routes->get('/admin/users', 'UserController::index'); // view the users page
    $routes->get('/admin/add_user', 'UserController::add'); // view the add user page
    $routes->post('/user/store', 'UserController::storeUser'); // store user info to database
    $routes->get('/user/delete/(:num)', 'UserController::deleteUser/$1'); // delete user from database
    $routes->get('/admin/edit_user/(:num)', 'UserController::edit/$1'); // view the edit user page
    $routes->put('/user/update/(:num)', 'UserController::updateUser/$1'); // update user info in database

    /**
     * Categories routes
     */
    $routes->get('/admin/category', 'CategoryController::index'); // view the category page
    $routes->get('/admin/add_category', 'CategoryController::add'); // view the add category page
    $routes->post('/category/store', 'CategoryController::storeCategory'); // store category to database
    $routes->get('/category/delete/(:num)', 'CategoryController::deleteCategory/$1'); // delete category from database
    $routes->get('/admin/edit_category/(:num)', 'CategoryController::edit/$1'); // view the edit category page
    $routes->put('/category/update/(:num)', 'CategoryController::updateCategory/$1'); // update category in database

    /**
     * Products routes
     */
    $routes->get('/admin/product', 'ProductController::index'); // view the product page
    $routes->get('/admin/add_product', 'ProductController::add'); // view the add product page
    $routes->post('/product/store', 'ProductController::storeProduct'); // store product to database
    $routes->get('/product/delete/(:num)', 'ProductController::deleteProduct/$1'); // delete product from database
    $routes->get('/admin/edit_product/(:num)', 'ProductController::edit/$1'); // view the edit product page
    $routes->put('/product/update/(:num)', 'ProductController::updateProduct/$1'); // update the product in database

    /**
     * Sales routes
     */
    $routes->get('/admin/sales', 'SalesController::index'); // view the sales page
    $routes->get('/admin/add_sales', 'SalesController::add'); // show the sales page
    $routes->post('/sales/store', 'SalesController::storeSales'); // store sales in database
});




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
