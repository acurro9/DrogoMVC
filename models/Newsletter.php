<?php

namespace Model;
use Exception;

class Newsletter extends ActiveRecord {

    protected static $tabla = 'newsletter';
    protected static $columnasDB = ['email'];

    public $email;
    public $id;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? md5(uniqid(rand(), true));
        $this->email= $args['email'] ?? null;
    }
    public function crear(){
        try{
            // Sanitizar los datos
            $atributos = $this->sanitizarAtributos();

            // Para meterle la id
            $query = "INSERT INTO " . static::$tabla . " (";
            $query .= join(', ', array_keys($atributos));
            $query .= ") VALUES ('";
            $query .= join("', '", array_values($atributos));
            $query .= "')";

            // Resultado de la consulta
            $resultado = self::$db->query($query);

            return $resultado;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
        }
    }
    public function validar(){
        if(!$this->email) {
            self::$errores[] = "Debes indicar un correo electrónico";
        }
        return self::$errores;
    }
     // Método para contar el total de newsletter
     public static function contarNewsletter() {
        try{
            $query = "SELECT COUNT(*) as total FROM newsletter";
            $resultado = self::$db->query($query);
            $fila = $resultado->fetch();
            return $fila['total'];
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
        }
        
    }

    // Método para obtener newsletter con paginación
    public static function obtenerNewsletterPorPagina($limit, $offset) {
        try{
            $query = "SELECT * FROM newsletter LIMIT {$limit} OFFSET {$offset}";
            return self::consultarSQL($query);
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
        } 
    }

    public static function find($id) {
        if (!$id) {
            return null; 
        }
    
        try {
            $query = "SELECT * FROM " . static::$tabla . " WHERE email = '{$id}'"; 
            $resultado = self::consultarSQL($query);
    
            if ($resultado === false) {
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

    public function eliminar(){
        $idValue = $this->id;
        $query = "DELETE FROM " . static::$tabla . " WHERE email = '$this->email';";
        $resultado = self::$db->query($query);

        return $resultado;
    }
}