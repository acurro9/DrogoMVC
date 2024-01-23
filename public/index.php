<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\PaginasController;
use Controllers\LoginController;
use Controllers\UsuariosController;
use Controllers\RegistroController;


$router = new Router();


// PaginasController
$router->get('/', [PaginasController::class, 'index']);
$router->get('/nosotros', [PaginasController::class, 'equipo']);
$router->get('/preguntasFrecuentes', [PaginasController::class, 'preguntasFrecuentes']);
$router->get('/servicios', [PaginasController::class, 'servicios']);
$router->get('/contacto', [PaginasController::class, 'contacto']);
$router->post('/contacto', [PaginasController::class, 'contactoSQL']);
$router->get('/verContacto', [PaginasController::class, 'contactoAdmin']);



//LoginController
//Autenticaciones
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'cerrarSesion']);
$router->post('/logout', [LoginController::class, 'cerrarSesion']);
$router->get('/areaPersonal', [LoginController::class, 'areaPersonal']);

//Autenticaciones Admin
$router->get('/loginAdmin', [LoginController::class, 'loginAdmin']);
$router->post('/loginAdmin', [LoginController::class, 'loginAdmin']);
$router->get('/areaPersonalAdmin', [LoginController::class, 'areaPersonalAdmin']);





//UsuariosController
$router->get('/borrarCuenta', [UsuariosController::class, 'borrarCuenta']);
$router->post('/borrarCuenta', [UsuariosController::class, 'borrarCuenta']);

$router->get('/modDatos', [LoginController::class, 'modDatos']);
$router->post('/modDatos', [LoginController::class, 'modDatos']);

$router->get('/datos', [LoginController::class, 'datos']);
$router->post('/datos', [LoginController::class, 'datos']);


//RegistroController
$router->get('/registro', [RegistroController::class, 'registro']);
$router->post('/registro', [RegistroController::class, 'registro']);

$router->get('/registro2', [RegistroController::class, 'registro2']);
$router->post('/registro2', [RegistroController::class, 'registro2']);

//UsuariosController
$router->get('/usuario', [UsuariosController::class, 'verCuentas']);
$router->post('/usuario', [UsuariosController::class, 'verCuentas']);

$router->get('/bloquearUsuario', [UsuariosController::class, 'bloquearUsuario']);
$router->post('/bloquearUsuario', [UsuariosController::class, 'bloquearUsuario']);

$router->get('/actualizarUsuario', [UsuariosController::class, 'actualizarUsuario']);
$router->post('/actualizarUsuario', [UsuariosController::class, 'actualizarUsuario']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();