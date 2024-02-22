<?php
    namespace Controllers;
    use MVC\Router;
    use Model\Usuario;

    /**
     * Controlador para gestionar el registro de usuarios.
     *
     * Proporciona funcionalidades para el registro de nuevos usuarios, incluyendo la validación
     * de los datos del formulario y la creación del registro de usuario en la base de datos.
     */
    class RegistroController{
        /**
         * Muestra y procesa el formulario de registro de nuevos usuarios.
         * 
         * Valida los datos del formulario y, si son correctos, crea un nuevo usuario en la base de datos.
         * Redirige a otra página para completar el registro si el proceso es exitoso.
         * 
         * @param Router $router Instancia del router para renderizar la vista.
         */
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

        /**
         * Completa el proceso de registro permitiendo al usuario proporcionar información adicional relativa a la cartera del usuario
         * 
         * Específicamente diseñado para recoger información adicional como el código y hasheado de la cartera del usuario después
         * del primer paso de registro. Valida los datos adicionales y actualiza el registro del usuario.
         * 
         * @param Router $router Instancia del router para renderizar la vista.
         */
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