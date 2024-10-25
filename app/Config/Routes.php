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

$routes->cli('auth/token', 'Auth::getAuth');
$routes->cli('auth/authorization', 'Auth::getAuthorization');

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

// Perencanaan
$routes->get('perencanaan/formasi', 'Perencanaan::formasi');
$routes->get('perencanaan/storedb', 'Perencanaan::storedb');
$routes->get('perencanaan/search/(:any)/(:any)', 'Perencanaan::search/$1/$2');
$routes->get('perencanaan/getsubjabatan/(:any)/(:any)', 'Perencanaan::getsubjabatan/$1/$2');

// Perencanaan PPPK
$routes->get('pppk', 'Pppk::index');
$routes->get('pppk/sotk', 'Pppk::sotk');
$routes->post('pppk/changekuota', 'Pppk::changekuota');
$routes->post('pppk/deleterincian', 'Pppk::deleterincian');
$routes->get('pppk/search/(:any)/(:any)', 'Pppk::search/$1/$2');
$routes->get('pppk/search/(:any)/(:any)/(:any)', 'Pppk::search/$1/$2/$3');
$routes->get('pppk/searchunor/(:any)', 'Pppk::searchunor/$1');
$routes->get('pppk/searchsotk/(:any)/(:any)/(:any)', 'Pppk::searchsotk/$1/$2/$3');
$routes->get('pppk/searchsotkbyatasan/(:any)', 'Pppk::searchsotkbyatasan/$1');
$routes->get('pppk/sotkdetail/(:any)', 'Pppk::sotkdetail/$1');

