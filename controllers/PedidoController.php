<?php
namespace Controllers;
use MVC\Router;
use Model\Pedido;
use Model\Locker;
use Model\Usuario;
use Model\Envio;

/**
 * Controlador para la gestión de pedidos.
 *
 * Provee funcionalidades para crear, visualizar, actualizar y eliminar pedidos,
 * asegurando el acceso solo a usuarios con los permisos adecuados.
 */

    class PedidoController{

        /**
         * Muestra los pedidos existentes, con soporte para paginación y filtrado por usuario.
         * 
         * @param Router $router Instancia del router para renderizar la vista.
         */
        public static function verPedidos(Router $router){
            Usuario::verificarPermisos();
            $errores = [];

            $ppp = $_GET["producto"] ?? 5; // Productos por página
            $pagina = $_GET["pagina"] ?? 1;
            $totalPedidos = Pedido::contarPedido();

            $limit = $ppp;
            $offset = ($pagina - 1) * $ppp;
            $pedidos = Pedido::obtenerPedidoPorPagina($limit, $offset);
            $totalPaginas = ceil($totalPedidos / $ppp);

            $lockers = Locker::obtenerLockersPorPagina($limit, $offset);
            $direccion = Locker::obtenerDireccion();

            $id = Usuario::buscarID($_SESSION['usuario']);
            $usuario = Usuario::find($id);
            $tipo=$usuario->tipo;
            $users=Usuario::obtenerUsuariosPorPagina(300, 0);

            if($tipo!='Administrador'){
                $pedidos = Pedido::obtenerPedidoPorPaginaUsuario($limit, $offset, $id);
            } else {
                $pedidos = Pedido::obtenerPedidoPorPagina($limit, $offset);
            }
            // Renderizardo de la vista con los datos necesarios
            $router->render('Pedidos/pedidos', [
                'users' => $users,
                'tipo'=> $tipo,
                'lockers' => $lockers,
                'pedidos' => $pedidos,
                'totalPaginas' => $totalPaginas,
                'paginaActual' => $pagina,
                'ppp' => $ppp,
                'totalPedidos' => $totalPedidos,
                'direccion' => $direccion            
            ]);
        }

        /**
         * Actualiza la información de un pedido específico.
         * 
         * Solo accesible por usuarios con permisos de administrador. Permite la edición de un
         * pedido existente y actualiza sus datos en la base de datos, incluyendo la gestión
         * de la distribución relacionada.
         * 
         * @param Router $router Instancia del router para renderizar la vista con formulario de actualización.
         */
        public static function actualizarPedido(Router $router){
            Usuario::verificarPermisosAdmin();
            $errores = [];
            $id = $_GET['id'] ?? null;

            if (!$id) {
                header('Location: /');
                exit;
            }

            $pedido = Pedido::find($id);
            if (!$pedido) {
                header('Location: /');
                exit;
            }
            $lockers = Locker::obtenerLockersPorPagina(200, 0);
            $usuarios = Usuario::obtenerUsuariosPorPagina(200, 0);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $pedido->sincronizar($_POST);
        
            
                // $errores = $pedido->validar();
                $errores=$pedido->erroresActualizacionPedido($_POST);
        
                if(empty($errores)) {
                    if ($pedido->actualizar()) {

                        if($pedido->distribuidor==1){
                            $resultado = Envio::crearDistribucion($pedido->refCompra);
                            if($resultado){
                                $pedido->validacionExito(2);
                                    exit;
                                }
                        } else {
                            $resultado = Envio::borrarDistribucion($pedido->refCompra);
                            if($resultado){
                                $pedido->validacionExito(3);
                                exit;
                            }
                        }
                    } 
                } else {
                        
                    $_SESSION['errores'];
                }
                }
            $router->render('pedidos/actualizarPedido', [
                'pedido' => $pedido,
                'errores' => $errores,
                'lockers' => $lockers,
                'usuarios' => $usuarios
            ]);
        }

        
        /**
         * Elimina un pedido de la base de datos.
         * 
         * Solo accesible por usuarios con permisos de administrador. Elimina el pedido especificado
         * de la base de datos y, si es necesario, actualiza la información de distribución relacionada.
         * 
         * @param Router $router Instancia del router, aunque no se utiliza directamente en este método.
         */

        public static function borrarPedido(Router $router){
            Usuario::verificarPermisosAdmin();
            $pedidoID = $_GET["id"];

            // Encontrar el locker
            $pedido = Pedido::find($pedidoID);
            if (!$pedido) {
                header('Location: /pedido');
                exit;
            }
    
            // Eliminar el usuario actual
            if ($pedido->eliminar()) {
                Envio::borrarDistribucion($pedido->refCompra);
                // Se destruye la sesión y se redirecciona al usuario al directorio raíz
                $pedido->validacionExito(3);
                exit;
            } 
        }

            
        /**
         * Crea un nuevo pedido.
         * 
         * Solo accesible por usuarios con permisos de administrador. Valida los datos del formulario
         * y, si son correctos, guarda el nuevo pedido en la base de datos, incluyendo la gestión
         * de la distribución si es aplicable.
         * 
         * @param Router $router Instancia del router para renderizar la vista en caso de errores.
         */
        public static function crearPedido(Router $router){
            Usuario::verificarPermisosAdmin();
            $errores = [];
    
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $pedido = new Pedido([
                    'refCompra' => md5(uniqid(rand(), true)),
                    'hash_comprador' => $_POST['comp'] ?? null,
                    'hash_vendedor' => $_POST['vend'] ?? null,
                    'fechaCompra' => date('Y-m-d'),
                    'importe' => $_POST['imp'] ?? null,
                    'cargoTransporte' => $_POST['carT'] ?? null,
                    'cargosAdicionales' => $_POST['carA'] ?? null,
                    'fechaDeposito' => date($_POST['deposito']) ?? null,
                    'fechaRecogida' => date($_POST['registro']) ?? null,
                    'refLocker' => $_POST['locker'] ?? null,
                    'distribuidor' => isset($_POST['dist']) ? 1 : 0
                ]);
                $errores = $pedido->validar();
        
                if (empty($errores)) {
        
                    $resultado = $pedido->noExistePedido();
                    if (!$resultado) {
                        $errores = Pedido::getErrores();
                    } else {
                        $resultado = $pedido->crear();
                        if($pedido->distribuidor==1){
                            Envio::crearDistribucion($pedido->refCompra);
                        }
                        if($resultado){
                            $pedido->validacionExito(1);
                        }
                    }
                }
            }
            $lockers = Locker::obtenerLockersPorPagina(200, 0);
            $usuarios = Usuario::obtenerUsuariosPorPagina(200, 0);
            
            $router->render('pedidos/crearPedido', [
                'errores' => $errores,
                'lockers' => $lockers,
                'usuarios' => $usuarios
            ]);
        }

    }
