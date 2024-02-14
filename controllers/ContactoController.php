<?php  
    namespace Controllers;
    use MVC\Router;
    use Model\Contacto;
    use Model\Usuario;

    /**
     * Controlador para gestionar las operaciones sobre el modelo Contacto.
     *
     * Provee métodos para mostrar el formulario de contacto, crear un nuevo contacto,
     * ver los detalles de contacto y eliminar contactos, incluyendo la validación de acceso.
     */

    class ContactoController{

        /**
         * Muestra el formulario de contacto.
         * 
         * @param Router $router Instancia del router para renderizar la vista.
         */
        public static function contacto( Router $router ) {
            $router->render('paginas/form-contacto', [
    
            ]);
        }

        /**
         * Crea un nuevo contacto a partir de los datos enviados por el formulario.
         * 
         * Valida los datos del formulario y, si son correctos, guarda el nuevo contacto
         * en la base de datos. Redirecciona a la página principal si el contacto es creado con éxito.
         * 
         * @param Router $router Instancia del router para renderizar la vista en caso de errores.
         */
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

        /**
         * Muestra los contactos existentes, con soporte para paginación.
         * 
         * Solo accesible por usuarios con permisos de administrador. Obtiene los contactos
         * de la base de datos y los muestra en una vista de administración.
         * 
         * @param Router $router Instancia del router para renderizar la vista.
         */

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

        /**
         * Elimina un contacto específico.
         * 
         * Solo accesible por usuarios con permisos de administrador. Busca el contacto por su ID
         * y lo elimina de la base de datos. Redirecciona a la vista de contactos tras la eliminación.
         * 
         * @param Router $router Instancia del router, aunque no se utiliza directamente en este método.
         */
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
