<?php

namespace Model;
use Exception;

/**
 * Clase ActiveRecord base para la interacción con la base de datos utilizando el patrón Active Record.
 * 
 * Proporciona métodos para realizar operaciones CRUD 
 * así como validación básica y sanitización de atributos.
 */

class ActiveRecord {

     /**
     * Conexión a la base de datos
     * @var object
     */
    protected static $db;
    
    /**
     * Nombre de la tabla en la base de datos para el modelo actual
     * @var string
     */
    protected static $tabla = '';

    /**
     * Columnas de la base de datos para el modelo actual
     * @var array
     */
    protected static $columnasDB = [];

    /**
     * ID del registro en la base de datos
     * @var mixed
     */

    protected $id=null;
    
    /**
     * Array para almacenar los errores de validación
     * @var array
     */
    protected static $errores = [];

    /**
     * Establece la conexión a la base de datos.
     * 
     * @param object $database Instancia de la conexión a la base de datos.
     */
    public static function setDB($database) {
        self::$db = $database;
    }


    /**
     * Obtiene los errores de validación.
     * 
     * @return array Array de errores de validación.
     */
    public static function getErrores() {
        return static::$errores;
    }

    /**
     * Validación de  los atributos del modelo. Este método debe ser sobrescrito por 
     * las clases hijas.
     * 
     * @return array Array de errores después de la validación.
     */

    public function validar() {
        static::$errores = [];
        return static::$errores;
    }

    /**
     * Guarda o actualiza un registro en la base de datos dependiendo de si el ID está presente.
     * 
     * @return mixed Resultado de la operación de guardar o actualizar.
     */
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // Actualización
            $resultado = $this->actualizar();
        } else {
            // Creación de un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    /**
     * Obtiene todos los registros de la tabla asociada.
     * 
     * @return array Array de objetos del modelo.
     */

    public static function all() {
        try{
            $query = "SELECT * FROM " . static::$tabla;

            $resultado = self::consultarSQL($query);

            return $resultado;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return [];
        }
    }

    /**
     * Busca un registro por su ID.
     * 
     * @param mixed $id ID del registro a buscar.
     * @return mixed Objeto del modelo encontrado o null si no se encuentra.
     */
    public static function find($id) {
        if (!$id) {
            return null; 
        }
    
        try {
            $query = "SELECT * FROM " . static::$tabla . " WHERE id = '{$id}'"; 
            $resultado = self::consultarSQL($query);
    
            if ($resultado === false || empty($resultado)) {
                return null;
            }
          
            return array_shift($resultado);
        } catch (Exception $e) {
            error_log('Excepción capturada en find: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtiene un número limitado de registros de la tabla asociada.
     * 
     * @param int $limite Número de registros a obtener.
     * @return array Array de objetos del modelo.
     */   

    public static function get($limite) {
        try{
            $query = "SELECT * FROM " . static::$tabla . " LIMIT {$limite}";

            $resultado = self::consultarSQL($query);
    
            return $resultado; 
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return [];
        }
    }

    /**
     * Crea un nuevo registro en la base de datos con los atributos actuales del modelo.
     * 
     * @return bool True si el registro se crea con éxito, false en caso contrario.
     * @throws Exception Si ocurre un error durante la ejecución de la consulta.
     */
    public function crear() {
        try{
            // Sanitizar los datos
            $atributos = $this->sanitizarAtributos();

            // Insertar en la base de datos
            $query = " INSERT INTO " . static::$tabla . " ( ";
            $query .= join(', ', array_keys($atributos));
            $query .= " ) VALUES (' "; 
            $query .= join("', '", array_values($atributos));
            $query .= " ') ";

            // Resultado de la consulta
            $resultado = self::$db->query($query);

            return $resultado;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return false;
        }
        
    }

    /**
     * Actualiza el registro actual en la base de datos basado en los atributos modificados del modelo.
     * 
     * @return bool True si el registro se actualiza con éxito, false en caso contrario.
     * @throws Exception Si ocurre un error durante la ejecución de la consulta.
     */
    public function actualizar() {
        try{
            // Sanitizar los datos
            $atributos = $this->sanitizarAtributos();

            $valores = [];
            foreach($atributos as $key => $value) {
                $valores[] = "{$key}='{$value}'";
            }

            $query = "UPDATE " . static::$tabla ." SET ";
            $query .=  join(', ', $valores );
            $query .= " WHERE id = '" . $this->id . "' ";
            $query .= " LIMIT 1 "; 

            $resultado = self::$db->query($query);

            return $resultado;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return false;
        }
    }

    /**
     * Elimina el registro actual de la base de datos.
     * 
     * @return bool True si el registro se elimina con éxito, false en caso contrario.
     * @throws Exception Si ocurre un error durante la ejecución de la consulta.
     */
    public function eliminar() {
        try{
            $idValue = $this->id;
            $query = "DELETE FROM " . static::$tabla . " WHERE id = '{$idValue}' LIMIT 1";
            $resultado = self::$db->query($query);
            
            return $resultado;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return false;
        }
    }

    /**
     * Ejecuta una consulta SQL y devuelve los resultados como objetos del modelo.
     * 
     * @param string $query La consulta SQL a ejecutar.
     * @return array Un array de objetos del modelo correspondiente.
     */
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch()) {
            $array[] = static::crearObjeto($registro);
        }


        // retornar los resultados
        return $array;
    }

     /**
     * Crea un objeto del modelo a partir de un array asociativo.
     * 
     * @param array $registro El array asociativo con los datos del registro.
     * @return object Una instancia del modelo con las propiedades establecidas.
     */

    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    
    /**
     * Recupera y devuelve los atributos del modelo que corresponden con las columnas en la base de datos.
     * 
     * @return array Un array asociativo de atributos del modelo.
     */
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    /**
     * Sanitiza los atributos del modelo para evitar inyecciones SQL.
     * 
     * @return array Un array asociativo de atributos sanitizados del modelo.
     */

    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = $value;
        }
        return $sanitizado;
    }

     /**
     * Sincroniza los atributos del modelo con un array proporcionado, usualmente proveniente de un formulario.
     * 
     * @param array $args Los datos a sincronizar con el modelo.
     */

    public function sincronizar($args=[]) {
        if(isset($args['distribuidor'])){
            if($args['distribuidor']=="on"){
                $args['distribuidor']=1;
            } else {
                $args['distribuidor']=0;
            } 
        }
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    /**
 * Sanitiza una cadena de texto para su uso seguro en HTML.
 *
 * Esta función elimina etiquetas HTML y PHP de la cadena de entrada,
 * aplica la función `trim()` para eliminar espacios en blanco al inicio
 * y al final, y convierte caracteres especiales en entidades HTML con
 * `htmlspecialchars()`. Es útil para prevenir ataques XSS (Cross-Site Scripting)
 * asegurando que el texto pueda ser mostrado de manera segura en una página web.
 *
 * @param string $valor La cadena de texto a sanitizar.
 * @return string La cadena sanitizada, segura para incluir en HTML.
 *
 */

    public static function sanitizarValor($valor){
        return htmlspecialchars(strip_tags(trim($valor)));
    }

}