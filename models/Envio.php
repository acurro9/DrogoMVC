<?php
    namespace Model;
    use Exception;

    /**
     * Clase Envio que extiende de ActiveRecord para manejar los envíos en la base de datos.
     *
     * Esta clase gestiona las operaciones relacionadas con los envíos, incluyendo la 
     * creación, actualización, eliminación, y consultas específicas como conteo y 
     * paginación.
     */

    class Envio extends ActiveRecord{

         /**
         * @var string Nombre de la tabla en la base de datos.
         */
        protected static $tabla = 'envio';

        /**
         * @var array Columnas de la base de datos para la clase Envio.
         */
        protected static $columnasDB = ['id', 'hash_distribuidor', 'refCompra', 'fechaRecogida', 'fechaDeposito', 'lockerOrigen', 'lockerDeposito'];

        /**
         * @var int id de envío
         */
        public $id;

        /**
         * @var string hash del distribuido
         */
        public $hash_distribuidor;

        /**
         * @var string referencia de compra
         */
        public $refCompra;
        /**
         * @var mixed fecha de recogida
         */
        public $fechaRecogida;
        /**
         * @var mixed fecha de depósito
         */
        public $fechaDeposito;
        
        /**
         * @var string
         */
        public $lockerOrigen;
        
        /**
         * @var string
         */
        public $lockerDeposito;

        /**
        * Constructor de la clase Envio.
        *
        * @param array $args Argumentos para inicializar un objeto Envio.
        */

        public function __construct($args = []) {
            $this->id = $args['id'] ?? md5(uniqid(rand(), true));
            $this->hash_distribuidor = $args['hash_distribuidor'] ?? null;
            $this->refCompra = $args['refCompra'] ?? null;
            $this->fechaRecogida = $args['fechaRecogida'] ?? null;
            $this->fechaDeposito = $args['fechaDeposito'] ?? null;
            $this->lockerOrigen = $args['lockerOrigen'] ?? null;
            $this->lockerDeposito = $args['lockerDeposito'] ?? null;
        }

        /**
        * Valida los atributos del envío.
        *
        * @return array Retorna un array de errores si los hay.
        */

        public function validar(){
            if(!$this->hash_distribuidor) {
                self::$errores[] = "Es obligatorio indicar el distribuidor";
            }
            if(!$this->refCompra) {
                self::$errores[] = "Es obligatorio indicar la referencia de la compra";
            }
            if(!$this->fechaRecogida) {
                self::$errores[] = "Es obligatorio indicar la fecha de recogida";
            }
            if(!$this->fechaDeposito) {
                self::$errores[] = "Es obligatorio indicar la fecha de deposito";
            }
            if(!$this->lockerOrigen) {
                self::$errores[] = "Es obligatorio indicar los locker del origen";
            }
            if(!$this->lockerDeposito) {
                self::$errores[] = "Es obligatorio indicar los locker del deposito";
            }
            return self::$errores;
        }

         /**
         * Crea un nuevo envío en la base de datos.
         *
         * @return bool Retorna true si el envío es creado con éxito, false en caso contrario.
         */

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
                return false;
            }
        }

        /**
        * Elimina un envío de la base de datos por su ID.
        *
        * @return bool Retorna true si el envío es eliminado con éxito, false en caso contrario.
        */

        public function eliminar(){
            try{
                $idValue = $this->id;
                $query = "DELETE FROM " . static::$tabla . " WHERE id = '$this->id';";
                $resultado = self::$db->query($query);

                return $resultado;
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
                return false;
            }
        }

        /**
        * Actualiza un envío existente en la base de datos.
        *
        * @return bool Retorna true si el envío es actualizado con éxito, false en caso contrario.
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
                $query .= " WHERE id = '" . $this->id . "'";
                $query .= " LIMIT 1";
        
                return self::$db->query($query);
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
                return false;
            }
        }

        /**
         * Encuentra un envío por su ID.
         * 
         * @param mixed $id ID del envío a buscar.
         * @return Envio|null Retorna un objeto Envio si se encuentra, null en caso contrario.
         */

        public static function find($id) {
            if (!$id) {
                return null; 
            }
        
            try {
                $query = "SELECT * FROM " . static::$tabla . " WHERE id = '{$id}'"; 
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
        public static function findID($id) {
            if (!$id) {
                return null; 
            }
        
            try {
                $query = "SELECT * FROM " . static::$tabla . " WHERE refCompra = '{$id}'"; 
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
         * Cuenta el total de envíos registrados en la base de datos.
         * 
         * @return int Retorna el número total de envíos.
         */

        public static function contarEnvio() {
            try{
                $query = "SELECT COUNT(*) as total FROM envio";
                $resultado = self::$db->query($query);
                $fila = $resultado->fetch();
                return $fila['total'];
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
                return -1;
            }
        }

         /**
         * Obtiene un conjunto de envíos por página.
         * 
         * @param int $limit Número de envíos por página.
         * @param int $offset Número de envíos a saltar.
         * @return array Retorna un array de objetos Envio.
         */

        public static function obtenerEnvioPorPagina($limit, $offset) {
            try{
                $query = "SELECT * FROM envio LIMIT {$limit} OFFSET {$offset}";
                return self::consultarSQL($query);
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
                return [];
            }
        }

         /**
         * Obtiene un conjunto de envíos por página para un usuario específico.
         * 
         * @param int $limit Número de envíos por página.
         * @param int $offset Número de envíos a saltar.
         * @param mixed $id ID del distribuidor.
         * @return array Retorna un array de objetos Envio asociados al distribuidor.
         */

        public static function obtenerEnvioPorPaginaUsuario($limit, $offset, $id) {
            try{
                $query = "SELECT * FROM envio where hash_distribuidor = '$id' LIMIT {$limit} OFFSET {$offset};";
            return self::consultarSQL($query);
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
                return [];
            }
        }

          /**
         * Verifica si un envío ya existe en la base de datos.
         * 
         * @return bool Retorna true si el envío no existe, false si ya existe.
         */

        public function noExisteEnvio() {
            try{
                $query = "SELECT * FROM " . self::$tabla . " WHERE id = '{$this->id}';";
                $resultado = self::$db->query($query);
                if($resultado->rowCount()) {
                    self::$errores[] = 'El Envio Ya Existe';
                    return false;
                }
                return true;
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
                return false;
            }
        }

        /**
         * Crea una distribución para un envío específico, evitando duplicados.
         * 
         * @param string $refCompra Referencia de compra del envío a crear.
         * @return bool Retorna true si la distribución es creada con éxito, false en caso contrario.
         */

        public static function crearDistribucion($refCompra){
            try{
                $query = "INSERT into envio (refCompra) values ('$refCompra') ON DUPLICATE KEY UPDATE refCompra = VALUES(refCompra)";
            return self::$db->query($query);
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
                return false;
            }
        }

         /**
         * Elimina una distribución específica por la referencia de compra.
         * 
         * @param string $refCompra Referencia de compra del envío a eliminar.
         * @return bool Retorna true si la distribución es eliminada con éxito, false en caso contrario.
         */
        public static function borrarDistribucion($refCompra){
            try{
                $query = "DELETE FROM envio where refCompra = '$refCompra';";
                return self::$db->query($query);
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
                return false;
            }
        }
    }
