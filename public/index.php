<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\PaginasController;
use Controllers\LoginController;
use Controllers\UsuariosController;
use Controllers\RegistroController;
use Controllers\LockersController;
use Controllers\NewsletterController;
use Controllers\ContactoController;
use Controllers\EnvioController;
use Controllers\PedidoController;

$router = new Router();


// PaginasController
$router->get('/', [PaginasController::class, 'index']);
$router->get('/nosotros', [PaginasController::class, 'equipo']);
$router->get('/preguntasFrecuentes', [PaginasController::class, 'preguntasFrecuentes']);
$router->get('/servicios', [PaginasController::class, 'servicios']);

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

//LockersController

$router->get('/lockers', [LockersController::class, 'verLockers']);

$router->get('/crearLocker', [LockersController::class, 'crearLocker']);
$router->post('/crearLocker', [LockersController::class, 'crearLocker']);

$router->get('/actualizarLocker', [LockersController::class, 'actualizarLocker']);
$router->post('/actualizarLocker', [LockersController::class, 'actualizarLocker']);

$router->get('/borrarLocker', [LockersController::class, 'borrarLocker']);
$router->post('/borrarLocker', [LockersController::class, 'borrarLocker']);

//NewsletterController
$router->post('/añadirNewsletter', [NewsletterController::class, 'crearNewsletter']);
$router->get('/newsletter', [NewsletterController::class, 'verNewsletters']);
$router->post('/borrarNewsletter', [NewsletterController::class, 'borrarNewsletter']);

//ContactoController
$router->get('/contacto', [ContactoController::class, 'contacto']);
$router->post('/contacto', [ContactoController::class, 'crearContacto']);
$router->get('/verContacto', [ContactoController::class, 'verContacto']);
$router->post('/borrarContacto', [ContactoController::class, 'borrarContacto']);

//EnvioController
$router->get('/envios', [EnvioController::class, 'verEnvios']);
$router->get('/crearEnvio', [PedidoController::class, 'crearEnvio']);

//PedidoController
$router->get('/pedidos', [PedidoController::class, 'verPedidos']);
$router->get('/crearPedido', [PedidoController::class, 'crearPedido']);
$router->post('/crearPedido', [PedidoController::class, 'crearPedido']);
$router->post('/borrarPedido', [PedidoController::class, 'borrarPedido']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();