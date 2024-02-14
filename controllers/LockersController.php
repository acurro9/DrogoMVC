<?php

namespace Controllers;
use MVC\Router;
use Model\Locker;
use Model\Usuario;

/**
 * Controlador para la gestión de lockers.
 *
 * Provee funcionalidades para crear, visualizar, actualizar y eliminar lockers,
 * asegurando el acceso solo a usuarios con permisos de administrador.
 */

class LockersController{
    /**
     * Crea un nuevo locker.
     * 
     * Valida los datos del formulario y, si son correctos, guarda el nuevo locker
     * en la base de datos. Redirecciona a una página de éxito si el locker es creado.
     * 
     * @param Router $router Instancia del router para renderizar la vista.
     */
    public static function crearLocker(Router $router){
        Usuario::verificarPermisosAdmin();
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
                        $locker->validacionExito(1);
                    }
                }
            }
        }


        $router->render('lockers/crearLockers', [
            'errores' => $errores
        ]);
   }

    /**
     * Muestra los lockers existentes, con soporte para paginación.
     * 
     * Solo accesible por usuarios con permisos de administrador. Obtiene los lockers
     * de la base de datos y los muestra en una vista de administración.
     * 
     * @param Router $router Instancia del router para renderizar la vista.
     */
   public static function verLockers(Router $router){
    Usuario::verificarPermisosAdmin();
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

    /**
     * Actualiza la información de un locker específico.
     * 
     * Solo accesible por usuarios con permisos de administrador. Permite la edición de un
     * locker existente y actualiza sus datos en la base de datos.
     * 
     * @param Router $router Instancia del router para renderizar la vista con formulario de actualización.
     */
    public static function actualizarLocker(Router $router){
        Usuario::verificarPermisosAdmin();
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
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $locker->sincronizar($_POST);
    
        
            $errores = $locker->erroresActualizacionLocker($_POST);
    
            if(empty($errores)) {
                if ($locker->actualizar()) {
                    $locker->validacionExito(2);
                    exit;
                } else {
                    $_SESSION['errores'];
                }
            }
        }
    
        $router->render('lockers/actualizarLockers', [
            'id' => $id,
            'locker' => $locker,
            'errores' => $errores
        ]);
    }

     /**
     * Elimina un locker de la base de datos.
     * 
     * Solo accesible por usuarios con permisos de administrador. Elimina el locker especificado
     * de la base de datos y redirecciona a la vista de lockers tras la eliminación.
     * 
     * @param Router $router Instancia del router, aunque no se utiliza directamente en este método.
     */
    public static function borrarLocker(Router $router) {
        Usuario::verificarPermisosAdmin();
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
            $locker->validacionExito(3);
            exit;
        } 
    }
}