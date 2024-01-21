<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\PaginasController;
use Controllers\LoginController;
use Controllers\UsuariosController;


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


//LoginController

//Autenticaciones
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);


$router->get('/loginAdmin', [LoginController::class, 'loginAdmin']);
$router->post('/loginAdmin', [LoginController::class, 'loginAdmin']);

$router->get('/areaPersonal', [LoginController::class, 'areaPersonal']);
$router->get('/areaPersonalAdmin', [LoginController::class, 'areaPersonalAdmin']);


$router->get('/usuario', [PaginasController::class, 'usuario']);
$router->get('/actualizarUsuario', [PaginasController::class, 'actualizarUsuario']);


// $router->post('/login', [PaginasController::class, 'login']);
$router->post('/loginAdmin', [LoginController::class, 'loginAdmin']);

//Sayunara, b****
$router->post('/cerrarSesion', [LoginController::class, 'cerrarSesion']);
$router->post('/borrarCuenta', [UsuariosController::class, 'borrarCuenta']);

//Datos que cambiamos

$router->get('/modDatos', [LoginController::class, 'modDatos']);
$router->post('/modDatos', [LoginController::class, 'modDatos']);

$router->get('/datos', [LoginController::class, 'datos']);
$router->post('/datos', [LoginController::class, 'datos']);


$router->get('/datos', [LoginController::class, 'datos']);
$router->post('/datos', [LoginController::class, 'datos']);

//Zona Registro



//Zona Usuario

$router->get('/usuario', [UsuariosController::class, 'verCuentas']);
$router->post('/usuario', [UsuariosController::class, 'verCuentas']);

$router->get('/bloquearUsuario', [UsuariosController::class, 'bloquearUsuario']);
$router->post('/bloquearUsuario', [UsuariosController::class, 'bloquearUsuario']);

$router->get('/actualizarUsuario', [UsuariosController::class, 'actualizarUsuario']);
$router->post('/actualizarUsuario', [UsuariosController::class, 'actualizarUsuario']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();