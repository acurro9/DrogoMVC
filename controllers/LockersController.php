<?php

namespace Controllers;
use MVC\Router;
use Model\Locker;

class LockersController{
    public static function crearLocker(Router $router){
        $errores = [];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $locker = new Locker([
                'refLocker' => $_POST['refLocker'] ?? null,
                'direccion' => $_POST['direccion'] ?? null,
                'passwordLocker' => $_POST['passwordLocker'] ?? null,
            ]);
    
            $errores = $locker->validar();
    
            if (empty($errores)) {
    
                $resultado = $locker->noExisteLocker();
                if (!$resultado) {
                    $errores = Locker::getErrores();
                } else {
                    $resultado = $locker->crear();
                    if($resultado){
                        header("Location: /lockers");
                    }
                }
            }
        }


        $router->render('lockers/crearLockers', [
            'errores' => $errores
        ]);
   }

   

   public static function verLockers(Router $router){
    $errores = [];

    // Obtener datos para la paginación
    $ppp = $_GET["producto"] ?? 5; // Productos por página
    $pagina = $_GET["pagina"] ?? 1;
    $totalLockers = Locker::contarLockers();

    $limit = $ppp;
    $offset = ($pagina - 1) * $ppp;
    $lockers = Locker::obtenerLockersPorPagina($limit, $offset);
    $totalPaginas = ceil($totalLockers / $ppp);

    // Renderizardo de la vista con los datos necesarios
    $router->render('lockers/lockers', [
        'lockers' => $lockers,
        'totalPaginas' => $totalPaginas,
        'paginaActual' => $pagina,
        'ppp' => $ppp,
        'totalLockers' => $totalLockers
    ]);
   }

    public static function actualizarLocker(Router $router){
        $errores = [];
        $locker = null;
        $id = $_GET['locker'] ?? null;
    
        if (!$id) {
            header('Location: /');
            exit;
        }
    
        $locker = Locker::find($id);
        if (!$locker) {
            header('Location: /');
            exit;
        }
        echo "<pre>";
        var_dump($locker);
        echo "</pre>";
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $locker->sincronizar($_POST);
    
        
            $errores = $locker->validar();
    
            if(empty($errores)) {
                if ($locker->guardar()) {
                    header("Location: /lockers");
                    exit;
                } else {
                    
                    $errores[] = 'Error updating locker.';
                }
            }
        }
    
        $router->render('lockers/actualizarLockers', [
            'id' => $id,
            'locker' => $locker,
            'errores' => $errores
        ]);
    }
    public static function borrarLocker(Router $router) {
        $lockerID = $_GET["id"];

        // Encontrar el locker
        $locker = Locker::find($lockerID);
        if (!$locker) {
            header('Location: /locker');
            exit;
        }

        // Eliminar el usuario actual
        if ($locker->eliminar()) {
            // Se destruye la sesión y se redirecciona al usuario al directorio raíz
            header('Location: /lockers');
            exit;
        } 
    }
}