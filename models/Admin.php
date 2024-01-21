<?php

namespace Model;

class Admin extends ActiveRecord{
   
    // Base DE DATOS
    protected static $tabla = 'usuario';
    protected static $columnasDB = ['id', 'email', 'password_hash'];
    public $id;
    public $email;
    public $password;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar() {
        if(!$this->email) {
            self::$errores[] = "El usuario es obligatorio";
        }
        if(!$this->password) {
            self::$errores[] = "El Password del usuario es obligatorio";
        }
        return self::$errores;
    }

    public function existeUsuario() {
        // Revisar si el usuario existe.
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);

        if(!$resultado->num_rows) {
            self::$errores[] = 'El Usuario No Existe';
            return;
        }

        return $resultado;
    }

    public function comprobarPassword($resultado) {
        $usuario = $resultado->fetch_object();

        $this->autenticado = password_verify( $this->password, $usuario->password );

        if(!$this->autenticado) {
            self::$errores[] = 'El Password es Incorrecto';
            return;
        } 
    }

    public function autenticar() {
         // El usuario esta autenticado
         session_start();

        // Llenar el arreglo de la sesión
        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;
        $_SESSION[''] = $this->tipo;
        $_SESSION["id"]=$this->id;
        $_SESSION["contraseña"]=$this->password_hash;

         header('Location: /admin');
    }

}