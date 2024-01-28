<?php  
    namespace Controllers;
    use MVC\Router;
    use Model\Conctacto;

    class ConctactoControllers{
        public static function crearContacto(Router $router){
            $errores = [];
    
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $contacto = new Contacto([
                    'id' =>  md5(uniqid(rand(), true)),
                    'nombre' => $_POST['nombre'] ?? null,
                    'email' => $_POST['email'] ?? null,
                    'telefono' => $_POST['telefono'] ?? null,
                    'mensaje' => $_POST['mensaje'] ?? null,
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
    }
?>