<?php

namespace Controllers;
use MVC\Router;
use Model\Newsletter;

class NewsletterController{
    public static function crearNewsletter(Router $router){
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newsletter = new Newsletter($_POST['email'] ?? null);
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
}