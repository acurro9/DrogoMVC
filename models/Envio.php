<?php
    namespace Model;

    class Envio extends ActiveRecord{
        protected static $tabla = 'envio';
        protected static $columnasDB = ['id', 'hash_distribuidor', 'refCompra', 'fechaRecogida', 'fechaDeposito', 'lockerOrigen', 'lockerDeposito'];
        public $id;
        public $hash_distribuidor;
        public $refCompra;
        public $fechaRecogida;
        public $fechaDeposito;
        public $lockerOrigen;
        public $lockerDeposito;

        public function __construct($args = []) {
            $this->id = $args['id'] ?? md5(uniqid(rand(), true));
            $this->hash_distribuidor = $args['hash_distribuidor'] ?? null;
            $this->refCompra = $args['refCompra'] ?? null;
            $this->fechaRecogida = $args['fechaRecogida'] ?? null;
            $this->fechaDeposito = $args['fechaDeposito'] ?? null;
            $this->lockerOrigen = $args['lockerOrigen'] ?? null;
            $this->lockerDeposito = $args['lockerDeposito'] ?? null;
        }

        public function validar(){
            if(!$this->hash_distribuidor) {
                self::$errores[] = "Es obligatorio poner el hash del distribuidor";
            }
            if(!$this->refCompra) {
                self::$errores[] = "Es obligatorio poner la referencia de la compra";
            }
            if(!$this->fechaRecogida) {
                self::$errores[] = "Es obligatorio poner la fecha de recogida";
            }
            if(!$this->fechaDeposito) {
                self::$errores[] = "Es obligatorio poner la fecha de deposito";
            }
            if(!$this->lockerOrigen) {
                self::$errores[] = "Es obligatorio poner los locker del origen";
            }
            if(!$this->lockerDeposito) {
                self::$errores[] = "Es obligatorio poner los locker del deposito";
            }
            return self::$errores;
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

        public function eliminar(){
            $idValue = self::$db->escape_string($this->id);
            $query = "DELETE FROM " . static::$tabla . " WHERE id = '$this->id';";
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
            $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "'";
            $query .= " LIMIT 1";
    
            return self::$db->query($query);
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

        public static function contarEnvio() {
            $query = "SELECT COUNT(*) as total FROM envio";
            $resultado = self::$db->query($query);
            $fila = $resultado->fetch_assoc();
            return $fila['total'];
        }

        public static function obtenerEnvioPorPagina($limit, $offset) {
            $query = "SELECT * FROM envio LIMIT {$limit} OFFSET {$offset}";
            return self::consultarSQL($query);
        }

        public function noExisteEnvio() {
            $query = "SELECT * FROM " . self::$tabla . " WHERE id = '{$this->id}';";
            $resultado = self::$db->query($query);
            if($resultado->num_rows) {
                self::$errores[] = 'El Envio Ya Existe';
                return false;
            }
            return true;
        }
    }
?>