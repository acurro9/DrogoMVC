<?php
    namespace Controllers;
    use MVC\Router;
    use Model\Envio;
    use Model\Locker;
    use Model\Usuario;
    use Model\Pedido;

    /**
     * Controlador para la gestión de envíos.
     *
     * Provee funcionalidades para visualizar, actualizar y eliminar envíos,
     * asegurando el acceso solo a usuarios con los permisos adecuados.
     */
    
        class EnvioController{
            /**
             * Muestra la página de envíos con paginación y filtrado por usuario si es necesario.
             * 
             * @param Router $router Instancia del router para renderizar la vista.
             */
            public static function verEnvios(Router $router){
                Usuario::verificarPermisos();
                // if($_SESSION['tipo'] !== 'Administrador' || $_SESSION['tipo'] !== 'Distribuidor'){
                //     header("Location: /areaPersonal");
                // }
                $errores = [];
    
                $ppp = $_GET["producto"] ?? 5; // Productos por página
                $pagina = $_GET["pagina"] ?? 1;
                $totalEnvio = Envio::contarEnvio();
    
                $limit = $ppp;
                $offset = ($pagina - 1) * $ppp;
                $totalPaginas = ceil($totalEnvio/ $ppp);

                $lockers = Locker::obtenerLockersPorPagina($limit, $offset);
                $direccion = Locker::obtenerDireccion();
                $user = Usuario::obtenerNombres();
    
                $id = Usuario::buscarID($_SESSION['usuario']);
                $usuario = Usuario::find($id);
                $tipo=$usuario->tipo;

                if($tipo!='Administrador'){
                    $envios = Envio::obtenerEnvioPorPaginaUsuario($limit, $offset, $id);
                } else {
                    $envios = Envio::obtenerEnvioPorPagina($limit, $offset);
                }
                // Renderizardo de la vista con los datos necesarios
                $router->render('Pedidos/envio', [
                    'tipo' => $tipo,
                    'envios' => $envios,
                    'totalPaginas' => $totalPaginas,
                    'paginaActual' => $pagina,
                    'ppp' => $ppp,
                    'totalEnvio' => $totalEnvio,
                    'direccion' => $direccion,
                    'lockers' => $lockers,
                    'user'=> $user
                
                ]);
            }

            /**
             * Actualiza la información de un envío específico.
             * 
             * Solo accesible por usuarios con permisos de administrador. Permite la edición de un
             * envío existente y actualiza sus datos en la base de datos.
             * 
             * @param Router $router Instancia del router para renderizar la vista con formulario de actualización.
             */
    
            public static function actualizarEnvio(Router $router){
                Usuario::verificarPermisosAdmin();
                $errores = [];
                $refCompra = $_GET['id'] ?? null;
    
                if (!$refCompra) {
                    header('Location: /');
                    exit;
                }
    
                $envio = Envio::findID($refCompra);
                if (!$envio) {
                    header('Location: /');
                    exit;
                }
                $lockers = Locker::obtenerLockersPorPagina(200, 0);
                $usuarios = Usuario::obtenerUsuariosPorPagina(200, 0);
                $pedidos = Pedido::obtenerPedidoPorPagina(200, 0);
    
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $envio->sincronizar($_POST);
            
                
                    $errores = $envio->validar();
            
                    if(empty($errores)) {
                        if ($envio->actualizar()) {
                            header("Location: /envios");
                            exit;
                        } else {
                            
                            $errores[] = 'Error updating envio.';
                        }
                    }
                }
                $router->render('pedidos/actualizarEnvio', [
                    'envio' => $envio,
                    'errores' => $errores,
                    'lockers' => $lockers,
                    'usuarios' => $usuarios,
                    'pedidos' => $pedidos
                ]);
            }
            /**
             * Elimina un envío de la base de datos.
             * 
             * Solo accesible por usuarios con permisos de administrador. Elimina el envío especificado
             * y actualiza la información de distribución relacionada en los pedidos correspondientes.
             * 
             * @param Router $router Instancia del router, aunque no se utiliza directamente en este método.
             */
            public static function borrarEnvio(Router $router){
                Usuario::verificarPermisosAdmin();
                $envioID = $_GET["id"];
    
                // Encontrar el locker
                $envio = Envio::find($envioID);
                if (!$envio) {
                    header('Location: /envios');
                    exit;
                }
        
                // Eliminar el usuario actual
                if ($envio->eliminar()) {
                    Pedido::actualizarDistribucion(0, $envio->refCompra);
                    // Se destruye la sesión y se redirecciona al usuario al directorio raíz
                    header('Location: /envios');
                    exit;
                } 
            }
        }
