<?php 

/**
 * Archivo de configuración inicial de la aplicación.
 *
 * Este archivo es responsable de establecer la configuración inicial necesaria para el funcionamiento
 * de la aplicación siguiendo el patrón Modelo-Vista-Controlador (MVC). Incluye la carga de librerías
 * y dependencias, la configuración de la conexión a la base de datos, y la inicialización de modelos
 * que interactuarán con la base de datos. Su inclusión en otros scripts prepara el entorno para
 * manejar solicitudes y responder adecuadamente según la lógica de la aplicación.
 *
 * Funciones principales:
 * - Carga de dependencias externas mediante Composer.
 * - Configuración de la conexión a la base de datos.
 * - Inicialización del modelo ActiveRecord para operaciones de base de datos.
 */


/**
 * Se incluye el archivo de funciones para poder utilizarlas en el script
 */
require 'funciones.php';

/**
 * Inclusión del archivo de configuración de la base de datos para poder importarla
 */
require 'config/database.php';

/**
 * Se utiliza el cargador automático generado por Composer para cargar las dependencias
 */

require __DIR__ . '/../vendor/autoload.php';

/**
 * Se realiza la conexión a la BD utilizando la función conectarDB() definida en 'funciones.php'
 */
$db = conectarDB();

/**
 * Imporación de la clase ActiveRecord a partir del namespace de Model
 */
use Model\ActiveRecord;

/**
 * Se establece la conexión a la BD para la clase ActiveRecord utilizando el método estático setDB()
 */
ActiveRecord::setDB($db);