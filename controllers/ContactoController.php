<?php  
    namespace Controllers;
    use MVC\Router;
    use Model\Contacto;
    use Model\Usuario;

    class ContactoController{
        public static function contacto( Router $router ) {
            $router->render('paginas/form-contacto', [
    
            ]);
        }
        public static function crearContacto(Router $router){
            $errores = [];
    
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $contacto = new Contacto([
                    'id' =>  md5(uniqid(rand(), true)),
                    'nombre' => $_POST['nombre'] ?? null,
                    'email' => $_POST['email'] ?? null,
                    'telefono' => $_POST['telefono'] ?? null,
                    'mensaje' => $_POST['mensaje'] ?? null
                ]);
                $errores = $contacto->validar();
                //En caso de que no haya errores se realiza y envia la query a la base de datos
                if(empty($errores)){
                    $resultado= $contacto->crear();
                    if($resultado){
                        header("Location: /");
                    }
                
                }
            }
            $router->render('/', [
                'errores' => $errores
            ]);
        }

        public static function verContacto(Router $router){
            Usuario::verificarPermisosAdmin();
            $errores = [];
    
            // Obtener datos para la paginación
            $ppp = $_GET["producto"] ?? 5; // Productos por página
            $pagina = $_GET["pagina"] ?? 1;
            $totalContactos = Contacto::contarContactos();

            $limit = $ppp;
            $offset = ($pagina - 1) * $ppp;
            $contactos = Contacto::obtenerContactosPorPagina($limit, $offset);
            $totalPaginas = ceil($totalContactos / $ppp);

            // Renderizardo de la vista con los datos necesarios
            $router->render('admin/contacto', [
                'contactos' => $contactos,
                'totalPaginas' => $totalPaginas,
                'paginaActual' => $pagina,
                'ppp' => $ppp,
                'totalContactos' => $totalContactos,
                'errores' => $errores
            
            ]);
        }
        public static function borrarContacto(Router $router){
            Usuario::verificarPermisosAdmin();
            $id = $_GET["id"];

            // Encontrar el contacto
            $contacto = Contacto::find($id);
            if (!$contacto) {
                header('Location: /verContacto');
                exit;
            }
    
            // Eliminar el contacto actual
            if ($contacto->eliminar()) {
                // Se redirecciona a la tabla
                header('Location: /verContacto');
                exit;
            } 
        }
    }
?>