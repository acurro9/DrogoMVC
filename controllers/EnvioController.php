<?php
    namespace Controllers;
    use Model\Envio;
    use MVC\Router;
    
        class EnvioController{
            public static function verEnvios(Router $router){
                $errores = [];
    
                $ppp = $_GET["producto"] ?? 5; // Productos por página
                $pagina = $_GET["pagina"] ?? 1;
                $totalEnvio = Envio::contarEnvio();
    
                $limit = $ppp;
                $offset = ($pagina - 1) * $ppp;
                $envio = Envio::obtenerEnvioPorPagina($limit, $offset);
                $totalPaginas = ceil($totalEnvio/ $ppp);
    
                // Renderizardo de la vista con los datos necesarios
                $router->render('Pedidos/envio', [
                    'envio' => $envio,
                    'totalPaginas' => $totalPaginas,
                    'paginaActual' => $pagina,
                    'ppp' => $ppp,
                    'totalEnvio' => $totalEnvio
                
                ]);
            }
    
            public static function actualizarEnvio(Router $router){
                $errores = [];
                $id = $_GET['envio'] ?? null;
    
                if (!$id) {
                    header('Location: /');
                    exit;
                }
    
                $envio = Envio::find($id);
                if (!$envio) {
                    header('Location: /');
                    exit;
                }
    
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $envio->sincronizar($_POST);
            
                
                    $errores = $envio->validar();
            
                    if(empty($errores)) {
                        if ($envio->actualizar()) {
                            header("Location: /envio");
                            exit;
                        } else {
                            
                            $errores[] = 'Error updating envio.';
                        }
                    }
                }
            }
    
            public static function borrarEnvio(Router $router){
                $envioID = $_GET["id"];
    
                // Encontrar el locker
                $envio = Envio::find($envioID);
                if (!$envio) {
                    header('Location: /envio');
                    exit;
                }
        
                // Eliminar el usuario actual
                if ($envio->eliminar()) {
                    // Se destruye la sesión y se redirecciona al usuario al directorio raíz
                    header('Location: /envio');
                    exit;
                } 
            }
    
            public static function crearEnvio(Router $router){
                $errores = [];
        
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $envio = new Envio([
                        'id' => $_POST['id'] ?? null,
                        'hash_distribuidor' => $_POST['hash_distribuidor'] ?? null,
                        'refCompra' => $_POST['refCompra'] ?? null,
                        'fechaRecogida' => $_POST['fechaRecogida'] ?? null,
                        'fechaDeposito' => $_POST['fechaDeposito'] ?? null,
                        'lockerOrigen' => $_POST['lockerOrigen'] ?? null,
                        'lockerDeposito' => $_POST['lockerDeposito'] ?? null,
                    ]);
            
                    $errores = $envio->validar();
            
                    if (empty($errores)) {
            
                        $resultado = $envio->noExisteEnvio();
                        if (!$resultado) {
                            $errores = Envio::getErrores();
                        } else {
                            $resultado = $envio->crear();
                            if($resultado){
                                header("Location: /envio");
                            }
                        }
                    }
                }
    
    
                $router->render('envio/crearEnvio', [
                    'errores' => $errores
                ]);
            }
        }
?>