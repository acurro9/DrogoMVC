<?php

namespace Model;

class Locker extends ActiveRecord {
    public $refLocker;
    public $direccion;
    public $passwordLocker;

    public function __construct($args=[]) {
        $this->refLocker = $args['refLocker'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->passwordLocker = $args['passwordLocker'] ?? '';
    }

    public function validar(){
        if(!$this->refLocker){
            self::$errores[] = "Es obligatorio poner la referencia";
        }
        if(!$this->direccion) {
            self::$errores[] = "Es obligatorio poner la dirección";
        }
        if(!$this->passwordLocker) {
            self::$errores[] = "Es obligatorio poner un password";
        }
        return self::$errores;
    }

    public function recogerID(){
        return self::$db->escape_string($this->refLocker);
    }

    public static function contarLockers() {
        $query = "SELECT COUNT() as total FROM locker";
        $resultado = self::$db->query($query);
        $fila = $resultado->fetch_assoc();
        return $fila['total'];
    }

    // Método para obtener usuarios con paginación
    public static function obtenerLockersPorPagina($limit, $offset) {
        $query = "SELECT FROM locker LIMIT {$limit} OFFSET {$offset}";
        return self::consultarSQL($query);
    }

    public function eliminar(){
        $idValue = self::$db->escape_string($this->id);
        $query = "DELETE FROM " . static::$tabla . " WHERE id = '{$idValue}';";
        $resultado = self::$db->query($query);

        return $resultado;
    }
}