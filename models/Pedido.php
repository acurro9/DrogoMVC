<?php
    namespace Model;
    use Exception;

    /**
     * Clase Pedido para gestionar los pedidos en la base de datos.
     *
     * Esta clase proporciona funcionalidades para crear, actualizar, validar,
     * contar, y obtener pedidos, así como para verificar la existencia de pedidos
     * y manejar mensajes de éxito y errores de validación.
     */

    class Pedido extends ActiveRecord{

          /**
         * @var string Nombre de la tabla en la base de datos.
         */
        protected static $tabla = 'pedido';

         /**
         * @var array Columnas de la base de datos utilizadas por la clase.
         */
        protected static $columnasDB = ['refCompra', 'hash_comprador', 'hash_vendedor', 'fechaCompra', 'importe', 'cargoTransporte', 'cargosAdicionales', 'fechaDeposito', 'fechaRecogida', 'refLocker', 'distribuidor'];

        /**
         * @var string referencia de compra
         */
        public $refCompra;

        /**
         * @var string hash del comprador
         */
        
         public $hash_comprador;
        /**
         * @var string hash del vendedor
         */
        public $hash_vendedor;

        /**
         * @var mixed fecha de compra
         */
        public $fechaCompra;
        /**
         * @var float importe de la compra
         */
        public $importe;

        /**
         * @var float cargos de transporte
         */
        public $cargoTransporte;
        /**
         * @var float cargos adicionales
         */
        public $cargosAdicionales;

        /**
         * @var mixed fecha de depósito
         */
        public $fechaDeposito;

        /**
         * @var mixed fecha de recogida
         */
        public $fechaRecogida;

        /**
         * @var string referencia del lockere
         */
        public $refLocker;

        /**
         * @var bool indica si el pedido requiere de distribuidor
         */
        public $distribuidor;

        /**
         * Constructor de la clase Pedido.
         *
         * @param array $args Argumentos para inicializar un objeto Pedido.
         */

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


        /**
         * Valida los campos necesarios del pedido.
         *
         * @return array Retorna un array de errores si los hay.
         */

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

        /**
         * Crea un nuevo pedido en la base de datos.
         *
         * @return bool Retorna true si el pedido es creado con éxito, false en caso contrario.
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
         * Elimina un pedido de la base de datos por su referencia de compra.
         *
         * @return bool Retorna true si el pedido es eliminado con éxito, false en caso contrario.
         */

        public function eliminar(){
            try{
                $query = "DELETE FROM " . static::$tabla . " WHERE refCompra = '$this->refCompra';";
                $resultado = self::$db->query($query);

                return $resultado;
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
                return false;
            }
        }


        /**
         * Actualiza un pedido existente en la base de datos.
         *
         * @return bool Retorna true si el pedido es actualizado con éxito, false en caso contrario.
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
                $query .= " WHERE refCompra = '" . $this->refCompra . "'";
                $query .= " LIMIT 1";

                return self::$db->query($query);
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
                return false;
            }
        }

        /**
         * Encuentra un pedido por su referencia de compra.
         *
         * @param string $id Referencia de compra del pedido a buscar.
         * @return Pedido|null Retorna un objeto Pedido si se encuentra, null en caso contrario.
         */

        public static function find($id) {
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
         * Cuenta el total de pedidos registrados en la base de datos.
         *
         * @return int Retorna el número total de pedidos.
         */
            
        public static function contarPedido() {
            try{
                $query = "SELECT COUNT(*) as total FROM pedido";
                $resultado = self::$db->query($query);
                $fila = $resultado->fetch();
                return $fila['total'];
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
                return -1;
            }
        }

        /**
         * Obtiene un conjunto de pedidos por página.
         *
         * @param int $limit Número de pedidos por página.
         * @param int $offset Número de pedidos a saltar.
         * @return array Retorna un array de objetos Pedido.
         */

        public static function obtenerPedidoPorPagina($limit, $offset) {
            try{
                $query = "SELECT * FROM pedido LIMIT {$limit} OFFSET {$offset}";
            return self::consultarSQL($query);
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
                return [];
            }
        }

        /**
         * Obtiene un conjunto de pedidos por página para un usuario específico, ya sea como comprador o vendedor.
         *
         * @param int $limit Número de pedidos por página.
         * @param int $offset Número de pedidos a saltar.
         * @param string $id Hash del comprador o vendedor.
         * @return array Retorna un array de objetos Pedido.
         */
        public static function obtenerPedidoPorPaginaUsuario($limit, $offset, $id) {
            try{
                $query = "SELECT * FROM pedido where hash_comprador = '$id' or hash_vendedor = '$id' LIMIT {$limit} OFFSET {$offset};";
                return self::consultarSQL($query);
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
                return [];
            }
        }

        /**
         * Verifica si un pedido ya existe en la base de datos.
         *
         * @return bool Retorna true si el pedido no existe, false si ya existe.
         */

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
                return false;
            }
        }

        /**
         * Actualiza la información de distribución de un pedido.
         *
         * @param mixed $valor Nuevo valor para el campo de distribución.
         * @param string $refCompra Referencia de compra del pedido a actualizar.
         * @return bool Retorna true si la actualización es exitosa, false en caso contrario.
         */
        public static function actualizarDistribucion($valor, $refCompra){
            try{
                $query = "UPDATE pedido SET distribuidor = $valor where refCompra = '$refCompra'";
                return self::$db->query($query);
            }catch(Exception $e){
                echo 'Error: ', $e->getMessage(), "\n";
                return false;
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

         /**
         * Maneja la validación y redirección tras una operación exitosa.
         *
         * @param int $codigo Código que representa el tipo de operación realizada.
         */

        public function validacionExito($codigo){
            $mensaje=$this->mssgExito($codigo);
            $_SESSION['mensaje_exito']=$mensaje;
            header("Location: /pedidos");
        }

         /**
         * Valida los datos proporcionados para la actualización de un pedido.
         *
         * @param array $data Datos del pedido a validar.
         * @return array Retorna un array de errores si los hay.
         */

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

    
