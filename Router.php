<?php

namespace MVC;

/**
 * Clase Router de gestión de las rutas de la aplicación MVC.
 * 
 * Esta clase permite definir rutas GET y POST y manejarlas
 * mediante funciones callback especificadas; además,
 * renderiza las vistas con los datos proporcionados.
 */

class Router
{
    /**
     * Array asociativo de rutas GET, donde la clave es la URL y el valor es la función de callback.
     * 
     * @var array
     */
    public array $getRoutes = [];
   
    /**
     * Array asociativo de rutas POST, donde la clave es la URL y el valor es la función de callback.
     * 
     * @var array
     */

    public array $postRoutes = [];

    /**
     * Registra una ruta GET y su función de callback correspondiente.
     * 
     * @param string $url URL de la ruta.
     * @param callable $fn Función de callback que se ejecutará cuando se acceda a la ruta.
     */

    public function get($url, $fn) {
        $this->getRoutes[$url] = $fn;
    }

     /**
     * Registra una ruta POST y su función de callback correspondiente.
     * 
     * @param string $url URL de la ruta.
     * @param callable $fn Función de callback que se ejecutará cuando se acceda a la ruta.
     */

    public function post($url, $fn) {
        $this->postRoutes[$url] = $fn;
    }

    /**
     * Comprueba y ejecuta la función de callback de la ruta actual basándose en el método HTTP.
     * 
     * Este método determina si la solicitud actual coincide con alguna ruta registrada
     * y, de ser así, ejecuta la función de callback asociada.
     */

    public function comprobarRutas() {
        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }

        if ( $fn ) {
            // Call user fn va a llamar una función cuando no sabemos cual sera
            call_user_func($fn, $this); // This es para pasar argumentos
        } else {
            echo "Página No Encontrada o Ruta no válida";
        }
    }

    /**
     * Renderiza una vista con los datos proporcionados.
     * 
     * Este método incluye la vista especificada, pasando los datos proporcionados
     * a la misma. Los datos se extraen en variables antes de incluir la vista,
     * permitiendo su uso directo en la vista.
     * 
     * @param string $view Nombre del archivo de la vista a renderizar.
     * @param array $datos Datos que se pasarán a la vista.
     */

    public function render($view, $datos = []) {
        // Leer lo que le pasamos  a la vista
        foreach ($datos as $key => $value) {
            $$key = $value;  // Doble signo de dolar significa: variable variable, básicamente nuestra variable sigue siendo la original, pero al asignarla a otra no la reescribe, mantiene su valor, de esta forma el nombre de la variable se asigna dinamicamente
        }

        ob_start(); // Almacenamiento en memoria durante un momento...

        // entonces incluimos la vista en el layout
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); // Limpia el Buffer
        include_once __DIR__ . '/views/layout.php';
    }
}
