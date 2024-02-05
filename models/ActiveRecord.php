<?php

namespace Model;
use Exception;

class ActiveRecord {

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    protected $id=null;

    // Errores
    protected static $errores = [];

    
    // Definir la conexión a la BD
    public static function setDB($database) {
        self::$db = $database;
    }

    // Validación
    public static function getErrores() {
        return static::$errores;
    }

    public function validar() {
        static::$errores = [];
        return static::$errores;
    }

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    public static function all() {
        try{
            $query = "SELECT * FROM " . static::$tabla;

            $resultado = self::consultarSQL($query);

            return $resultado;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
        }
    }

    // Busca un registro por su id
    public static function find($id) {
        if (!$id) {
            return null; 
        }
    
        try {
            $query = "SELECT * FROM " . static::$tabla . " WHERE id = '{$id}'"; 
            $resultado = self::consultarSQL($query);
    
            if ($resultado === false || empty($resultado)) {
                // Log del error, p.ej. error_log('Error en la consulta SQL: ' . self::$db->error);
                return null;
            }
          
            return array_shift($resultado);
        } catch (\Exception $e) {
            // Aquí puedes manejar la excepción y, opcionalmente, registrarla
            error_log('Excepción capturada en find: ' . $e->getMessage());
            return null;
        }
    }

    

    public static function get($limite) {
        try{
            $query = "SELECT * FROM " . static::$tabla . " LIMIT {$limite}";

            $resultado = self::consultarSQL($query);
    
            return $resultado; 
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
        }
    }

    // crea un nuevo registro
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
        }
        
    }

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
        }
    }

    public function eliminar() {
        try{
            $idValue = $this->id;
            $query = "DELETE FROM " . static::$tabla . " WHERE id = '{$idValue}' LIMIT 1";
            $resultado = self::$db->query($query);
            
            return $resultado;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
        }
    }

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

    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    
    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = $value;
        }
        return $sanitizado;
    }

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


}