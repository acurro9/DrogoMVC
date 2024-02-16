<?php
    namespace Model;
    use Exception;

    /**
     * Clase Contacto para gestionar contactos en la base de datos.
     * 
     * Esta clase extiende de ActiveRecord y se especializa en operaciones CRUD
     * para los contactos, incluyendo validación de datos y manejo de excepciones.
     */

    class Contacto extends ActiveRecord{

         /**
         * @var string Nombre de la tabla en la base de datos
         */
        protected static $tabla = 'contacto';
         
        /**
        * @var array Columnas de la tabla en la base de datos
        */
        protected static $columnasDB = ['id', 'nombre', 'email', 'telefono', 'mensaje'];

         /**
         * @var mixed ID del contacto
         */
        public $id;

        /**
         * @var string Nombre del contacto
         */
        public $nombre;

         /**
         * @var string Email del contacto
         */
        public $email;

        /**
        * @var string Teléfono del contacto
        */
        public $telefono;

        /**
        * @var string Mensaje del contacto
        */
        public $mensaje;

        /**
        * Constructor de la clase Contacto.
        * 
        * @param array $args Argumentos para inicializar un contacto.
        */

        public function __construct($args = []) {
            $this->id = $args['id'] ?? md5(uniqid(rand(), true));
            $this->nombre = $args['nombre'] ?? null;
            $this->email = $args['email'] ?? null;
            $this->telefono = $args['telefono'] ?? null;
            $this->mensaje = $args['mensaje'] ?? null;
        }

        /**
        * Valida los datos del contacto.
        * 
        * Este método verifica que todos los campos requeridos estén presentes y sean válidos.
        */

        public function validar(){
            if(!$this-> nombre){
                self::$errores[] = "El nombre es obligatorio.";
            } 
            if(!$this-> email){
                self::$errores[] = "El email es obligatorio.";
            } 
            if(!$this-> telefono){
                self::$errores[] = "El numero de telefono es obligatorio.";
            }
            if(!$this-> mensaje){
                self::$errores[] = "El mensaje es obligatorio.";
            }
            return self::$errores;
        }

        /**
        * Crea un nuevo contacto en la base de datos.
        * 
        * @return bool Retorna true si el contacto es creado exitosamente, false en caso contrario.
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
         * Elimina un contacto de la base de datos por su ID.
         * 
         * @return bool Retorna true si el contacto es eliminado exitosamente, false en caso contrario.
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
        * Cuenta el total de contactos en la base de datos.
        * 
        * @return int Retorna el número total de contactos.
        */
            public static function contarContactos() {
                try{
                    $query = "SELECT COUNT(*) as total FROM contacto";
                    $resultado = self::$db->query($query);
                    $fila = $resultado->fetch();
                    return $fila['total'];
                }catch(Exception $e){
                    echo 'Error: ', $e->getMessage(), "\n";
                    //Mensaje de error en int para mantener la consistencia; devuelve un valor claramente identificable como error
                    return -1;
                }
            }

            /**
             * Obtiene una lista paginada de contactos.
             * 
             * @param int $limit Número máximo de contactos a retornar.
             * @param int $offset Número de contactos a saltar.
             * @return array Retorna un array de objetos Contacto.
             */
            public static function obtenerContactosPorPagina($limit, $offset) {
                try{
                    $query = "SELECT * FROM contacto LIMIT {$limit} OFFSET {$offset}";
                    return self::consultarSQL($query);
                }catch(Exception $e){
                    echo 'Error: ', $e->getMessage(), "\n";
                    return [];
                }
            }

             /**
             * Busca un contacto por su ID.
             * 
             * @param mixed $id ID del contacto a buscar.
             * @return Contacto|null Retorna un objeto Contacto si se encuentra, null en caso contrario.
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
    }
