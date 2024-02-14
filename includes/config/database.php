<?php 

/**
 * Establece una conexión a la base de datos utilizando PDO.
 *
 * Esta función intenta establecer una conexión a la base de datos definida por las credenciales
 * y el DSN proporcionados dentro de la función. Utiliza la extensión PDO de PHP para crear la conexión.
 * Si la conexión es exitosa, retorna un objeto PDO que puede ser utilizado para realizar operaciones
 * de base de datos. En caso de fallar, muestra un mensaje de error y termina la ejecución del script.
 *
 * @return PDO Objeto de conexión a la base de datos.
 */
function conectarDB(){
    $dns = 'mysql:dbname=drogoDB;host=localhost'; //DSN para la conexión a la base de datos.
    $user= 'root'; //Nombre de usuario para la conexión a la base de datos.
    $password = ''; //COntraseña para la conexión a la base de datos.

    //Intenta establecer la conexión a la base de datos.
    $db = new PDO($dns, $user, $password);

    //Verifica si la conexión fue exitosa.
    if(!$db) {
        echo "Error: No se pudo conectar a MySQL.";
        exit;
    } 

    //Retorna el objeto PDO de la conexión establecida.
    return $db;
    
}