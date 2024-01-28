<?php
    namespace Model;

    class Conctacto extends ActiveRecord{

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

            // Sanitizar los datos
            $atributos = $this->sanitizarAtributos();


            // Para meterle la id
            $query = "INSERT INTO " . static::$tabla . " (";
            $query .= join(', ', array_keys($atributos));
            $query .= ") VALUES (";
            $query .= join("', '", array_values($atributos));
            $query .= "')";


            // Resultado de la consulta
            $resultado = self::$db->query($query);

            return $resultado;
        }

        public function borrar(){
            $idValue = self::$db->escape_string($this->id);
            $query = "DELETE FROM " . static::$tabla . " WHERE id = '$this->id';";
            $resultado = self::$db->query($query);

            return $resultado;
        }
    }
?>