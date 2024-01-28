<?php

namespace Controllers;
use MVC\Router;
use Model\Newsletter;

class NewsletterController{
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
    public static function verNewsletters(Router $router){
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
    public static function borrarNewsletter(Router $router){
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