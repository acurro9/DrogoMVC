<?php

/**
 * Define la URL base para los templates.
 */
define('TEMPLATES_URL', __DIR__ . '/templates');
/**
 * Define la ruta del archivo de funciones.
 */
define('FUNCIONES_URL', __DIR__ . 'funciones.php');

/**
 * Incluye un template especificado por el nombre.
 *
 * @param string $nombre El nombre del archivo del template a incluir.
 * @param bool $inicio Especifica si se incluye el template o no. Valor por defecto: false.
 */
function incluirTemplate( string  $nombre, bool $inicio = false ) {
    include TEMPLATES_URL . "/{$nombre}.php"; 
}

/**
 * Imprime una representación formateada de una variable para debugging.
 *
 * @param mixed $variable La variable a depurar.
 */
function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

/**
 * Escapa y sanitiza el HTML para evitar ataques XSS.
 *
 * @param string $html El string HTML a escapar.
 * @return string El HTML escapado.
 */
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

/**
 * Valida si el tipo de contenido es aceptable.
 *
 * @param mixed $tipo El tipo de contenido a validar.
 * @return bool Verdadero si el tipo es válido, falso de lo contrario.
 */
function validarTipoContenido($tipo){
    $tipos = ['vendedor', 'propiedad'];
    return in_array($tipo, $tipos);
}

/**
 * Muestra un mensaje de notificación basado en un código.
 *
 * @param int $codigo El código de la notificación.
 * @return mixed El mensaje de notificación correspondiente al código, o false si el código no es válido.
 */
function mostrarNotificacion($codigo) {
    $mensaje = '';

    switch ($codigo) {
        case 1:
            $mensaje = 'Creada Correctamente';
            break;
        case 2:
            $mensaje = 'Actualizada Correctamente';
            break;
        case 3:
            $mensaje = 'Eliminada Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}

/**
 * Valida un ID en el query string de la URL o redirecciona si no es válido.
 *
 * @param string $url La URL a la que redireccionar si el ID no es válido.
 * @return int|void El ID validado como entero, o redirecciona si no es válido.
 */
function validarORedireccionar(string $url) {
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header("Location: {$url} " );
    }

    return $id;
}