<?php

namespace Model;
use Exception;

/**
 * Clase Usuario para la gestión de usuarios en la base de datos.
 *
 * Proporciona funcionalidades para crear, actualizar, validar, y eliminar usuarios,
 * así como métodos para la autenticación, bloqueo/desbloqueo, y otras operaciones relacionadas.
 */

class Usuario extends ActiveRecord {
   
     /**
     * @var string Nombre de la tabla en la base de datos.
     */
    protected static $tabla = 'usuario';

    /**
     * @var array Columnas de la base de datos utilizadas por la clase.
     */
    protected static $columnasDB = ['id', 'username', 'email', 'password_hash', 'tipo'];

    //Declaración de atributos para usuario
    public $id;
    public $username;
    public $email;
    public $password_hash;
    public $tipo;
    public $passwordPlano;

    /**
     * Constructor de la clase Usuario.
     *
     * @param array $args Argumentos para inicializar un objeto Usuario.
     */

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->username = $args['username'] ?? null;
        $this->email = $args['email'] ?? null;
        $this->password_hash = $args['password_hash'] ?? '';
        $this->tipo = $args['tipo']??'';
        $this->passwordPlano = $args['passwordPlano']??'';
    }

    /**
     * Verifica los permisos del usuario para acceder a ciertas áreas.
     */
    //Para el bloquearUsuario
    public static function verificarPermisos() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        $auth = $_SESSION['login'] ?? false;
        if (!$auth) {
            header('Location: /');
            exit;
        }
    }

    /**
     * Verifica que el usuario tenga permisos de administrador.
     */
    public static function verificarPermisosAdmin() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $auth = $_SESSION['login'] ?? false;
        if (!$auth || $_SESSION['tipo'] != 'Administrador') {
            header('Location: /');
            exit;
        }
    }

    
    /**
     * Valida los campos necesarios para el login de un usuario.
     *
     * @return array Retorna un array de errores si los hay.
     */

    public function validarLogin() {
        if (!$this->username && !$this->email) {
            self::$errores[] = "El nombre de usuario o email es obligatorio";
        }
        if (!$_POST['password']) {
            self::$errores[] = "El password del usuario es obligatorio";
        }
        return self::$errores;
    }

    /**
     * Valida los campos necesarios para el registro de un usuario.
     *
     * @return array Retorna un array de errores si los hay.
     */
    public function validarRegistro() {
        if(!$this->username){
            self::$errores[] = "El nombre de usuario es obligatorio";
        }
        if(!$this->email) {
            self::$errores[] = "El email del usuario es obligatorio";
        }
        if(!$this->password_hash) {
            self::$errores[] = "El password del usuario es obligatorio";
        }
        if(!$this->passwordPlano) {
            self::$errores[] = "Debe repetir el password";
        }
        if(!$this->tipo) {
            self::$errores[] = "Elija un tipo de usuario";
        }
        if($this->password_hash!=$this->passwordPlano) {
            self::$errores[] = "Los passwords deben coincidir";
        }
        return self::$errores;
    }

    /**
     * Genera un mensaje de éxito basado en un código proporcionado.
     *
     * @param int $codigo Código que representa el tipo de operación realizada.
     * @return string Retorna un mensaje de éxito personalizado.
     */

    public function mssgExito($codigo){
        switch($codigo){
            case 1:
                return "Usuario bloqueado con éxito";
            case 2: 
                return "Usuario desbloqueado con éxito";
            case 3: 
                return "Usuario actualizado con éxito";
            case 4:
                return "Nombre actualizado con éxito";
            case 5:   
                return "Email actualizado con éxito";
            case 6: 
                return "Contraseña actualizada con exito";
            case 7: 
                return "Cartera actualizada con exito";
            default:    
                return "Operación realizada con éxito";
        }
    }

    /**
     * Redirige a la página de actualizar datos con los errores de validación.
     *
     * @param array $errores Errores de validación.
     */
    public function validacionError($errores){
        $_SESSION['errores']=$errores;
        header("Location: /modDatos");
        exit;
    }

    /**
     * Redirige a la página correspondiente tras una operación exitosa.
     *
     * @param int $codigo Código que representa el tipo de operación realizada.
     */

    public function validacionExito($codigo){
        $mensaje=$this->mssgExito($codigo);
        $_SESSION['mensaje_exito']=$mensaje;
        if ($_SESSION['tipo'] === 'Administrador') {
            header("Location: /usuario");
        } else {
            header("Location: /areaPersonal");
        }
        exit;
    }


    /**
     * Busca un usuario por su nombre de usuario.
     *
     * @param string $usuario Nombre de usuario a buscar.
     * @return mixed Devuelve el ID del usuario si se encuentra, de lo contrario retorna null.
     * @throws Exception Si ocurre un error durante la consulta.
     */
    
    public static function buscarID($usuario){
        try{
            $query = "SELECT * FROM " . self::$tabla . " WHERE username = '$usuario';";
            $resultado = self::$db->query($query);
            if ($resultado){
                $id=$resultado->fetch();
                $dev=$id['id'];
                return $dev;
            }  
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return null;
        }
    }


    /**
     * Verifica si un usuario ya existe en la base de datos por su nombre de usuario o email.
     *
     * @return bool Retorna true si el usuario no existe, false si ya existe.
     * @throws Exception Si ocurre un error durante la consulta.
     */
    public function existeUsuario() {
        try{
            $query = "SELECT * FROM " . self::$tabla . " WHERE username = '{$this->username}' OR email = '{$this->email}';";
            $resultado = self::$db->query($query);
            if(!$resultado->rowCount()) {
                self::$errores[] = 'El Usuario No Existe';
                return false;
            }
            return $resultado;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return false;
        }
    }

    /**
     * Verifica si un usuario ya existe en la base de datos por su nombre de usuario o email.
     *
     * @return bool Retorna true si el usuario no existe, false si ya existe.
     * @throws Exception Si ocurre un error durante la consulta.
     */
    public function noExisteUsuario() {
        try{
            $query = "SELECT * FROM " . self::$tabla . " WHERE username = '{$this->username}' OR email = '{$this->email}';";
        
            $resultado = self::$db->query($query);
            if($resultado->rowCount()) {
                self::$errores[] = 'El Usuario Ya Existe';
                return false;
            }
            return true;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return false;
        }
    }

    //Para evitar que, al modificar los datos, el usuario introduzca el nombre o email de otro usuario, así se evitan duplicidades

    public function noExisteUsuarioDatos($idActual = null){
        try{
            $condiciones = [];
            if (!empty($this->username)) {
                $condiciones[] = "username = '{$this->username}'";
            }
            if (!empty($this->email)) {
                $condiciones[] = "email = '{$this->email}'";
            }
            if (empty($condiciones)) {
                // No hay suficiente información para hacer una consulta
                return true;
            }
            //Para no contar al usuario actual como duplicado, que es lo que lleva dando problemas todo el tiempo
            $query = "SELECT * FROM " . self::$tabla . " WHERE (" . implode(' OR ', $condiciones) . ")";
            if ($idActual !== null) {
                $query .= " AND id != '{$idActual}'";
            }
        
            $resultado = self::$db->query($query);
            if ($resultado->rowCount()) {
                self::$errores[] = 'El nombre de usuario o email ya está en uso';
                return false;
            }
            return true;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
        }
    }
    
    /**
     * Comprueba si la contraseña proporcionada coincide con la almacenada en la base de datos.
     *
     * @param Usuario $usuario Usuario a autenticar.
     * @return bool Retorna true si la contraseña coincide, false en caso contrario.
     */

    public function comprobarPassword($usuario) {
        if (!$usuario) {
            self::$errores[] = 'El Usuario No Existe';
            return false;
        }
        $autenticado = password_verify($_POST['password'], $usuario->password_hash);
        // Resto del código...
        if(!$autenticado) {
            self::$errores[] = 'El Password es Incorrecto';
            return false;
        } else{               
            return true;       
        }
    }
    
   /**
     * Autentica a un usuario, iniciando su sesión.
     */
    public function autenticar() {
         // El usuario esta autenticado
         session_start();

         // Se Llena el arreglo de la sesión
         $_SESSION['usuario'] = $this->username;
         $_SESSION['login'] = true;
         $_SESSION['tipo'] = $this->tipo;
         $_SESSION['id'] = $this->id; 
    
        // Redirige al área personal
        header('Location: /areaPersonal');
        exit;
    }

    /**
     * Hashea la contraseña del usuario.
     */
    public function hashPass(){
        // Hashear la contraseña antes de guardar
        $this->password_hash = password_hash($this->password_hash, PASSWORD_DEFAULT);

    }

     /**
     * Cuenta el total de usuarios registrados en la base de datos.
     *
     * @return int Retorna el número total de usuarios.
     * @throws Exception Si ocurre un error durante la consulta.
     */
    
    public static function contarUsuarios() {
        try{
            $query = "SELECT COUNT(*) as total FROM usuario";
            $resultado = self::$db->query($query);
            $fila = $resultado->fetch();
            return $fila['total'];
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return -1;
        }
        
    }

    /**
     * Obtiene un conjunto de usuarios por página.
     *
     * @param int $limit Número de usuarios por página.
     * @param int $offset Número de usuarios a saltar.
     * @return array Retorna un array de objetos Usuario.
     */
    public static function obtenerUsuariosPorPagina($limit, $offset) {
        try{
            $query = "SELECT * FROM usuario LIMIT {$limit} OFFSET {$offset}";
            return self::consultarSQL($query);
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return [];
        }
        
    }

    /**
     * Crea un nuevo usuario en la base de datos.
     * 
     * @return bool Retorna true si el usuario es creado con éxito, false en caso contrario.
     * @throws Exception Si ocurre un error durante la ejecución.
     */
    
    public function crear() {
        try{
           // Sanitizar los datos
            $atributos = $this->sanitizarAtributos();
        
            $id =  md5(uniqid(rand(), true));
        
            // Para meterle la id
            $query = "INSERT INTO " . static::$tabla . " (";
            $query .= join(', ', array_keys($atributos));
            $query .= ") VALUES ('$id";
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
     * Actualiza la información de un usuario existente en la base de datos.
     * 
     * @return bool Retorna true si la actualización es exitosa, false en caso contrario.
     * @throws Exception Si ocurre un error durante la ejecución.
     */
    public function actualizar() {
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
     * Actualiza la cartera del usuario especificando el tipo de usuario (Comprador, Vendedor, Distribuidor).
     * 
     * @param mixed $id Identificador del usuario.
     * @param int $tipo Tipo de usuario (1 para Comprador, 2 para Vendedor, 3 para Distribuidor).
     * @param string $cartera Valor de la cartera a actualizar.
     * @return bool Retorna true si la actualización es exitosa, false en caso contrario.
     * @throws Exception Si ocurre un error durante la ejecución.
     */
    public function actualizarCartera($id, $tipo, $cartera){
        try{
            if (!$id) {
                self::$errores[] = "Error: Usuario no identificado.";
                return false;
            }
            if($tipo===1){
                $tabla="Comprador";
                $hash="hash_comprador";
                $hashCartera="hash_carteraComprador";
            } else if($tipo===2){
                $tabla="Vendedor";
                $hash="hash_vendedor";
                $hashCartera="hash_carteraVendedor";
            } else if($tipo===3){
                $tabla="Distribuidor";
                $hash="hash_distribuidor";
                $hashCartera="hash_carteraDistribuidor";
            }
            // Se hashea la cartera
            $cart=password_hash($cartera, PASSWORD_DEFAULT);
            // Se inserta la cartera en la tabla del usuario
            $query = "INSERT INTO $tabla ($hash, $hashCartera) values ('$id', '$cart');";
    
            $resultado = self::$db->query($query);
            return $resultado;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return false;
        }
    }

     /**
     * Actualiza la cartera del usuario actual basado en el tipo de usuario.
     * 
     * @param string $cartera Nuevo valor de la cartera a actualizar.
     * @return bool Retorna true si la actualización es exitosa, false en caso contrario.
     * @throws Exception Si ocurre un error durante la ejecución.
     */

    public function actualizarCartera2($cartera){
        try{
            if (!$this->id) {
                self::$errores[] = "Error: Usuario no identificado.";
                return false;
            }
            $id=$this->id;
            $tipo=$this->tipo;
    
            if($tipo==='Comprador'){
                $tabla="comprador";
                $hash="hash_comprador";
                $hashCartera="hash_carteraComprador";
            } else if($tipo==='Vendedor'){
                $tabla="vendedor";
                $hash="hash_vendedor";
                $hashCartera="hash_carteraVendedor";
            } else if($tipo==='Distribuidor'){
                $tabla="distribuidor";
                $hash="hash_distribuidor";
                $hashCartera="hash_carteraDistribuidor";
            }
            // Se hashea la cartera
            $cart=password_hash($cartera, PASSWORD_DEFAULT);
            // Se inserta la cartera en la tabla del usuario
            $query = "UPDATE $tabla SET $hashCartera = '$cart' where $hash = '$id'";
    
            $resultado = self::$db->query($query);
            return $resultado; 
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return false;
        }
    }

    
    /**
     * Bloquea un usuario, agregándolo a la tabla de usuarios bloqueados.
     * 
     * @param string $idUsuario Identificador del usuario a bloquear.
     * @param string $username Nombre de usuario.
     * @param string $email Correo electrónico del usuario.
     * @return bool Retorna true si el usuario es bloqueado con éxito, false en caso contrario.
     * @throws Exception Si ocurre un error durante la ejecución.
     */


    public static function bloquear($idUsuario, $username, $email) {
        try{
            $query = "INSERT INTO bloqueado (id, username, email) VALUES ('$idUsuario', '$username', '$email')";
            return self::$db->query($query);
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return false;
        }
       
    }

     /**
     * Desbloquea un usuario, eliminándolo de la tabla de usuarios bloqueados.
     * 
     * @param string $username Nombre de usuario a desbloquear.
     * @return bool Retorna true si el usuario es desbloqueado con éxito, false en caso contrario.
     * @throws Exception Si ocurre un error durante la ejecución.
     */

    public static function desbloquear($username) {
        try{
            $query = "DELETE FROM bloqueado WHERE username = '$username'";
            return self::$db->query($query);
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return false;
        }
        
    }

    /**
     * Busca usuarios por criterios específicos como el nombre de usuario, email o ID.
     * 
     * @param string $username Nombre de usuario.
     * @param string $email Correo electrónico.
     * @param mixed $id Identificador del usuario.
     * @return array|null Retorna un array con el usuario encontrado o null si no se encuentra.
     * @throws Exception Si ocurre un error durante la ejecución.
     */
    public static function buscarPorCriterios($username, $email, $id) {
        try{
            $query = "SELECT id, username, email FROM usuario WHERE username LIKE '$username' OR email LIKE '$email' OR id LIKE '$id'";
            $resultado = self::consultarSQL($query);
            return $resultado ? array_shift($resultado) : null;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return [];
        }
    }

    /**
     * Obtiene la lista de usuarios bloqueados.
     * 
     * @return array Retorna un array con los IDs de los usuarios bloqueados.
     * @throws Exception Si ocurre un error durante la ejecución.
     */
    public static function obtenerUsuariosBloqueados() {
        try{
            $query = "SELECT id FROM bloqueado";
            $resultado = self::$db->query($query);
            $usuariosBloqueados = [];
            while ($fila = $resultado->fetch()) {
                $usuariosBloqueados[] = $fila['id'];
            }
            return $usuariosBloqueados;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return [];
        }
        
    }

    /**
     * Verifica si un usuario está bloqueado.
     * 
     * @param string $username Nombre de usuario a verificar.
     * @return bool Retorna true si el usuario está bloqueado, false en caso contrario.
     * @throws Exception Si ocurre un error durante la ejecución.
     */

    public static function userBloq($username) {
            $query = "SELECT username FROM bloqueado WHERE username = '$username'";
            $resultado = self::$db->query($query);
            if($resultado && $resultado->rowCount() > 0){
                self::$errores[] = 'El Usuario está bloqueado';
                return true;
            }else{
                return false;
            }
        }
        
    


     /**
     * Elimina un usuario de la base de datos por su ID.
     *
     * @return bool Retorna true si el usuario es eliminado con éxito, false en caso contrario.
     * @throws Exception Si ocurre un error durante la consulta.
     */
    public function eliminar() {
        try{
            $idValue = $this->id;
            $query = "DELETE FROM " . static::$tabla . " WHERE id = '{$idValue}';";
            $resultado = self::$db->query($query);
            
            return $resultado;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return false;
        }
       
    }

    /**
     * Encuentra un usuario por su ID.
     * 
     * Busca en la base de datos un usuario que coincida con el ID proporcionado.
     * 
     * @param mixed $id ID del usuario a buscar.
     * @return Usuario|null Retorna un objeto Usuario si se encuentra, null en caso contrario.
     * @throws Exception Si ocurre un error durante la consulta.
     */

    public static function find($id) {

        try {
            $query = "SELECT * FROM " . static::$tabla . " WHERE id = '{$id}'"; 
            $resultado = self::consultarSQL($query);
    
            if ($resultado === false || empty($resultado)) {

                return null;
            }
            return array_shift($resultado);
        } catch (Exception $e) {
            error_log('Excepción capturada en find: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtiene los nombres y IDs de todos los usuarios.
     * 
     * Realiza una consulta a la base de datos para obtener el ID y el nombre de usuario
     * de todos los usuarios registrados.
     * 
     * @return array Retorna un array con el ID y el nombre de usuario de todos los usuarios.
     * @throws Exception Si ocurre un error durante la consulta.
     */
    public static function obtenerNombres(){
        try{
            self::contarUsuarios();
            $query = "SELECT id, username FROM usuario";
            $usuarios = self::$db->query($query);
            $cont=0;
            foreach ($usuarios as $usuario) {
                $nombre[$cont][0]=$usuario['id'];
                $nombre[$cont][1]=$usuario['username'];
                $cont++;
            }
            return $nombre;
        }catch(Exception $e){
            echo 'Error: ', $e->getMessage(), "\n";
            return [];
        }
        
    }

      /**
     * Valida los datos proporcionados para la actualización de un usuario.
     * 
     * Verifica que los campos necesarios para actualizar un usuario estén presentes y sean válidos.
     * 
     * @param array $data Datos del usuario a validar.
     * @return array Retorna un array de errores si los hay.
     */

    public function erroresActualizacion($data){
        //Reinicio del arreglo de errores, just in case
        self::$errores=[];

        //Validar que el nombre de usuario no esté empty
        if(empty($data['username'])){
            self::$errores[]="El nombre de usuario es obligatorio";
        }

        //Validar que el email no esté vacío y sea válido
        if(empty($data['email'])){
            self::$errores[]="El email del usuario no es obligatorio";
        }elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            self::$errores[]="El email no es válido";
        }

        //Solo se vlaida la contraseña en caso de que se haya proporcionado una nueva
        if(empty($data['password'])){
            self::$errores[]="El password no debe quedar vacío";
        }

        //Se valida la contraseña si se proporciona una nueva
        if(empty($data['tipo'])){
            self::$errores[]="Elija un tipo de usuario";
        }

        //Retorna el arreglo de errores
        return self::$errores;    
    }

    public static function obtenerUsuariosAjax($param){
        // $query = "SELECT * FROM " . static::$tabla . " WHERE username like '%{$param}%' or email like '%{$param}%' EXCEPT
        // SELECT * FROM usuario WHERE username = 'admin';";
        $query = "SELECT * FROM " . static::$tabla . " WHERE username like '{$param}%' or email like '{$param}%' EXCEPT
        SELECT * FROM usuario WHERE username = 'admin';";
        return self::consultarSQL($query);
    }
}