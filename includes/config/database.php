<?php 
    //Se realiza la conexión a la base de datos
function conectarDB(){
    $dns = 'mysql:dbname=drogoDB;host=localhost';
    $user= 'root';
    $password = '';
    $db = new PDO($dns, $user, $password);

    if(!$db) {
        echo "Error: No se pudo conectar a MySQL.";
            echo "Error: " . PDO::errorInfo();
            exit;
    } 

    return $db;
    
}