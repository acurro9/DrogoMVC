<?php

/**
 * Este script inicializa la configuración del proyecto, incluyendo la carga automática de clases
 * y la configuración inicial de la aplicación. Define rutas para manejar solicitudes HTTP GET y POST,
 * asociando cada ruta con un método específico en un controlador. Los controladores se encargan de la
 * lógica de negocio y pueden interactuar con los modelos para acceder y manipular datos. Así, cada ruta 
 * está diseñada para responder a diferentes acciones del usuario, como mostrar páginas, enviar formularios,
 * autenticar usuarios, y más.
 */


/**
 * Carga las dependencias del proyecto mediante el autoload de Composer.
 */
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Incluye la configuración inicial de la aplicación.
 */
require_once __DIR__ . '/../includes/app.php';

// Importación de clases de los controladores y el enrutador.
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

/**
 * Instancia del enrutador principal.
 */
$router = new Router();


/**
 * Definición de rutas para PaginasController
 */
$router->get('/', [PaginasController::class, 'index']);
$router->get('/nosotros', [PaginasController::class, 'equipo']);
$router->get('/preguntasFrecuentes', [PaginasController::class, 'preguntasFrecuentes']);
$router->get('/servicios', [PaginasController::class, 'servicios']);


/**
 * Rutas para iniciar y cerrar sesión de usuario y acceder al área personal del mismo
 */
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'cerrarSesion']);
$router->post('/logout', [LoginController::class, 'cerrarSesion']);
$router->get('/areaPersonal', [LoginController::class, 'areaPersonal']);


/**
 * Autenticación y acceso a zona de administrador
 */
$router->get('/loginAdmin', [LoginController::class, 'loginAdmin']);
$router->post('/loginAdmin', [LoginController::class, 'loginAdmin']);
$router->get('/areaPersonalAdmin', [LoginController::class, 'areaPersonalAdmin']);


/**
 * Rutas para borrar cuenta desde usuario con el controlador de usuario
 */

$router->get('/borrarCuenta', [UsuariosController::class, 'borrarCuenta']);
$router->post('/borrarCuenta', [UsuariosController::class, 'borrarCuenta']);

/**
 * Rutas para modificar de datos con el controlador de logueado
 */

$router->get('/modDatos', [LoginController::class, 'modDatos']);
$router->post('/modDatos', [LoginController::class, 'modDatos']);

/**
 * Rutas de acceso a datos con el controlador de datos desde el controaldor de logueado
 */
$router->get('/datos', [LoginController::class, 'datos']);
$router->post('/datos', [LoginController::class, 'datos']);

/**
 * Rutas de registro de usuario con los datos personales básicos a través del controlador de registro
 */
$router->get('/registro', [RegistroController::class, 'registro']);
$router->post('/registro', [RegistroController::class, 'registro']);

/**
 * Rutas de registro de usuario para registrar el password y hasheado de cartera a través del controlador de registro
 */
$router->get('/registro2', [RegistroController::class, 'registro2']);
$router->post('/registro2', [RegistroController::class, 'registro2']);

/**
 * Rutas de acceso a información de usuarios a través del controlador de usuarios
 */
$router->get('/usuario', [UsuariosController::class, 'verCuentas']);
$router->post('/usuario', [UsuariosController::class, 'verCuentas']);


/**
 * Rutas de acceso a la opción de bloquear usuario con el controlador de usuarios
 */

$router->get('/bloquearUsuario', [UsuariosController::class, 'bloquearUsuario']);
$router->post('/bloquearUsuario', [UsuariosController::class, 'bloquearUsuario']);

$router->get('/actualizarUsuario', [UsuariosController::class, 'actualizarUsuario']);
$router->post('/actualizarUsuario', [UsuariosController::class, 'actualizarUsuario']);

/**
 * Rutas de acceso al CRUD  de lockers con el controlador de lockers
 */
$router->get('/lockers', [LockersController::class, 'verLockers']);

$router->get('/crearLocker', [LockersController::class, 'crearLocker']);
$router->post('/crearLocker', [LockersController::class, 'crearLocker']);

$router->get('/actualizarLocker', [LockersController::class, 'actualizarLocker']);
$router->post('/actualizarLocker', [LockersController::class, 'actualizarLocker']);

$router->get('/borrarLocker', [LockersController::class, 'borrarLocker']);
$router->post('/borrarLocker', [LockersController::class, 'borrarLocker']);

/**
 * Rutas de acceso al CRUD  de Newsletter con el controlador de newsletter
 */
$router->post('/añadirNewsletter', [NewsletterController::class, 'crearNewsletter']);
$router->get('/newsletter', [NewsletterController::class, 'verNewsletters']);
$router->post('/borrarNewsletter', [NewsletterController::class, 'borrarNewsletter']);

/**
 * Rutas de acceso a opciones del contacto con el controlador de contacto
 */
$router->get('/contacto', [ContactoController::class, 'contacto']);
$router->post('/contacto', [ContactoController::class, 'crearContacto']);
$router->get('/verContacto', [ContactoController::class, 'verContacto']);
$router->post('/borrarContacto', [ContactoController::class, 'borrarContacto']);

/**
 * Rutas de acceso al CRUD  de Pedidos con el controlador de newsletter
 */
$router->get('/pedidos', [PedidoController::class, 'verPedidos']);
$router->post('/pedidos', [PedidoController::class, 'verPedidos']);
$router->get('/crearPedido', [PedidoController::class, 'crearPedido']);
$router->post('/crearPedido', [PedidoController::class, 'crearPedido']);
$router->get('/actualizarPedido', [PedidoController::class, 'actualizarPedido']);
$router->post('/actualizarPedido', [PedidoController::class, 'actualizarPedido']);
$router->post('/borrarPedido', [PedidoController::class, 'borrarPedido']);

/**
 * Rutas de acceso al CRUD  de Envios con el controlador de envios
 */
$router->get('/envios', [EnvioController::class, 'verEnvios']);
$router->get('/crearEnvio', [EnvioController::class, 'crearEnvio']);
$router->post('/crearEnvio', [EnvioController::class, 'crearEnvio']);
$router->get('/actualizarEnvio', [EnvioController::class, 'actualizarEnvio']);
$router->post('/actualizarEnvio', [EnvioController::class, 'actualizarEnvio']);
$router->post('/borrarEnvio', [EnvioController::class, 'borrarEnvio']);

/**
 * Comprueba y ejecuta las rutas definidas, asignando las funciones correspondientes del controlador.
 */
$router->comprobarRutas();