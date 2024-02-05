<?php
    namespace Model;
    use Exception;

    class Contacto extends ActiveRecord{

        protected static $tabla = 'contacto';
        protected static $columnasDB = ['id', 'nombre', 'email', 'telefono', 'mensaje'];

        public $id;
        public $nombre;
        public $email;
        public $telefono;
        public $mensaje;

        public function __construct($args = []) {
            $this->id = $args['id'] ?? md5(uniqid(rand(), true));
            $this->nombre = $args['nombre'] ?? null;
            $this->email = $args['email'] ?? null;
            $this->telefono = $args['telefono'] ?? null;
            $this->mensaje = $args['mensaje'] ?? null;
        }

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

        public function eliminar(){
            try{
                $idValue = $this->id;
                $query = "DELETE FROM " . static::$tabla . " WHERE id = '$this->id';";
                $resultado = self::$db->query($query);

                return $resultado;
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
            }
        }
        // Método para contar el total de contactos
            public static function contarContactos() {
                try{
                    $query = "SELECT COUNT(*) as total FROM contacto";
                    $resultado = self::$db->query($query);
                    $fila = $resultado->fetch();
                    return $fila['total'];
                }catch(Exception $e){
                    echo 'Error: ', $e->getMessage(), "\n";
                }
            }

            // Método para obtener contactos con paginación
            public static function obtenerContactosPorPagina($limit, $offset) {
                try{
                    $query = "SELECT * FROM contacto LIMIT {$limit} OFFSET {$offset}";
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
                    $query = "SELECT * FROM " . static::$tabla . " WHERE id = '{$id}'"; 
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

            
    }
?>