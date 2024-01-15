<?php 
    //Se realiza la conexión a la base de datos
function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', '', 'drogoDB');

    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    } 

    return $db;
    
}