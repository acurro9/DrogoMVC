<?php
    namespace Controllers;
    use MVC\Router;
    use Model\Usuario;

    class UsuariosController {
        public static function verCuentas(Router $router){
            $tipo = $_SESSION["tipo"] ?? null;
            $errores = [];
            $res = $_GET['res'] ?? null;
    
            // Obtener datos para la paginación
            $ppp = $_GET["producto"] ?? 5; // Productos por página
            $pagina = $_GET["pagina"] ?? 1;
            $totalUsuarios = Usuario::contarUsuarios();

            $limit = $ppp;
            $offset = ($pagina - 1) * $ppp;
            $usuarios = Usuario::obtenerUsuariosPorPagina($limit, $offset);
            $totalPaginas = ceil($totalUsuarios / $ppp);

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

    public static function bloquearUsuario(Router $router) {
        // Usuario::verificarPermisos(); no va esto

        $errores = [];
        $usuarioBloqueado = null;
        //Iniciazliación de la variable acción
        $accion=1; 
        session_start();
        $usuario=$_SESSION['userObj'];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['action'] ?? null;
            $usuarioId = $_POST['idBloq'] ?? null;
            $username = $_POST['nameBloq'] ?? null;
            $email = $_POST['correoBloq'] ?? null;
    
            if ($accion == 1) {
                Usuario::bloquear($usuarioId, $username, $email);
            } elseif ($accion == 2) {
                Usuario::desbloquear($username);
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
    public static function actualizarUsuario(Router $router) {
        session_start();
        $errores = [];
        $usuario = null;
        $id = $_GET['usuario'] ?? null;
    
        if (!$id || !isset($_SESSION['login']) || $_SESSION['tipo'] != 'Administrador') {
            header('Location: /');
            exit;
        }
    
        $usuario = Usuario::find($id);
        if (!$usuario) {
            header('Location: /');
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
    
            if (!empty($_POST['password'])) {
                $usuario->password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }
    
           
            $errores = $usuario->validar($_POST['password'] !== '');
    
            if(empty($errores)) {
                if ($usuario->guardar()) {
                    header("Location: /usuario");
                    exit;
                } else {
                    
                    $errores[] = 'Error updating user.';
                }
            }
        }
    
        $router->render('usuarios/actualizarUsuario', [
            'usuario' => $usuario,
            'errores' => $errores
        ]);
    }
    
    public static function borrarCuenta(Router $router) {
        session_start();
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