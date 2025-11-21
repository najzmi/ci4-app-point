<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
$routes->get('/', 'Bo::login');
// LOGIN dan LOGOUT
$routes->match(['GET','POST'],'/login', 'Bo::login');
$routes->get('/logout', 'Bo::logout');
// DASHBOARD
//$routes->get('/dashboard', 'Dashboard::index', ['filter'=>'pdnislogin']);
$routes->group('dashboard', ['filter'=>'pdnislogin'], function($routes) {
    $routes->get('/', 'Dashboard::index');
    //$routes->get('grafik_kelas', 'Dashboard::grafik_kelas');
    $routes->post('grafik_kelas', 'Dashboard::grafik_kelas');
});
// USERS
$routes->group('users', ['filter'=>'pdnislogin'], function($routes) {
    $routes->get('/', 'UsersController::index');
    $routes->match(['GET','POST'], 'tambah', 'UsersController::tambah');
    $routes->match(['GET','POST'], 'edit/(:num)', 'UsersController::edit/$1');
    $routes->delete('hapus/(:num)', 'UsersController::hapus/$1');
    //$routes->match(['GET','POST'], 'data_json', 'UsersController::data_json');
    $routes->post('data_json', 'UsersController::data_json');
});
// MAPEL
$routes->group('mapel', ['filter'=>'pdnislogin'], function($routes) {
    $routes->get('/', 'MapelController::index');
    $routes->match(['GET','POST'], 'tambah', 'MapelController::tambah');
    $routes->match(['GET','POST'], 'edit/(:num)', 'MapelController::edit/$1');
    $routes->delete('hapus/(:num)', 'MapelController::hapus/$1');
    //$routes->match(['GET','POST'], 'data_json', 'MapelController::data_json');
    $routes->post('data_json', 'MapelController::data_json');
});
// GURU
$routes->group('guru', ['filter'=>'pdnislogin'], function($routes) {
    $routes->get('/', 'GuruController::index');
    $routes->match(['GET','POST'], 'tambah', 'GuruController::tambah');
    $routes->match(['GET','POST'], 'edit/(:num)', 'GuruController::edit/$1');
    $routes->delete('hapus/(:num)', 'GuruController::hapus/$1');
    //$routes->match(['GET','POST'], 'data_json', 'GuruController::data_json');
    $routes->post('data_json', 'GuruController::data_json');
});
// KELAS
$routes->group('kelas', ['filter'=>'pdnislogin'], function($routes) {
    $routes->get('/', 'KelasController::index');
    $routes->match(['GET','POST'], 'tambah', 'KelasController::tambah');
    $routes->match(['GET','POST'], 'edit/(:num)', 'KelasController::edit/$1');
    $routes->delete('hapus/(:num)', 'KelasController::hapus/$1');
    //$routes->match(['GET','POST'], 'data_json', 'KelasController::data_json');
    $routes->post('data_json', 'KelasController::data_json');
});
// MURID
$routes->group('murid', ['filter'=>'pdnislogin'], function($routes) {
    $routes->get('/', 'MuridController::index');
    $routes->match(['GET','POST'], 'tambah', 'MuridController::tambah');
    $routes->match(['GET','POST'], 'edit/(:num)', 'MuridController::edit/$1');
    $routes->delete('hapus/(:num)', 'MuridController::hapus/$1');
    //$routes->match(['GET','POST'], 'data_json', 'MuridController::data_json');
    $routes->post('data_json', 'MuridController::data_json');
    $routes->match(['GET','POST'], 'import_xlsx', 'MuridController::import_xlsx');
});
// PELANGARAN
$routes->group('pelanggaran', ['filter'=>'pdnislogin'], function($routes) {
    $routes->get('/', 'PelanggaranController::index');
    $routes->match(['GET','POST'], 'tambah', 'PelanggaranController::tambah');
    $routes->match(['GET','POST'], 'edit/(:num)', 'PelanggaranController::edit/$1');
    $routes->delete('hapus/(:num)', 'PelanggaranController::hapus/$1');
    //$routes->match(['GET','POST'], 'data_json', 'PelanggaranController::data_json');
    $routes->post('data_json', 'PelanggaranController::data_json');
    $routes->match(['GET','POST'], 'import_xlsx', 'PelanggaranController::import_xlsx');
});
// SANKSI
$routes->group('sanksi', ['filter'=>'pdnislogin'], function($routes) {
    $routes->get('/', 'SanksiController::index');
    $routes->match(['GET','POST'], 'tambah', 'SanksiController::tambah');
    $routes->match(['GET','POST'], 'edit/(:num)', 'SanksiController::edit/$1');
    $routes->delete('hapus/(:num)', 'SanksiController::hapus/$1');
    //$routes->match(['GET','POST'], 'data_json', 'SanksiController::data_json');
    $routes->post('data_json', 'SanksiController::data_json');
    $routes->get('(:num)/berkas', 'SanksiController::berkas/$1');
});
// REMISI
$routes->group('remisi', ['filter'=>'pdnislogin'], function($routes) {
    $routes->get('/', 'RemisiController::index');
    $routes->match(['GET','POST'], 'tambah', 'RemisiController::tambah');
    $routes->match(['GET','POST'], 'edit/(:num)', 'RemisiController::edit/$1');
    $routes->delete('hapus/(:num)', 'RemisiController::hapus/$1');
    //$routes->match(['GET','POST'], 'data_json', 'RemisiController::data_json');
    $routes->post('data_json', 'RemisiController::data_json');
});

// LAPORAN PER MURID
$routes->group('laporanmurid', ['filter'=>'pdnislogin'], function($routes) {
    $routes->get('/', 'LaporanMuridController::index');
    $routes->post('data_json', 'LaporanMuridController::data_json');
    $routes->get('cetak/(:num)', 'LaporanMuridController::cetak/$1');
});

// LAPORAN PER KELAS
$routes->group('laporankelas', ['filter'=>'pdnislogin'], function($routes) {
    $routes->get('/', 'LaporanKelasController::index');
    $routes->post('data_json', 'LaporanKelasController::data_json');
    $routes->get('cetak/(:num)', 'LaporanKelasController::cetak/$1');
});

// POINT BESAR DIATAS 25 POINT
$routes->group('pointlebih', ['filter'=>'pdnislogin'], function($routes) {
    $routes->get('/', 'PointLebihController::index');
    $routes->post('data_json', 'PointLebihController::data_json');
    $routes->get('cetak', 'PointLebihController::cetak');
});

// PINDAH KELAS
$routes->group('pindahkelas', ['filter'=>'pdnislogin'], function($routes) {
    $routes->get('/', 'PindahKelasController::index');
    $routes->post('proses_pindah', 'PindahKelasController::proses_pindah');
});
