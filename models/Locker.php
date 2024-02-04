<?php

namespace Model;

class Locker extends ActiveRecord {

    protected static $tabla = 'locker';
    protected static $columnasDB = ['refLocker', 'direccion', 'passwordLocker'];

    public $refLocker;
    public $direccion;
    public $passwordLocker;

    public function __construct($args=[]) {
        $this->refLocker = $args['refLocker'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->passwordLocker = $args['passwordLocker'] ?? '';
    }
    public function crear(){
        // Sanitizar los datos
      $atributos = $this->sanitizarAtributos();
      $refLocker = md5(uniqid(rand(), true));

      // Para meterle la id
      $query = "INSERT INTO " . static::$tabla . " (";
      $query .= join(', ', array_keys($atributos));
      $query .= ") VALUES ('{$refLocker}";
      $query .= join("', '", array_values($atributos));
      $query .= "')";

      // Resultado de la consulta
      $resultado = self::$db->query($query);

      return $resultado;
    }
    public function actualizar(){
        // Sanitización de datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE refLocker = '" . self::$db->escape_string($this->refLocker) . "'";
        $query .= " LIMIT 1";

        return self::$db->query($query);
   }
    public function validar(){
        if(!$this->direccion) {
            self::$errores[] = "Es obligatorio poner la dirección";
        }
        if(!$this->passwordLocker) {
            self::$errores[] = "Es obligatorio poner un password";
        }
        return self::$errores;
    }

    public static function contarLockers() {
        $query = "SELECT COUNT(*) as total FROM locker";
        $resultado = self::$db->query($query);
        $fila = $resultado->fetch_assoc();
        return $fila['total'];
    }

    // Método para obtener usuarios con paginación
    public static function obtenerLockersPorPagina($limit, $offset) {
        $query = "SELECT * FROM locker LIMIT {$limit} OFFSET {$offset}";
        return self::consultarSQL($query);
    }

    public function eliminar(){
        $idValue = self::$db->escape_string($this->refLocker);
        $query = "DELETE FROM " . static::$tabla . " WHERE refLocker = '{$this->refLocker}';";
        $resultado = self::$db->query($query);

        return $resultado;
    }
    public function noExisteLocker() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE refLocker = '{$this->refLocker}';";
        $resultado = self::$db->query($query);
        if($resultado->num_rows) {
            self::$errores[] = 'El Locker Ya Existe';
            return false;
        }
        return true;
    }
    // Busca un registro por su id
    public static function find($id) {
        if (!$id) {
            return null; 
        }
    
        try {
            $query = "SELECT * FROM " . static::$tabla . " WHERE refLocker = '{$id}'"; 
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
    public static function obtenerDireccion(){
        self::contarLockers();
        $query = "SELECT refLocker, direccion FROM locker";
        $lockers = self::$db->query($query);
        $cont=0;
        foreach ($lockers as $locker) {
            $direccion[$cont][0]=$locker['refLocker'];
            $direccion[$cont][1]=$locker['direccion'];
            $cont++;
        }
        return $direccion;

    }

    
    public static function mssgExito($codigo){
        switch($codigo){
         case 1: 
             $mensaje="Locker creado con éxito";
             break;
         case 2:
             $mensaje="Locker actualizado con éxito";
             break;
         case 3:
             $mensaje="Locker eliminado con éxito";
             break;
         default:
             $mensaje="Operación realizada con éxito";
             break;
        }
            
        return $mensaje;
     }

     public function validacionExito($codigo){
         $mensaje=$this->mssgExito($codigo);
         $_SESSION['mensaje_exito']=$mensaje;
         header("Location: /lockers");
     }
}