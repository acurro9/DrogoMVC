<?php 
    //Se realiza la conexión a la base de datos
    // $db = new PDO('mysql:host=localhost;dbname=drogodb', 'root', '');
function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', '', 'drogoDB');

    if(!$db) {
        echo "Error: No se pudo conectar a MySQL.";
            echo "errno de depuración: " . mysqli_connect_errno();
            echo "error de depuración: " . mysqli_connect_error();
            exit;
    } 

    return $db;
    
}