<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;
use Model\Pedido;

/**
 * Controlador para gestionar el renderizado de páginas estáticas.
 *
 * Proporciona métodos para mostrar diferentes páginas como el inicio, el equipo,
 * preguntas frecuentes, servicios y el área de administración.
 */

class PaginasController {
     /**
     * Muestra la página de inicio.
     * 
     * @param Router $router Instancia del router para renderizar la vista.
     */
    public static function index( Router $router ) {
        $router->render('paginas/index', [

        ]);
    }

     /**
     * Muestra la página del equipo.
     * 
     * @param Router $router Instancia del router para renderizar la vista.
     */
    public static function equipo( Router $router ) {
        $router->render('paginas/equipo', [

        ]);
    }

    /**
     * Muestra la página de preguntas frecuentes.
     * 
     * @param Router $router Instancia del router para renderizar la vista.
     */
    public static function preguntasFrecuentes( Router $router ) {
        $router->render('paginas/preguntas-frecuentes', [

        ]);
    }

     /**
     * Muestra la página de servicios.
     * 
     * @param Router $router Instancia del router para renderizar la vista.
     */
    public static function servicios( Router $router ) {
        $router->render('paginas/servicios', [

        ]);
    }

    /**
     * Muestra el área de administración.
     * 
     * Este método podría requerir verificación de permisos para asegurar que solo los usuarios
     * con roles de administrador puedan acceder a esta área.
     * 
     * @param Router $router Instancia del router para renderizar la vista.
     */
    public static function areaAdmin( Router $router ) {
        $router->render('admin/areaPersonalAdmin', [

        ]);
    }

    /**
     * Muestra la página de los charts.
     * 
     * @param Router $router Instancia del router para renderizar la vista.
     */

    public static function verCharts(Router $router) {
        // Obtención de usuarios compradores
        $usuariosCompradores = Usuario::obtenerNombresTipo('Comprador');
        $datosComprador = [];
        foreach($usuariosCompradores as $usuario){
            $datosComprador[] = [$usuario->username, Pedido::obtenerPedidos($usuario->id, 'hash_comprador')];
        }
    
        // Obtención de usuarios vendedores
        $usuariosVendedores = Usuario::obtenerNombresTipo('Vendedor');
        $datosVendedor = [];
        foreach($usuariosVendedores as $usuario){
            $datosVendedor[] = [$usuario->username, Pedido::obtenerPedidos($usuario->id, 'hash_vendedor')];
        }
    
        // Renderizado de la vista con los datos de compradores y vendedores
        $router->render('admin/charts', [
            
            'datosComprador' => $datosComprador,
            'datosVendedor' => $datosVendedor
        ]);
    }
    
}