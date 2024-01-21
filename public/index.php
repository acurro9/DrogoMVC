<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\PaginasController;
use Controllers\LoginController;


$router = new Router();


// Paginas Controller
$router->get('/', [PaginasController::class, 'index']);
$router->get('/nosotros', [PaginasController::class, 'equipo']);
$router->get('/preguntasFrecuentes', [PaginasController::class, 'preguntasFrecuentes']);
$router->get('/servicios', [PaginasController::class, 'servicios']);
$router->get('/contacto', [PaginasController::class, 'contacto']);
$router->get('/admin', [PaginasController::class, 'areaAdmin']);

// Login Controller
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();