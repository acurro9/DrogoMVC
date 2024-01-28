<?php
namespace Controllers;
use MVC\Router;
use Model\Pedido;
    class PedidoController{
        public static function verPedido(Router $router){
            $errores = [];

            $ppp = $_GET["producto"] ?? 5; // Productos por página
            $pagina = $_GET["pagina"] ?? 1;
            $totalPedido = Pedido::contarPedido();

            $limit = $ppp;
            $offset = ($pagina - 1) * $ppp;
            $pedido = Pedido::obtenerPedidoPorPagina($limit, $offset);
            $totalPaginas = ceil($totalPedido / $ppp);

            // Renderizardo de la vista con los datos necesarios
            $router->render('Pedidos/pedidos', [
                'pedido' => $pedido,
                'totalPaginas' => $totalPaginas,
                'paginaActual' => $pagina,
                'ppp' => $ppp,
                'totalPedido' => $totalPedido
            
            ]);
        }

        public static function actualizarPedido(Router $router){
            session_start();
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
                header('Location: /pedido');
                exit;
            } 
        }

        public static function crearPedido(Router $router){
            $errores = [];
    
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $pedido = new Pedido([
                    'refCompra' => $_POST['refCompra'] ?? null,
                    'hash_comprador' => $_POST['hash_comprador'] ?? null,
                    'hash_vendedor' => $_POST['hash_vendedor'] ?? null,
                    'fechaCompra' => $_POST['fechaCompra'] ?? null,
                    'importe' => $_POST['importe'] ?? null,
                    'cargoTransporte' => $_POST['cargoTransporte'] ?? null,
                    'cargosAdicionales' => $_POST['cargosAdicionales'] ?? null,
                    'fechaDeposito' => $_POST['fechaDeposito'] ?? null,
                    'fechaRecogida' => $_POST['fechaRecogida'] ?? null,
                    'refLocker' => $_POST['refLocker'] ?? null,
                    'distribuidor' => $_POST['distribuidor'] ?? null,
                ]);
        
                $errores = $pedido->validar();
        
                if (empty($errores)) {
        
                    $resultado = $pedido->noExistePedido();
                    if (!$resultado) {
                        $errores = Pedido::getErrores();
                    } else {
                        $resultado = $pedido->crear();
                        if($resultado){
                            header("Location: /pedido");
                        }
                    }
                }
            }


            $router->render('pedido/crearPedido', [
                'errores' => $errores
            ]);
        }
    }
?>