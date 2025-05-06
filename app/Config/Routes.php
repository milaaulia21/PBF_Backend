<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('auth', function($routes){
    $routes->post('login', 'AuthController::login');
    $routes->get('profile', 'AuthController::profile');
    $routes->post('register', 'AuthController::register');
});

$routes->group('dosen', function($routes) {
    $routes->get('/', 'DosenController::index');          
    $routes->get('(:num)', 'DosenController::show/$1');    
    $routes->post('/', 'DosenController::create');        
    $routes->put('(:num)', 'DosenController::update/$1');
    $routes->delete('(:num)', 'DosenController::delete/$1'); 
});

$routes->group('mahasiswa', function($routes) {
    $routes->get('/', 'MahasiswaController::index');          
    $routes->get('(:num)', 'MahasiswaController::show/$1');    
    $routes->post('/', 'MahasiswaController::create');        
    $routes->put('(:num)', 'MahasiswaController::update/$1'); 
    $routes->delete('(:num)', 'MahasiswaController::delete/$1'); 
});

$routes->group('sidang', function($routes) {
    $routes->get('/', 'SidangController::index');          
    $routes->get('(:num)', 'SidangController::show/$1');   
    $routes->post('/', 'SidangController::create');        
    $routes->put('(:num)', 'SidangController::update/$1');
    $routes->delete('(:num)', 'SidangController::delete/$1'); 
});

$routes->group('dosen_penguji', function($routes) {
    $routes->get('/', 'DosenPengujiController::index');          
    $routes->get('(:num)', 'DosenPengujiController::show/$1');    
    $routes->post('/', 'DosenPengujiController::create');       
    $routes->put('(:num)', 'DosenPengujiController::update/$1'); 
    $routes->delete('(:num)', 'DosenPengujiController::delete/$1'); 
});

$routes->group('ruangan', function($routes) {
    $routes->get('/', 'RuanganController::index');          
    $routes->get('(:num)', 'RuanganController::show/$1');
    $routes->post('/', 'RuanganController::create');       
    $routes->put('(:num)', 'RuanganController::update/$1'); 
    $routes->delete('(:num)', 'RuanganController::delete/$1'); 
});