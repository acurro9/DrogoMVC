<?php
    namespace Model;

    class Pedido extends ActiveRecord{
        protected static $tabla = 'pedido';
        protected static $columnasDB = ['refCompra', 'hash_comprador', 'hash_vendedor', 'fechaCompra', 'importe', 'cargoTransporte', 'cargosAdicionales', 'fechaDeposito', 'fechaRecogida', 'refLocker', 'distribuidor'];
        public $refCompra;
        public $hash_comprador;
        public $hash_vendedor;
        public $fechaCompra;
        public $importe;
        public $cargoTransporte;
        public $cargosAdicionales;
        public $fechaDeposito;
        public $fechaRecogida;
        public $refLocker;
        public $distribuidor;

        public function __construct($args = []) {
            $this->refCompra = $args['refCompra'] ?? md5(uniqid(rand(), true));
            $this->hash_comprador = $args['hash_comprador'] ?? null;
            $this->hash_vendedor = $args['hash_vendedor'] ?? null;
            $this->fechaCompra = $args['fechaCompra'] ?? null;
            $this->importe = $args['importe'] ?? null;
            $this->cargoTransporte = $args['cargoTransporte'] ?? null;
            $this->cargosAdicionales = $args['cargosAdicionales'] ?? null;
            $this->fechaDeposito = $args['fechaDeposito'] ?? null;
            $this->fechaRecogida = $args['fechaRecogida'] ?? null;
            $this->refLocker = $args['refLocker'] ?? null;
            $this->distribuidor = $args['distribuidor'] ?? null;
        }

        public function validar(){
            if(!$this->hash_comprador) {
                self::$errores[] = "Es obligatorio indicar el comprador";
            }
            if(!$this->hash_vendedor) {
                self::$errores[] = "Es obligatorio indicar el vendedor";
            }
            if(!$this->fechaCompra) {
                self::$errores[] = "Es obligatorio indicar la fecha del pedido";
            }
            if(!$this->importe) {
                self::$errores[] = "Es obligatorio indicar los importes";
            }
            if(!$this->cargoTransporte) {
                self::$errores[] = "Es obligatorio indicar los cargos de transporte";
            }
            if(!$this->cargosAdicionales) {
                self::$errores[] = "Es obligatorio indicar los cargos adicionales";
            }
            if(!$this->fechaDeposito) {
                self::$errores[] = "Es obligatorio indicar la fecha de deposito";
            }
            if(!$this->fechaRecogida) {
                self::$errores[] = "Es obligatorio indicar la fecha de recogida";
            }
            if(!$this->refLocker) {
                self::$errores[] = "Es obligatorio indicar la direccion del locker";
            }
            if($this->fechaDeposito>$this->fechaRecogida){
                $errores[]="La fecha de recogida no puede ser anterior a la fecha de deposito.";
            }
            return self::$errores;
        }

        public function crear(){

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
        }

        public function eliminar(){
            $idValue = self::$db->escape_string($this->refCompra);
            $query = "DELETE FROM " . static::$tabla . " WHERE refCompra = '$this->refCompra';";
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
            $query .= " WHERE refCompra = '" . self::$db->escape_string($this->refCompra) . "'";
            $query .= " LIMIT 1";

            return self::$db->query($query);
        }

        public static function find($id) {
            if (!$id) {
                return null; 
            }
        
            try {
                $query = "SELECT * FROM " . static::$tabla . " WHERE refCompra = '{$id}'"; 
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
        
        public static function contarPedido() {
            $query = "SELECT COUNT(*) as total FROM pedido";
            $resultado = self::$db->query($query);
            $fila = $resultado->fetch_assoc();
            return $fila['total'];
        }

        public static function obtenerPedidoPorPagina($limit, $offset) {
            $query = "SELECT * FROM pedido LIMIT {$limit} OFFSET {$offset}";
            return self::consultarSQL($query);
        }

        public static function obtenerPedidoPorPaginaUsuario($limit, $offset, $id) {
            $query = "SELECT * FROM pedido where hash_comprador = '$id' or hash_vendedor = '$id' LIMIT {$limit} OFFSET {$offset};";
            return self::consultarSQL($query);
        }

        public function noExistePedido() {
            $query = "SELECT * FROM " . self::$tabla . " WHERE refCompra = '{$this->refCompra}';";
            $resultado = self::$db->query($query);
            if($resultado->num_rows) {
                self::$errores[] = 'El Pedido Ya Existe';
                return false;
            }
            return true;
        }
        public static function actualizarDistribucion($valor, $refCompra){
            $query = "UPDATE pedido SET distribuidor = $valor where refCompra = '$refCompra'";
            return self::$db->query($query);
        }
    }
