<?php
    namespace Controllers;
    use MVC\Router;
    use Model\Usuario;

    /**
     * Controlador para gestionar las cuentas de usuario.
     *
     * Proporciona funcionalidades para ver, bloquear/desbloquear, actualizar y eliminar cuentas de usuario,
     * asegurando el acceso solo a usuarios con los permisos adecuados.
     */

    class UsuariosController {
        /**
         * Muestra las cuentas de usuario existentes, con soporte para paginación.
         * 
         * Solo accesible por usuarios con permisos de administrador. Obtiene las cuentas
         * de usuario de la base de datos y las muestra en una vista de administración.
         * 
         * @param Router $router Instancia del router para renderizar la vista.
         */
        public static function verCuentas(Router $router){
            if(!isset($request)){
                $request=null;
            }
            Usuario::verificarPermisosAdmin();
            $tipo = $_SESSION["tipo"] ?? null;
            $errores = [];
            $res = $_GET['res'] ?? null;
    
            // Obtener datos para la paginación
            $ppp = $_GET["producto"] ?? 5; // Productos por página
            $pagina = $_GET["pagina"] ?? 1;
            $totalUsuarios = Usuario::contarUsuarios();

            $limit = $ppp;
            $offset = ($pagina - 1) * $ppp;

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $param=$_POST['param'];
                $usuarios = Usuario::obtenerUsuariosAjax($param);
                $totalPaginas=0;
            } else{
                $usuarios = Usuario::obtenerUsuariosPorPagina($limit, $offset);
                $totalPaginas = ceil($totalUsuarios / $ppp);
            }

            $usuariosBloqueados = Usuario::obtenerUsuariosBloqueados();
            foreach ($usuarios as $usuario) {
                $usuario->bloqueado = in_array($usuario->id, $usuariosBloqueados);
            }

        // Renderizardo de la vista con los datos necesarios
        $router->render('admin/usuario', [
            'usuarios' => $usuarios,
            'totalPaginas' => $totalPaginas,
            'paginaActual' => $pagina,
            'ppp' => $ppp,
            'totalUsuarios' => $totalUsuarios
           
        ]);
    }

     /**
     * Bloquea o desbloquea una cuenta de usuario.
     * 
     * Solo accesible por usuarios con permisos de administrador. Permite cambiar el estado
     * de bloqueo de una cuenta de usuario específica y redirecciona tras realizar la acción.
     * 
     * @param Router $router Instancia del router para renderizar la vista.
     */

    public static function bloquearUsuario(Router $router) {
        Usuario::verificarPermisosAdmin();

        $errores = [];
        $usuarioBloqueado = null;
        //Iniciazliación de la variable acción
        $accion=1; 
        $usuario=new Usuario;
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['action'] ?? null;
            $usuarioId = $_POST['idBloq'] ?? null;
            $username = $_POST['nameBloq'] ?? null;
            $email = $_POST['correoBloq'] ?? null;
    
            if ($accion == 1) {
                Usuario::bloquear($usuarioId, $username, $email);
                $usuario->validacionExito(1);
        
            } elseif ($accion == 2) {
                Usuario::desbloquear($username);
                $usuario->validacionExito(2);
        
            }
    
            header("Location: usuario?res=$accion");
            exit;
        }
    
        $usuarioBloqueado = null;
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $name = $_GET['name'] ?? '';
            $correo = $_GET['correo'] ?? '';
            $id = $_GET['id'] ?? '';

            // Buscar por user
            $usuarioBloqueado = Usuario::buscarPorCriterios($name, $correo, $id);

            // Mirmao si está bloqueado
            if ($usuarioBloqueado && Usuario::userBloq($usuarioBloqueado->username)) {
                $accion = 2;
            }
        }
    
        $router->render('usuarios/bloquearUsuario', [
            'errores' => $errores,
            'usuario' => $usuarioBloqueado,
            'accion' => $accion
        ]);
    }
      /**
     * Actualiza la información de una cuenta de usuario.
     * 
     * Solo accesible por usuarios con permisos de administrador. Permite la edición de una
     * cuenta de usuario existente y actualiza sus datos en la base de datos.
     * 
     * @param Router $router Instancia del router para renderizar la vista con formulario de actualización.
     */
    public static function actualizarUsuario(Router $router) {
        Usuario::verificarPermisosAdmin();
        $errores = [];
        $usuario = null;
        $id = $_GET['usuario'] ?? null;
    
        if (!$id || !isset($_SESSION['login']) || $_SESSION['tipo'] != 'Administrador') {
            header('Location: /');
            exit;
        }
    
        $usuario = Usuario::find($id);
        //Para asegurarnos de que realmente se crea una instancia de la clase Usuario
        if (!$usuario instanceof Usuario) {
            header('Location: /');
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
    
            if (!empty($_POST['password'])) {
                $usuario->password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }
    
            // $errores = $usuario->validar($_POST['password'] !== '');
            $errores=$usuario->erroresActualizacion($_POST);
    
            if(empty($errores)) {
                if ($usuario->actualizar()) {
                    $usuario->validacionExito(3);
                    header("Location: /usuario");
                    exit;
                } else {
                    $_SESSION['errores'];
                   
                }
            }
        
        }
    
        
        $router->render('usuarios/actualizarUsuario', [
            'usuario' => $usuario,
            'errores' => $errores
        ]);
    }
    
    /**
     * Elimina una cuenta de usuario.
     * 
     * Accesible por el usuario dueño de la cuenta o un administrador. Elimina la cuenta de usuario especificada
     * de la base de datos y cierra la sesión si el usuario eliminado es el mismo que inició la sesión.
     * 
     * @param Router $router Instancia del router, aunque no se utiliza directamente en este método.
     */
    public static function borrarCuenta(Router $router) {
        Usuario::verificarPermisos();

        $userId = Usuario::buscarID($_SESSION['usuario']);

        if (!isset($userId)) {
            header('Location: /login');
            exit;
        }


        // Encontrar al usuario actual
        $usuarioActual = Usuario::find($userId);
        if (!$usuarioActual) {
            header('Location: /login');
            exit;
        }

        // Eliminar el usuario actual
        if ($usuarioActual->eliminar()) {
            // Se destruye la sesión y se redirecciona al usuario al directorio raíz
            session_destroy();
            header('Location: /');
            exit;
        } 
    }
}