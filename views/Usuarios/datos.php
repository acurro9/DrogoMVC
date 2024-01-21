<?php 
//Para modificar el dato seleccionado

    //En caso de no estar logueado y no ser el administrador nos redirige al index.php
    // $auth=$_SESSION['login']??false;
    // if(!$auth){
    //     header('Location: /');
    // }
    
    //Se inicializan las variables a vacio y se guarda el email del usuario y el tipo de dato a cambiar
    // $newValue='';
    // $cont='';
    // $oldValue='';
    // $usuario = $_SESSION['usuario'];
    // $dataType = $_GET['type'] ?? '';

    // Dependiendo del tipo de usuario se cambia el valor de la variable oldValue, que se pasa por la URL
    // switch($dataType){
    //     case 'username':
    //         $oldValue=$_GET['value'];
    //         break;
    //     case 'email':
    //         $oldValue=$_GET['value'];
    //         break;
    //     case 'password':
    //         $oldValue = '';
    //         break;
    //     case 'cartera':
    //         $oldValue = '';
    //         break;
    //     default:
    //         break;
    // }

    // Se realiza la consulta del tipo de usuario
    // $tipoQuery="SELECT tipo FROM usuario WHERE email='{$usuario}';";
    // $resultadoTipo=mysqli_query($db, $tipoQuery);

    // if ($resultadoTipo) {
    //     $tipoUsuario=mysqli_fetch_assoc($resultadoTipo)['tipo'];
    //     // Dependiedno del tipo de usuario la variable carteraTable tendrá un valor u otro 
    //     switch($tipoUsuario){
    //         case 'Vendedor':
    //             $carteraTable="vendedor";
    //             break;
    //         case 'Comprador':
    //             $carteraTable="comprador";
    //             break;
    //         case 'Distribuidor':
    //             $carteraTable="distribuidor";
    //             break;
    //         default:
    //             break;
    //     }
    // }
 

    // $tablaCartera='';
// Dependiedno del tipo de usuario la variable tablaCartera tendrá un valor u otro 
    // if($tipoUsuario==='Comprador'){
    //     $tablaCartera='comprador';
    // }elseif($tipoUsuario==='Vendedor'){
    //     $tablaCartera='vendedor';
    // }elseif($tipoUsuario==='Distribuidor'){
    //     $tablaCartera='distribuidor';
    // }

    // En caso de realizar el post
    // if($_SERVER['REQUEST_METHOD']==='POST'){
        // Se guardan los datos del formulario
        // $updateQuery='';
        // $newValue = mysqli_real_escape_string($db, $_POST['new_value']);;

        // Dependiendo del tipo de dato a cambiar se realiza una consulta u otra
        // switch($dataType){
        //     case 'username':
        //         $updateQuery="UPDATE usuario SET username='$newValue' WHERE email='${usuario}';";
        //         break;
        //     case 'email':
        //         $updateQuery="UPDATE usuario SET email='$newValue' WHERE email='${usuario}';";
        //         break;
        //     case 'password':
        //         // En el caso de la contraseña pide introducirla dos veces
        //         $oldValue =mysqli_real_escape_string($db, $_POST['old_value']);
        //         // Se comparan que las dos contraseñas introducidas sean iguales
        //         if(strcmp($oldValue, $newValue)===0){
        //             // Se hashea la contraseña
        //             $hashedPassword=password_hash($newValue, PASSWORD_DEFAULT);
        //             $updateQuery= "UPDATE usuario SET password_hash='$hashedPassword' WHERE email='${usuario}';";
        //             break;
        //         } else{
        //             echo "Error, las contraseñas no coinciden.";
        //             $cont='';
        //             break;
        //         }
        //     case 'cartera':
                // En el caso de cambiar la cartera hay que introducir dos veces la nueva cartera y la contraseña de la cuenta
                // $oldValue = mysqli_real_escape_string($db, $_POST['old_value']);
                // $cont = mysqli_real_escape_string($db, $_POST['contraseña']);
                // Se compara la contraseña introducida con la contraseña de la cuenta
                // $authCont=password_verify($cont, $_SESSION["contraseña"]);
                // if($authCont){
                    // En caso de coindicir se comparan las dos carteras introducidas que sean iguales
                    // if(strcmp($oldValue, $newValue)===0){
                        // Se hashea la nueva cartera y se realiza la consulta
        //                 $cart=password_hash($newValue, PASSWORD_DEFAULT);
        //                 $updateQuery= "UPDATE $carteraTable SET hash_cartera$tipoUsuario='$cart' WHERE hash_$carteraTable=(SELECT id FROM usuario WHERE email='${usuario}');";
        //                 break;
        //             } else {
        //                 echo "Error, la cartera no coincide";
        //                 break;
        //             }
        //         } else{
        //             echo "Error, la contraseña es erronea";
        //         }
        //     default:
        //         break;
        // }
        // En el caso de que exista la consulta
    //     if(!empty($updateQuery)){
    //         $resultadoUpdate=mysqli_query($db, $updateQuery);

    //         if($resultadoUpdate){
    //             //Si el tipo de modificación es 'email' se actualiza la variable de sesión del email del usuario
    //             if ($dataType === 'email') {
    //                 $_SESSION['usuario'] = $newValue;
    //                 header('Location: /modificarDatos.php');
    //                 exit;
    //             } else {
    //                 echo "Modificación realizada con éxito";
    //                 header('Location: /modificarDatos.php');
    //             }
    //         }else{
    //             echo "Error al actualizar los datos: " . mysqli_error($db);
    //         }
            

    //     }
    // }
    ?>
    //En caso de que el dato a cambiar sea la contraseña

    <link rel="stylesheet" href="../../build/css/styles.css">
    <link rel="stylesheet" href="../../build/css/modificar.css">


        <?php if ($dataType == 'password'): ?>
        
        
            <form method="POST">
                <h2>Cambiar Contraseña: </h2>
                <input type="hidden" name="dataType" value="password">
                <input type="password" name="newPassword" placeholder="Nueva Contraseña">
                <input type="password" name="confirmPassword" placeholder="Confirmar Nueva Contraseña">
                <input type="submit" value="Cambiar Contraseña">
            </form>
        <?php elseif ($dataType == 'email'): ?>
            <form method="POST">
                <h2>Cambiar Correo Electrónico: </h2>
                <input type="hidden" name="dataType" value="email">
                <input type="email" name="new_value" placeholder="Nuevo Correo Electrónico" value="<?php echo htmlspecialchars($datosUsuario->email); ?>">
                <input type="submit" value="Cambiar Correo">
            </form>
        <?php elseif ($dataType == 'username'): ?>
            <form method="POST">
                <h2>Cambiar Nombre de Usuario: </h2>
                <input type="hidden" name="dataType" value="username">
                <input type="text" name="new_value" placeholder="Nuevo Nombre de Usuario" value="<?php echo htmlspecialchars($datosUsuario->username); ?>">
                <input type="submit" value="Cambiar Nombre">
            </form>
        <?php endif; ?>
        