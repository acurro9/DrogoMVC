<?php

namespace Model;

class Newsletter extends ActiveRecord {

    protected static $tabla = 'newsletter';
    protected static $columnasDB = ['email'];

    public $email;

    public function __construct($email) {
        $this->email= $email ?? '';
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
    public function validar(){
        if(!$this->email) {
            self::$errores[] = "Debes indicar un correo electrónico";
        }
        return self::$errores;
    }
}