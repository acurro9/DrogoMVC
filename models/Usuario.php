<?php

namespace Model;

class Usuario extends ActiveRecord {
   
    // Base DE DATOS
    protected static $tabla = 'usuario';
    protected static $columnasDB = ['id', 'username', 'email', 'password_hash', 'tipo'];

    //Declaración de atributos para usuario
    public $id;
    public $username;
    public $email;
    public $password_hash;
    public $tipo;
    public $passwordPlano;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->username = $args['username'] ?? null;
        $this->email = $args['email'] ?? null;
        $this->password_hash = $args['password_hash'] ?? '';
        $this->tipo = $args['tipo']??'';
        $this->passwordPlano = $args['passwordPlano']??'';
    }
    //Para el bloquearUsuario
    public static function verificarPermisos() {
        session_start();
        $auth = $_SESSION['login'] ?? false;
        if (!$auth) {
            header('Location: /');
            exit;
        }
    }
    public static function verificarPermisosAdmin() {
        session_start();
        $auth = $_SESSION['login'] ?? false;
        if (!$auth || $_SESSION['tipo'] != 'Administrador') {
            header('Location: /');
            exit;
        }
    }

    public function validarLogin() {
        // Si no se ha proporcionado ni un nombre de usuario ni un correo electrónico
        if (!$this->username && !$this->email) {
            self::$errores[] = "El nombre de usuario o email es obligatorio";
        }
        if (!$_POST['password']) {
            self::$errores[] = "El password del usuario es obligatorio";
        }
        return self::$errores;
    }
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

    public function validacionError($errores){
        $_SESSION['errores']=$errores;
        header("Location: /modDatos");
        exit;
    }

    public function validacionExito($codigo){
        $mensaje=$this->mssgExito($codigo);
        $_SESSION['mensaje_exito']=$mensaje;
        if ($this->tipo === 'Administrador') {
            header("Location: /usuario");
        } else {
            header("Location: /areaPersonal");
        }
        exit;
    }


    
    public static function buscarID($usuario){
        $query = "SELECT * FROM " . self::$tabla . " WHERE username = '$usuario';";
        $resultado = self::$db->query($query);
        if ($resultado){
            $id=$resultado->fetch_assoc();
            $dev=$id['id'];
            return $dev;
        }
    }
    public function existeUsuario() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE username = '{$this->username}' OR email = '{$this->email}';";
        $resultado = self::$db->query($query);
        if(!$resultado->num_rows) {
            self::$errores[] = 'El Usuario No Existe';
            return false;
        }
        return $resultado;
    }
    public function noExisteUsuario() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE username = '{$this->username}' OR email = '{$this->email}';";
        
        $resultado = self::$db->query($query);
        if($resultado->num_rows) {
            self::$errores[] = 'El Usuario Ya Existe';
            return false;
        }
        return true;
    }

    //Para evitar que, al modificar los datos, el usuario introduzca el nombre o email de otro usuario, así se evitan duplicidades

    public function noExisteUsuarioDatos($idActual = null){
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
        if ($resultado->num_rows) {
            self::$errores[] = 'El nombre de usuario o email ya está en uso';
            return false;
        }
        return true;
        }
    


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
    
    //La función estarAutenticado ahora pertenece a usuario 
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

    public function hashPass(){
        // Hashear la contraseña antes de guardar
        $this->password_hash = password_hash($this->password_hash, PASSWORD_DEFAULT);

    }

    // Método para contar el total de usuarios
    public static function contarUsuarios() {
        $query = "SELECT COUNT(*) as total FROM usuario";
        $resultado = self::$db->query($query);
        $fila = $resultado->fetch_assoc();
        return $fila['total'];
    }

    // Método para obtener usuarios con paginación
    public static function obtenerUsuariosPorPagina($limit, $offset) {
        $query = "SELECT * FROM usuario LIMIT {$limit} OFFSET {$offset}";
        return self::consultarSQL($query);
    }
    
    public function crear() {
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
    }    
    
    
    public function actualizar() {
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
    public function actualizarCartera($id, $tipo, $cartera){
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
    }

    public function actualizarCartera2($cartera){
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

    }


    public static function bloquear($idUsuario, $username, $email) {
        $query = "INSERT INTO bloqueado (id, username, email) VALUES ('$idUsuario', '$username', '$email')";
        return self::$db->query($query);
    }

    public static function desbloquear($username) {
        $query = "DELETE FROM bloqueado WHERE username = '$username'";
        return self::$db->query($query);
    }

    // Método para buscar usuario por criterios
    public static function buscarPorCriterios($username, $email, $id) {
        $query = "SELECT id, username, email FROM usuario WHERE username LIKE '$username' OR email LIKE '$email' OR id LIKE '$id'";
        $resultado = self::consultarSQL($query);
        return $resultado ? array_shift($resultado) : null;
    }

    // Métodos para comprobar si un usuario está bloqueado
    public static function obtenerUsuariosBloqueados() {
        $query = "SELECT id FROM bloqueado";
        $resultado = self::$db->query($query);
        $usuariosBloqueados = [];
        while ($fila = $resultado->fetch_assoc()) {
            $usuariosBloqueados[] = $fila['id'];
        }
        return $usuariosBloqueados;
    }

    public static function userBloq($username) {
        $query = "SELECT username FROM bloqueado WHERE username = '$username'";
        $resultado = self::$db->query($query);
        if($resultado && $resultado->num_rows > 0){
            self::$errores[] = 'El Usuario está bloqueado';
            return true;
        }
    }
    public function eliminar() {
        $idValue = self::$db->escape_string($this->id);
        $query = "DELETE FROM " . static::$tabla . " WHERE id = '{$idValue}';";
        $resultado = self::$db->query($query);
        
        return $resultado;
    }
    public static function find($id) {

        try {
            $query = "SELECT * FROM " . static::$tabla . " WHERE id = '{$id}'"; 
            $resultado = self::consultarSQL($query);
    
            if ($resultado === false || empty($resultado)) {
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
    public static function obtenerNombres(){
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
    }
}