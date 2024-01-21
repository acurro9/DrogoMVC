<?php
//Para borrar la cuenta del usuario
    // Se inicia la sesión y se guardan los datos de la sesión
    session_start();
    $user = $_SESSION["usuario"];
    $tipo = $_SESSION["tipo"];
    // Se realiza la consulta necesaria para eliminar al usuario y eliminar al usuario de la tabla de su tipo
    $consulta = "DELETE from ${tipo} where hash_${tipo} like '(SELECT id from usuario where email like ${user})';";
    $res=mysqli_query($db, $consulta);
    if($res){
        $query= "DELETE from usuario where email='${user}';";
        $resultado = mysqli_query($db, $query);
        if($resultado){
            session_destroy();
            header('Location: / ');
        }
    }
    
?>
