<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('admin', 'Home::admin');

$routes->get('auth', 'Auth::index');
$routes->get('auth/token', 'Auth::getAuth');
$routes->get('auth/authorization', 'Auth::getAuthorization');

$routes->get('pns/datautama/(:any)', 'Pns::datautama/$1');

// KP
$routes->get('kp/list/(:any)', 'Kp::list/$1');
$routes->get('kp/storedb/(:any)', 'Kp::storedb/$1');
$routes->get('kp/log/(:any)', 'Kp::log/$1');

// CASN
$routes->get('casn/dashboard/cpns', 'Casn::dashboardcpns');
$routes->get('casn/dashboard/pppk', 'Casn::dashboardpppk');
$routes->get('casn/formasi', 'Casn::formasi');
$routes->get('casn/formasi/(:num)', 'Casn::formasi/$1');
$routes->get('casn/store/(:num)/(:num)', 'Casn::store/$1/$2');
$routes->get('casn/store/(:num)/(:num)/(:num)', 'Casn::store/$1/$2/$3');

// IPASN
$routes->get('ipasn/nip/(:num)/(:num)', 'Ipasn::nip/$1/$2');

// Pengadaan
$routes->get('pengadaan/list', 'Pengadaan::list');
$routes->get('pengadaan/dokumen', 'Pengadaan::dokumen');
