<?php

namespace Config;

use CodeIgniter\Database\Config;

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
$default_namespace      = 'App\Controllers';
$default_controller     = 'front';
$default_method         = 'index';
$translate_uri_dashes   = false;
$set_auto_route         = true;

$routes->setDefaultNamespace($default_namespace);
$routes->setDefaultController($default_controller);
$routes->setDefaultMethod($default_method);
$routes->setTranslateURIDashes($translate_uri_dashes);
$routes->set404Override();
$routes->setAutoRoute($set_auto_route);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


$routes->get('/', 'Home::index/');



$rdb = \Config\Database::connect();
$query = $rdb->query('select code from regions where enabled=1');
$regions = $query->getResult();

$routes->get('/noprice', 'Home::noprice/');

$routes->get('/translations/(:any)', 'Translations::index/$1');
$routes->get('/invoice/details/(:any)', 'Invoice::details/$1');
$routes->get('/invoice/auto/(:any)', 'Invoice::auto/$1');
$routes->get('/invoice/wp/(:any)', 'Invoice::wp/$1');
$routes->get('/invoice/(:any)', 'Invoice::index/$1');
$routes->get('/invoice/createpdf/(:any)', 'Invoice::createpdf/$1');
$routes->get('/demoinvoice/wpdemo/(:any)', 'Demoinvoice::wpdemo/$1');

$db = \Config\Database::connect();
$query = $db->query('select code from language');
$langs = $query->getResult();
if($langs){
	foreach($langs as $l){
	     
	     $routes->get('/'.$l->code, 'Home::index/'.$l->code);
	   
	     $routes->add('/'.$l->code.'/blog/(:any)', 'Blog::index/$1');
	     
	     $routes->add('/'.$l->code.'/page/becomedealer2/(:any)', 'Page::becomedealer2/$1');
	     $routes->add('/'.$l->code.'/page/thankscontact', 'Page::thankscontact');
	     $routes->add('/'.$l->code.'/page/thanks', 'Page::thanks');
	     $routes->add('/'.$l->code.'/page/(:any)', 'Page::index/$1');
	     
	     $routes->add('/'.$l->code.'/storedata/calculation/(:any)', 'Storedata::calculation/$1');
	     $routes->add('/'.$l->code.'/storedata', 'Storedata::index/$1');
	   //  $routes->add('/'.$l->code.'/pagetest/thanks', 'Page::thanks');
	    // $routes->add('/'.$l->code.'/pagetest/(:any)', 'Page::index/$1');
	    
	    $routes->add('/'.$l->code.'/invoice/details/(:any)', 'Invoice::details/$1');
	    $routes->add('/'.$l->code.'/invoice/auto/(:any)', 'Invoice::auto/$1');
	    $routes->add('/'.$l->code.'/invoice/wp/(:any)', 'Invoice::wp/$1');
        $routes->add('/'.$l->code.'/invoice/(:any)', 'Invoice::index/$1');
	     
	     $routes->add('/'.$l->code.'/projects', 'Projects::all');
	     $routes->add('/'.$l->code.'/projects/map', 'Projects::map');
	     $routes->add('/'.$l->code.'/projects/(:any)', 'Projects::index/$1');
	     
	     
	     $routes->add('/'.$l->code.'/quotes/thanks/', 'Quotes::thanks');
	     $routes->add('/'.$l->code.'/quotes/(:any)', 'Quotes::index/$1');
	     
	     $routes->add('/'.$l->code.'/products/details/(:any)', 'Products::details/$1');
	     $routes->add('/'.$l->code.'/products/(:any)', 'Products::index/$1');
	     $routes->add('/'.$l->code.'/products', 'Products::all');
	   
	     if($regions){
	     foreach($regions as $r){
	         
	         $routes->get('/'.$l->code.'/'.$r->code, 'Home::index/'.$l->code.'/'.$r->code);
	         
	        }
	     }
	     
	     
	      $routes->add('^' . $l->code . '/invoice/(:any)', 'Invoice::index/$1');

	      $routes->add('^' . $l->code . '/pdf/(:any)', 'Invoice::createpdf/$1');

	}
}


$routes->addRedirect('admin123', 'manage/account/login');
$routes->addRedirect('manage', 'manage/account/login');




     //   Examples

	 //	  $routes->add('^' . $set_l->code . '$', $default_controller);
     //   $routes->add('^' . $set_l->code . '/front', 'front/index/$1');
     //   $routes->add('^' . $set_l->code . '/news', 'news/index/');
     //   $routes->add('^' . $set_l->code . '/secure/(.+)$', 'secure::$1');
     //   $routes->add('^' . $set_l->code . '/category/ajax', 'category/ajax');
     //   $routes->add('^' . $set_l->code . '/category/(:any)', 'category/index/$1');
     //   $routes->add('^' . $set_l->code . '/product/(.+)$', 'product/index/$1');
     //   $routes->add('^' . $set_l->code . '/(.+)$', "$1");

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
