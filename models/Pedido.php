<?php
    namespace Model;
    use Exception;

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
                $idValue = $this->refCompra;
                $query = "DELETE FROM " . static::$tabla . " WHERE refCompra = '$this->refCompra';";
                $resultado = self::$db->query($query);

                return $resultado;
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
            }
        }

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
                $query .= " WHERE refCompra = '" . $this->refCompra . "'";
                $query .= " LIMIT 1";

                return self::$db->query($query);
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
            }
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
            try{
                $query = "SELECT COUNT(*) as total FROM pedido";
                $resultado = self::$db->query($query);
                $fila = $resultado->fetch();
                return $fila['total'];
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
            }
        }

        public static function obtenerPedidoPorPagina($limit, $offset) {
            try{
                $query = "SELECT * FROM pedido LIMIT {$limit} OFFSET {$offset}";
            return self::consultarSQL($query);
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
            }
        }

        public static function obtenerPedidoPorPaginaUsuario($limit, $offset, $id) {
            try{
                $query = "SELECT * FROM pedido where hash_comprador = '$id' or hash_vendedor = '$id' LIMIT {$limit} OFFSET {$offset};";
                return self::consultarSQL($query);
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
            }
        }

        public function noExistePedido() {
            try{
                $query = "SELECT * FROM " . self::$tabla . " WHERE refCompra = '{$this->refCompra}';";
                $resultado = self::$db->query($query);
                if($resultado->rowCount()) {
                    self::$errores[] = 'El Pedido Ya Existe';
                    return false;
                }
                return true;
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
            }
        }
        public static function actualizarDistribucion($valor, $refCompra){
            try{
                $query = "UPDATE pedido SET distribuidor = $valor where refCompra = '$refCompra'";
                return self::$db->query($query);
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
            }
        }

        public static function mssgExito($codigo){
           switch($codigo){
            case 1: 
                $mensaje="Pedido creado con éxito";
                break;
            case 2:
                $mensaje="Pedido actualizado con éxito";
                break;
            case 3:
                $mensaje="Pedido eliminado con éxito";
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
            header("Location: /pedidos");
        }

        public function erroresActualizacionPedido($data){
            //Reinicio del arreglo de errores, just in case
            self::$errores=[];
    
            //Validar que se haya seleccionado un comprador (por ID, aunque el usuario vea el nombre de usuario
            if(empty($data['hash_comprador'])){
                self::$errores[]="Debe seleccionar un comprador";
            }

            //Validar que se haya seleccionado un vendedor (por ID, aunque el usuario vea el nombre de usuario
            if(empty($data['hash_vendedor'])){
                self::$errores[]="Debe seleccionar un vendedor";
            }
    
            //Validacion de locker
            if(empty($data['refLocker'])){
                self::$errores[]="Debe seleccionar un locker";
            }
    
            //Validación del importe
            if(empty($data['importe'])){
                self::$errores[]="El importe es obligatorio";
            }elseif(!is_numeric($data['importe'])){
                self::$errores[]="El importe debe ser una cantidad numérica válida";
            }

            
            //Validación del cargo de transporte
            if(empty($data['cargoTransporte'])){
                self::$errores[]="El cargo de transporte es obligatorio";
            }elseif(!is_numeric($data['cargoTransporte'])){
                self::$errores[]="El cargo de transporte debe ser una cantidad numérica válida";
            }

            //Validación de los cargos adicionales
            if(empty($data['cargosAdicionales'])){
                self::$errores[]="Los cargos adicionales son obligatorios";
            }elseif(!is_numeric($data['cargosAdicionales'])){
                self::$errores[]="Los cargos adicionales deben ser una cantidad numérica válida";
            }

            //Validación de la fecha de depósito
            if(empty($data['fechaDeposito'])){
                self::$errores[]="La fecha de depósito es obligatoria";
            }

            //Validación de la fecha de recogida
            if(empty($data['fechaRecogida'])){
                self::$errores[]="La fecha de recogida es obligatoria";
            }
    
            //Devuelve el arreglo de errores
            return self::$errores;    
        }
    }

    
