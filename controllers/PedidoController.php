<?php
namespace Controllers;
use MVC\Router;
use Model\Pedido;
use Model\Locker;
use Model\Usuario;

    class PedidoController{
        public static function verPedidos(Router $router){
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
            // Renderizardo de la vista con los datos necesarios
            $router->render('Pedidos/pedidos', [
                'lockers' => $lockers,
                'pedidos' => $pedidos,
                'totalPaginas' => $totalPaginas,
                'paginaActual' => $pagina,
                'ppp' => $ppp,
                'totalPedidos' => $totalPedidos,
                'direccion' => $direccion            
            ]);
        }

        public static function actualizarPedido(Router $router){
            $errores = [];
            $id = $_GET['pedido'] ?? null;

            if (!$id) {
                header('Location: /');
                exit;
            }

            $pedido = Pedido::find($id);
            if (!$pedido) {
                header('Location: /');
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $pedido->sincronizar($_POST);
        
            
                $errores = $pedido->validar();
        
                if(empty($errores)) {
                    if ($pedido->actualizar()) {
                        header("Location: /pedido");
                        exit;
                    } else {
                        
                        $errores[] = 'Error updating pedido.';
                    }
                }
            }
        }

        public static function borrarPedido(Router $router){
            $pedidoID = $_GET["id"];

            // Encontrar el locker
            $pedido = Pedido::find($pedidoID);
            if (!$pedido) {
                header('Location: /pedido');
                exit;
            }
    
            // Eliminar el usuario actual
            if ($pedido->eliminar()) {
                // Se destruye la sesión y se redirecciona al usuario al directorio raíz
                header('Location: /pedidos');
                exit;
            } 
        }

        public static function crearPedido(Router $router){
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

                        if($resultado){
                            header("Location: /pedidos");
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
?>