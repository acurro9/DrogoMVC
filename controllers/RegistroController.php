<?php
    namespace Controllers;
    use MVC\Router;
    use Model\Usuario;
    class RegistroController{
        public static function registro(Router $router){
            $errores = [];
    
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $auth = new Usuario([
                    'username' => $_POST['username'] ?? null,
                    'email' => $_POST['email'] ?? null,
                    'password_hash' => $_POST['password'] ?? null,
                    'passwordPlano' => $_POST['password2'] ?? null,
                    'tipo' => $_POST['tipo'] ?? null 
                ]);
        
                $errores = $auth->validarRegistro();
        
                if (empty($errores)) {
        
                    $resultado = $auth->noExisteUsuario();
                    if (!$resultado) {
                        $errores = Usuario::getErrores();
                    } else {
                        $auth->hashPass();
                        $resultado = $auth->crear();

                        
                        if($resultado){
                            // El usuario esta autenticado
                        session_start();
 
                        // Se Llena el arreglo de la sesión
                        $_SESSION['usuario'] = $auth->username;
                        $_SESSION['login'] = true;
                        $_SESSION['tipo'] = $auth->tipo;
                        $_SESSION['id'] = $auth->buscarID($auth->username);
                            header("Location: /registro2");
                        }
                    }
                }
            }


            $router->render('auth/registro', [
                'errores' => $errores
            ]);
        }
        public static function registro2(Router $router){
            $errores = [];
            session_start();
            $user = $_SESSION['usuario'];
            $userID = $_SESSION['id'];
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $auth = new Usuario([
                    'username' => $user ?? null,
                    'id' => $userID ?? null ,
                    'tipo' => $_SESSION['tipo'] ?? null
                ]);
                $cartera = $_POST['cartera'];
                if($cartera==''){
                    $errores[] = "Debes incluir la cartera";
                }
                if(empty($errores)){
                    $resultado = $auth->actualizarCartera($auth->id, (int)$auth->tipo, $cartera);
                    if($resultado){
                        header("Location: /areaPersonal");
                    }
                }
            }

            
            $router->render('auth/registro2', [
                'errores' => $errores,
                'user' => $user
            ]);
        }
    }