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
                    $usuario = $resultado->fetchObject();
                    if ($usuario) {
                        // Verificación de password para usuarios regulares
                        if ($usuario->tipo !== 'Administrador') {
                            $autenticado = $auth->comprobarPassword($usuario);
                            if($autenticado){
                                $user = Usuario::find($usuario->id);

                                $user->autenticar();
                                debuguear($user);
                            } else{ 
                                $errores = Usuario::getErrores();
                            }
                        } else {
                            $errores = Usuario::getErrores();
                        }
                        // Verificación de password para admin
                        if  ($usuario && $usuario->tipo === 'Administrador' && $_POST['password'] === '1234') {                            
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


    public static function areaPersonal(Router $router) {
        Usuario::verificarPermisos();

    if (isset($_SESSION['login']) && $_SESSION['login']) {
        $id = Usuario::buscarID($_SESSION['usuario']);
            $usuario=Usuario::find($id);

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
        Usuario::verificarPermisosAdmin();
        $router->render('usuarios/areaPersonalAdmin', [

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
                    $usuario = $resultado->fetchObject(__Class__);
    
                    // Verifica si es administrador y la contraseña coincide con la hash almacenada
                    if ($usuario && $usuario->tipo === 'Administrador' && password_verify($_POST['password'], $usuario->password_hash)) {
                        session_start();
                        $_SESSION['login'] = true;
                        $_SESSION['usuario'] = $usuario->username;
                        $_SESSION['tipo'] = $usuario->tipo;
                        $_SESSION['id'] = $usuario->id;
    
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

    public static function modDatos(Router $router) {
        Usuario::verificarPermisos();
        $id = Usuario::buscarID($_SESSION['usuario']);
        $usuario = Usuario::find($id);
    
        if (isset($_SESSION['usuario'])) {
            $id = Usuario::buscarID($_SESSION['usuario']);
            $usuario=Usuario::find($id);
    
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
        session_start();
        session_destroy();

        header('Location: /');
        exit;
    }

    
    public static function datos(Router $router) {
        Usuario::verificarPermisos();
        $id = Usuario::buscarID($_SESSION['usuario']);
        $usuario=Usuario::find($id);

        $dataType = $_GET['type'] ?? ''; 
        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newValue = $_POST['new_value'] ?? '';
          
                switch ($dataType) {
                    case 'username':
                        if (!empty($newValue)) {
                            $usuario->username = $newValue;
                            if ($usuario->noExisteUsuarioDatos($usuario->id)) {
                                $usuario->actualizar();
                                $_SESSION['usuario'] = $newValue;
                                $usuario->validacionExito(4);
                                header('Location: /areaPersonal');
                                exit;
                            } else {
                                $errores[] = "El nombre de usuario ya está en uso";
                            }
                        } else {
                            $errores[] = "Debe introducir un nombre de usuario válido";
                        }
                        break;
                    case 'email':
                        if (!empty($newValue)&&filter_var($newValue, FILTER_VALIDATE_EMAIL)) {
                            $usuario->email = $newValue;
                            if ($usuario->noExisteUsuarioDatos($usuario->id)) {
                                $usuario->actualizar();
                                $usuario->validacionExito(5);
                                header('Location: /areaPersonal');
                                exit;
                            } else {
                                $errores[] = "El email ya está en uso por otro usuario";
                            }
                        } else {
                            $errores[] = "Debe introducir un email válido";
                        }
                        break;
                    case 'password':
                        $newPassword = $_POST['newPassword'] ?? '';
                        $confirmPassword = $_POST['confirmPassword'] ?? '';
            
                        if ($newPassword === $confirmPassword) {
                            // Aquí deberías validar la nueva contraseña
                            $usuario->password_hash = password_hash($newPassword, PASSWORD_DEFAULT);
                            $usuario->actualizar();
                            $usuario->validacionExito(6);
                            header('Location: /areaPersonal');
                            exit;
                        } else {
                            $errores[] = "Las contraseñas no coinciden";
                        }
                        break;
                    case 'cartera':
                        $nuevaCartera = $_POST['newCartera'] ?? '';
                        $confirmarCartera = $_POST['confirmCartera'] ?? '';
                       if($nuevaCartera === $confirmarCartera){
                            $usuario->actualizarCartera2($nuevaCartera);
                            $usuario->validacionExito(7);
                            header('Location: /areaPersonal');
                            exit;
                       }else{
                            $errores[]="Error al actualizar la cartera";
                       }
                       break;
                    default:
                        // Manejar casos no esperados
                        $errores[] = "Tipo de dato no válido";
                }
                if(!empty($errores)){
                    $usuario->validacionError($errores);
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