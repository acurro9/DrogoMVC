<?php 

namespace Controllers;
use MVC\Router;
use Model\Usuario;

class LoginController{
    public static function login(Router $router){
        $errores = [];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario([
                'username' => $_POST['username'] ?? null,
                'password_hash' => $_POST['password'] ?? null 
            ]);
    
            $errores = $auth->validarLogin();
    
            if (empty($errores)) {
                $auth->email = filter_var($_POST['username'], FILTER_VALIDATE_EMAIL) ? $_POST['username'] : '';
    
                $resultado = $auth->existeUsuario();
                $resulBloq = $auth->userBloq($_POST['username']);
                if (!$resultado || $resulBloq) {
                    $errores = Usuario::getErrores();
                } else {
                    $usuario = $resultado->fetch_object();
                    if ($usuario) {
                        // Verificación de password para usuarios regulares
                        if ($usuario->tipo !== 'Administrador') {
                            $autenticado = $auth->comprobarPassword($usuario);
                            if($autenticado){
                                $_SESSION['id'] = $auth->id; 
                                $auth->autenticar();
                            } else{ 
                                $errores = Usuario::getErrores();
                            }
                        } else {
                            $errores = Usuario::getErrores();
                        }
                        // Verificación de password para admin
                        if  ($usuario && $usuario->tipo === 'Administrador' && $_POST['password'] === '1234') {
                                session_start();
                                    $_SESSION['usuario'] = $usuario->username;
                                    $_SESSION['login'] = true;
                                    $_SESSION['tipo'] = $usuario->tipo;
                                    $_SESSION['id'] = $usuario->id;
                            
                                    header('Location: /loginAdmin');
                                    exit;
                            }                    
                    } else {
                        $errores[] = 'El Usuario No Existe';
                    }
                }
            }
        }
    
        $router->render('auth/login', [
            'errores' => $errores
        ]);
    }
    
    

    public static function logout(Router $router){
        $router->render('auth/logout', [

        ]);
    }



    public static function actualizarUsuario( Router $router ) {
        $router->render('usuarios/actualizarUsuario', [

        ]);
    }
    public static function areaPersonal(Router $router) {
        session_start();

    if (isset($_SESSION['login']) && $_SESSION['login']) {
        $usuario = Usuario::buscarUsuario($_SESSION['usuario'], $_SESSION['usuario']);

        if ($usuario) {
            $router->render('usuarios/areaPersonal', [
                'datosUsuario' => $usuario
            ]);
        } else {
            header('Location: /login');
            exit;
        }
    } else {
        header('Location: /login');
        exit;
    }
    }
    public static function areaPersonalAdmin( Router $router ) {
        $router->render('usuarios/areaPersonalAdmin', [

        ]);
    }

    public static function bloquearUsuario( Router $router ) {
        $router->render('usuarios/bloquearUsuario', [

        ]);
    }

    public static function loginAdmin(Router $router) {
        $errores = [];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario([
                'username' => $_POST['usuario'] ?? null,
                'password_hash' => $_POST['password'] ?? null 
            ]);
    
            $errores = $auth->validarLogin();
    
            if (empty($errores)) {
                $auth->email = filter_var($_POST['usuario'], FILTER_VALIDATE_EMAIL) ? $_POST['usuario'] : '';
    
                $resultado = $auth->existeUsuario();
    
                if (!$resultado) {
                    $errores[] = 'El usuario no existe.';
                } else {
                    $usuario = $resultado->fetch_object();
    
                    // Verifica si es administrador y la contraseña coincide con la hash almacenada
                    if ($usuario && $usuario->tipo === 'Administrador' && password_verify($_POST['password'], $usuario->password_hash)) {
                        session_start();
                        $_SESSION['usuario'] = $usuario->username;
                        $_SESSION['login'] = true;
                        $_SESSION['tipo'] = $usuario->tipo;
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['log']=2;
    
                        header('Location: /areaPersonalAdmin');
                        exit;
                    }
    
                    // Verificación de password para usuarios regulares
                    $autenticado = $auth->comprobarPassword($resultado);
    
                    if ($autenticado) {
                        $_SESSION['id'] = $auth->id; 
                        $auth->autenticar();
                    } else {
                        $errores[] = 'Contraseña incorrecta.';
                    }
                }
            }
        }
    
        $router->render('auth/loginAdmin', [
            'errores' => $errores
        ]);
    }
    
    
    public static function usuario( Router $router ) {
        $usuario = new Usuario();
        $usuario->eliminarUsuarioYCerrarSesion();
        $router->render('usuarios/usuario', [

        ]);
    }

    public static function modDatos(Router $router) {
        session_start();
        
        
        if (isset($_SESSION['id'])) {
            $usuario = Usuario::find($_SESSION['id']);
    
            if (!$usuario) {
                header('Location: /login');
                exit;
            }
    
            $router->render('usuarios/modDatos', [
                'datosUsuario' => $usuario
            ]);
        } else {
            header('Location: /login');
            exit;
        }
    }

    public static function cerrarSesion( Router $router ) {
        Usuario::cerrarSesion();
        //Nao precisa de render
    }

    
    public static function datos(Router $router) {
        session_start();

        if (!isset($_SESSION['login']) || !$_SESSION['login']) {
            header('Location: /login');
            exit;
        }
        
        $idUsuario = $_SESSION['id'] ?? null;
        $usuario = Usuario::find($idUsuario);
        $dataType = $_GET['type'] ?? ''; 
        $errores = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newValue = $_POST['new_value'] ?? '';
        
            switch ($dataType) {
                case 'username':
                    $usuario->username = $newValue;
                    break;
                case 'email':
                    $usuario->email = $newValue;
                    break;
                case 'password':
                    $newPassword = $_POST['newPassword'] ?? '';
                    $confirmPassword = $_POST['confirmPassword'] ?? '';
        
                    if ($newPassword === $confirmPassword) {
                        // Aquí deberías validar la nueva contraseña
                        $usuario->password_hash = password_hash($newPassword, PASSWORD_DEFAULT);
                    } else {
                        $errores[] = "Las contraseñas no coinciden";
                    }
                    break;
                default:
                    // Manejar casos no esperados
                    $errores[] = "Tipo de dato no válido";
            }
        
            if (empty($errores)) {
                $usuario->guardar();
                // Considera redirigir a otra página o mostrar un mensaje de éxito
                header('Location: /areaPersonal');
                exit;
            }
        }
        
        $router->render('usuarios/datos', [
            'datosUsuario' => $usuario,
            'errores' => $errores,
            'dataType' => $dataType
        ]);
}



}
    

  

   
