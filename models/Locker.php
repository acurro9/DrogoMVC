<?php

namespace Model;
use Exception;

/**
 * Clase Locker para gestionar los lockers en la base de datos.
 *
 * Esta clase proporciona funcionalidades para crear, actualizar, validar,
 * contar, y obtener lockers, así como para manejar mensajes de éxito y errores de validación.
 */

class Locker extends ActiveRecord {

    /**
     * @var string Nombre de la tabla en la base de datos.
     */

    protected static $tabla = 'locker';

    /**
     * @var array Columnas de la base de datos para la clase Locker.
     */
    protected static $columnasDB = ['refLocker', 'direccion', 'passwordLocker'];

    /**
     * @var string referencia del locker
     */

    public $refLocker;

    /**
     * @var string ubicación del locker
     */

    public $direccion;

    /**
     * @var string contraseña del locker
     */

    public $passwordLocker;

    /**
     * Constructor de la clase Locker.
     *
     * @param array $args Argumentos para inicializar un objeto Locker.
     */

    public function __construct($args=[]) {
        $this->refLocker = $args['refLocker'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->passwordLocker = $args['passwordLocker'] ?? '';
    }

      /**
     * Crea un nuevo locker en la base de datos.
     *
     * @return bool Retorna true si el locker es creado con éxito, false en caso contrario.
     */
    public function crear(){
        try{
            // Sanitizar los datos
            $atributos = $this->sanitizarAtributos();
            $refLocker = md5(uniqid(rand(), true));

            // Inserción de datos
            $query = "INSERT INTO " . static::$tabla . " (";
            $query .= join(', ', array_keys($atributos));
            $query .= ") VALUES ('{$refLocker}";
            $query .= join("', '", array_values($atributos));
            $query .= "')";

            // Resultado de la consulta
            $resultado = self::$db->query($query);

            return $resultado;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return false;
        }
      
    }

     /**
     * Actualiza un locker existente en la base de datos.
     *
     * @return bool Retorna true si el locker es actualizado con éxito, false en caso contrario.
     */
    public function actualizar(){
        try{
           // Sanitización de datos
            $atributos = $this->sanitizarAtributos();

            $valores = [];
            foreach ($atributos as $key => $value) {
                $valores[] = "{$key}='{$value}'";
            }

            $query = "UPDATE " . static::$tabla . " SET ";
            $query .= join(', ', $valores);
            $query .= " WHERE refLocker = '" . $this->refLocker . "'";
            $query .= " LIMIT 1";

            return self::$db->query($query); 
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return false;
        }
        
   }

    /**
     * Valida los atributos del locker.
     *
     * @return array Retorna un array de errores si los hay.
     */
    public function validar(){
        if(!$this->direccion) {
            self::$errores[] = "Es obligatorio poner la dirección";
        }
        if(!$this->passwordLocker) {
            self::$errores[] = "Es obligatorio poner un password";
        }
        return self::$errores;
    }

     /**
     * Cuenta el total de lockers registrados en la base de datos.
     *
     * @return int Retorna el número total de lockers.
     */

    public static function contarLockers() {
        try{
            $query = "SELECT COUNT(*) as total FROM locker";
            $resultado = self::$db->query($query);
            $fila = $resultado->fetch();
            return $fila['total'];
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return -1;
        }
       
    }

    /**
     * Obtiene un conjunto de lockers por página.
     *
     * @param int $limit Número de lockers por página.
     * @param int $offset Número de lockers a saltar.
     * @return array Retorna un array de objetos Locker.
     */
    public static function obtenerLockersPorPagina($limit, $offset) {
        try{
            $query = "SELECT * FROM locker LIMIT {$limit} OFFSET {$offset}";
            return self::consultarSQL($query);
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return [];
        }
       
    }

     /**
     * Elimina un locker de la base de datos por su referencia.
     *
     * @return bool Retorna true si el locker es eliminado con éxito, false en caso contrario.
     */
    public function eliminar(){
        try{
            $idValue = $this->refLocker;
            $query = "DELETE FROM " . static::$tabla . " WHERE refLocker = '{$this->refLocker}';";
            $resultado = self::$db->query($query);
    
            return $resultado;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return false;
        }
    }

    /**
     * Verifica si un locker ya existe en la base de datos.
     *
     * @return bool Retorna true si el locker no existe, false si ya existe.
     */
    public function noExisteLocker() {
        try{
            $query = "SELECT * FROM " . self::$tabla . " WHERE refLocker = '{$this->refLocker}';";
            $resultado = self::$db->query($query);
            if($resultado->rowCount()) {
                self::$errores[] = 'El Locker Ya Existe';
                return false;
            }
            return true; 
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return false;
        }
    }

     /**
     * Encuentra un locker por su referencia.
     *
     * @param mixed $id Referencia del locker a buscar.
     * @return Locker|null Retorna un objeto Locker si se encuentra, null en caso contrario.
     */
    public static function find($id) {
        if (!$id) {
            return null; 
        }
    
        try {
            $query = "SELECT * FROM " . static::$tabla . " WHERE refLocker = '{$id}'"; 
            $resultado = self::consultarSQL($query);
    
            if ($resultado === false) {
                return null;
            }
    
            return array_shift($resultado);
        } catch (Exception $e) {
            error_log('Excepción capturada en find: ' . $e->getMessage());
            return null;
        }
    }   

        /**
         * Obtiene la dirección de todos los lockers registrados.
         *
         * @return array Retorna un array de direcciones de lockers.
         */
    public static function obtenerDireccion(){
        try{
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
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return [];
        }
    }

    /**
     * Genera un mensaje de éxito basado en un código proporcionado.
     *
     * @param int $codigo Código que representa el tipo de operación realizada.
     * @return string Retorna un mensaje de éxito personalizado.
     */
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

    /**
     * Maneja la validación y redirección tras una operación exitosa.
     *
     * @param int $codigo Código que representa el tipo de operación realizada.
     */

     public function validacionExito($codigo){
         $mensaje=$this->mssgExito($codigo);
         $_SESSION['mensaje_exito']=$mensaje;
         header("Location: /lockers");
     }

    /**
     * Muestra un mensaje de error determinado en caso de que se produzca uno.
     *
     * @param array $data Array de erroresz.
     * @return array Retorna un array de errores si los hay.
     */

     public function erroresActualizacionLocker($data){
        //Reinicio del arreglo de errores
        self::$errores=[];

        //Validación de la dirección del locker
        if(empty(trim($data['direccion']))){
            self::$errores[]="Se debe incluir la dirección del locker";
        }

        //Validación de la contraseña del locker
        if(empty($data['passwordLocker'])){
            self::$errores[]="Se debe incluir la contraseña del locker";
        }

        //Devuelve el arreglo de errores
        return self::$errores;    
    }
}