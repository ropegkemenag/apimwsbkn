<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('auth/token', 'Auth::getAuth');
$routes->get('auth/authorization', 'Auth::getAuthorization');

$routes->get('pns/datautama/(:any)', 'Pns::datautama/$1');

// KP
$routes->get('kp/list/(:any)', 'Kp::list/$1');
$routes->get('kp/storedb/(:any)', 'Kp::storedb/$1');
$routes->get('kp/log/(:any)', 'Kp::log/$1');

// CASN
$routes->get('casn/dashboard', 'Casn::dashboard');
$routes->get('casn/dashboard/(:num)', 'Casn::dashboard/$1');

// IPASN
$routes->get('ipasn/nip/(:num)/(:num)', 'Ipasn::nip/$1/$2');
