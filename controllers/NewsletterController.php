<?php

namespace Controllers;
use MVC\Router;
use Model\Newsletter;
use Model\Usuario;

/**
 * Controlador para gestionar la suscripción a newsletters.
 *
 * Proporciona funcionalidades para suscribir a newsletters, visualizar las suscripciones existentes,
 * y eliminar suscripciones, asegurando el acceso solo a usuarios con permisos adecuados.
 */

class NewsletterController{

    /**
     * Crea una nueva suscripción a newsletter.
     * 
     * Valida los datos del formulario y, si son correctos, guarda la nueva suscripción
     * en la base de datos. Redirecciona a la página principal si la suscripción es exitosa.
     * 
     * @param Router $router Instancia del router para renderizar la vista en caso de errores.
     */
    public static function crearNewsletter(Router $router){
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newsletter = new Newsletter([
                'id' => md5(uniqid(rand(), true)),
                'email' => $_POST['email'] ?? null]);
            $errores = $newsletter->validar();
            //En caso de que no haya errores se realiza y envia la query a la base de datos
            if(empty($errores)){
                $resultado= $newsletter->crear();
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
     * Muestra las suscripciones a newsletters existentes, con soporte para paginación.
     * 
     * Solo accesible por usuarios con permisos de administrador. Obtiene las suscripciones
     * de la base de datos y las muestra en una vista de administración.
     * 
     * @param Router $router Instancia del router para renderizar la vista.
     */
    public static function verNewsletters(Router $router){
        Usuario::verificarPermisosAdmin();
        $errores = [];
    
            // Obtener datos para la paginación
            $ppp = $_GET["producto"] ?? 5; // Productos por página
            $pagina = $_GET["pagina"] ?? 1;
            $totalNewsletters = Newsletter::contarNewsletter();

            $limit = $ppp;
            $offset = ($pagina - 1) * $ppp;
            $newsletters = Newsletter::obtenerNewsletterPorPagina($limit, $offset);
            $totalPaginas = ceil($totalNewsletters / $ppp);

            // Renderizardo de la vista con los datos necesarios
            $router->render('admin/newsletter', [
                'newsletters' => $newsletters,
                'totalPaginas' => $totalPaginas,
                'paginaActual' => $pagina,
                'ppp' => $ppp,
                'totalNewsletters' => $totalNewsletters
            ]);
    }

     /**
     * Elimina una suscripción a newsletter de la base de datos.
     * 
     * Solo accesible por usuarios con permisos de administrador. Elimina la suscripción especificada
     * de la base de datos y redirecciona a la vista de newsletters tras la eliminación.
     * 
     * @param Router $router Instancia del router, aunque no se utiliza directamente en este método.
     */
    public static function borrarNewsletter(Router $router){
        Usuario::verificarPermisosAdmin();
        $id = $_GET["id"];

        // Encontrar el newsletter
        $newsletter = Newsletter::find($id);
        if (!$newsletter) {
            header('Location: /newsletter');
            exit;
        }

        // Eliminar el newsletter actual
        if ($newsletter->eliminar()) {
            // Se redirecciona a la tabla
            header('Location: /newsletter');
            exit;
        } 
    }
}