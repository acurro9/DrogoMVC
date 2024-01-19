<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\PaginasController;


$router = new Router();


// Paginas Controller
$router->get('/', [PaginasController::class, 'index']);
$router->get('/nosotros', [PaginasController::class, 'equipo']);
$router->get('/preguntasFrecuentes', [PaginasController::class, 'preguntasFrecuentes']);
$router->get('/servicios', [PaginasController::class, 'servicios']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();