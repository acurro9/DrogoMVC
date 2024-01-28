<?php
//Para bloquear o desbloquear usuarios

    //En caso de no estar logueado y no ser el administrador nos redirige al index.php
    // $auth=$_SESSION['login']??false;
    // if(!$auth || $_SESSION['tipo']!='Administrador'){
    //     header('Location: /');
    // }
    

    //Se guardan la acción a realizar y el id del usuario en el que se realiza la acción 
    // $action=$_GET['action']??NULL;
    // $idBloq=$_GET['id']??NULL;
    // Se inicializan las variables en vacio
    // $username="";
    // $email="";
    // $hash_usuario="";
    // $userBloq="";
    // $emailBloq="";
    // $idDisbloq="";
    // $userDisbloq="";
    // $emailDisbloq="";
    // $act="";

    // Dependiendo de la acción a realizar el valor de la varible cambia
    // if(intval($action)===1){
    //     $act="Bloquear";
    // } else if(intval($action)===2){
    //     $act="Desbloquear";
    // } else{
    //     $act="Bloquear";
    // }
    // En el caso de no indicar id del usurio (Entramos desde el menú desplegable)
    // if(!isset($idBloq)){
    //     if($_SERVER['REQUEST_METHOD']==="POST"){
            // En el caso de buscar usuario
            // if(isset($_POST["buscar"])){
                // Se guardan los datos del formulario para buscar y se realiza la consulta necesaria
                // $username=$hash_vendedor=mysqli_real_escape_string($db, $_POST['name']);
                // $email=$hash_vendedor=mysqli_real_escape_string($db, $_POST['correo']);
                // $hash_usuario=$hash_vendedor=mysqli_real_escape_string($db, $_POST['id']);

                // $query="SELECT id, username, email from usuario where username like '$username' or email like '$email' or id like '$hash_usuario';";
                // $resultado=mysqli_query($db, $query);

                // if($resultado){
                    // Se guardan los datos que devuelve la consulta para rellenar el formulario de bloqueo
                    // if($fila=mysqli_fetch_row($resultado)){
                    //     $idBloq=$fila[0];
                    //     $userBloq=$fila[1];
                    //     $emailBloq=$fila[2];
                    // }

                    // Se comprueba si el usuario está bloqueado o no, si está bloqueado lo vamos a desbloquear, si no lo está se va a bloquear
            //         $cons="SELECT username, id from bloqueado;";
            //         $resu=mysqli_query($db,$cons);
            //         while($respuesta=mysqli_fetch_assoc($resu)){
            //             $nombre=$respuesta['username'];
            //             $ide=$respuesta['id'];

            //             if($nombre==$userBloq){
            //                 $action=2;
            //                 $act="Desbloquear";
            //                 break;
            //             } else{
            //                 $action=1;
            //                 $act="Bloquear";
            //             }
            //         }
                    
            //     }
            // }
            // En el caso de darle al input de bloquear
            // if(isset($_POST["bloquear"])){
                // Se guardan los datos del formulario
                // $idBloq=mysqli_real_escape_string($db, $_POST['idBloq']);
                // $userBloq=mysqli_real_escape_string($db, $_POST['nameBloq']);
                // $emailBloq=mysqli_real_escape_string($db, $_POST['correoBloq']);
                // En caso de la accion a realizar (bloqueo o desbloqueo) se realiza una consulta u otra
    //             if(intval($action)===1){
    //                 $consulta="INSERT into bloqueado (id, username, email) values('$idBloq', '$userBloq', '$emailBloq');";
    //                 $res=mysqli_query($db, $consulta);
    //                 if($res){
    //                     header("Location: /Usuarios/usuario.php?res=1");
    //                 }
    //             } else if(intval($action)===2){    
    //                 $consulta2="DELETE from bloqueado where username='$userBloq';";
    //                 $res2=mysqli_query($db, $consulta2);
    //                 if($res2){
    //                     header("Location: /Usuarios/usuario.php?res=2");
    //                 }
            
    //             } else{
    //                 $consulta="INSERT into bloqueado (id, username, email) values('$idBloq', '$userBloq', '$emailBloq');";
    //                 $res=mysqli_query($db, $consulta);
    //                 if($res){
    //                     header("Location: /Usuarios/usuario.php?res=1");
    //                 }
    //             }
    //         }
    //     }
    // } else{
        // En el caso de que si le indicamos la id del usuario (entramos desde la tabla de usuarios)
        // Se realiza la consulta de los datos del usuario 
        // $consulta="SELECT id, username, email from usuario where id like '$idBloq';";
        // $res=mysqli_query($db, $consulta);
        // Se guardan los datos para introducirlos en el formulario de bloqueo
        // if($fil=mysqli_fetch_row($res)){
        //     $idBloq=$fil[0];
        //     $userBloq=$fil[1];
        //     $emailBloq=$fil[2];
        // }

        // if($_SERVER['REQUEST_METHOD']==="POST"){
            // En el caso de darle a buscar
            // if(isset($_POST["buscar"])){
                // Se guardan los datos del formulario para buscar y se realiza la consulta necesaria
                // $username=$hash_vendedor=mysqli_real_escape_string($db, $_POST['name']);
                // $email=$hash_vendedor=mysqli_real_escape_string($db, $_POST['correo']);
                // $hash_usuario=$hash_vendedor=mysqli_real_escape_string($db, $_POST['id']);

                // $query="SELECT id, username, email from usuario where id like '$username' or email like '$email' or id like '$hash_usuario';";
                // $resultado=mysqli_query($db, $query);

                // if($resultado){
                    // Se guardan los datos que devuelve la consulta para rellenar el formulario de bloqueo
                    // if($fila=mysqli_fetch_row($resultado)){
                    //     $idBloq=$fila[0];
                    //     $userBloq=$fila[1];
                    //     $emailBloq=$fila[2];
                    // }

                    // Se comprueba si el usuario está bloqueado o no, si está bloqueado lo vamos a desbloquear, si no lo está se va a bloquear
            //         $cons="SELECT username, id from bloqueado;";
            //         $resu=mysqli_query($db,$cons);
            //         while($respuesta=mysqli_fetch_assoc($resu)){
            //             $nombre=$respuesta['username'];
            //             $ide=$respuesta['id'];

            //             if($nombre==$userBloq){
            //                 $action=2;
            //                 $act="Desbloquear";
            //                 break;
            //             } else{
            //                 $action=1;
            //                 $act="Bloquear";
            //             }
            //         }
            //     }
            // }
            // En el caso de darle al botón de bloquear
            // if(isset($_POST["bloquear"])){
                // Se guardan los datos del formulario
                // $idBloq=mysqli_real_escape_string($db, $_POST['idBloq']);
                // $userBloq=mysqli_real_escape_string($db, $_POST['nameBloq']);
                // $emailBloq=mysqli_real_escape_string($db, $_POST['correoBloq']);
                 // En caso de la accion a realizar (bloqueo o desbloqueo) se realiza una consulta u otra
    //             if(intval($action)===1){
    //                 $consult="INSERT INTO bloqueado (id, username, email) values ('$idBloq', '$userBloq', '$emailBloq');";
    //                 $resu=mysqli_query($db, $consult);
    //                 if($resu){
    //                     header("Location: /Usuarios/usuario.php?res=1");
    //                 }
    //             } else if(intval($action)===2){   
    //                 echo "entra2"; 
    //                 $consulta2="DELETE from bloqueado where username='$userBloq';";
    //                 $res2=mysqli_query($db, $consulta2);
    //                 if($res2){
    //                     header("Location: /Usuarios/usuario.php?res=2");
    //                 }
    //             }
    //         }
    //     }
    // }
?>
<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/styles.css">
<link rel="stylesheet" href="../build/css/bloqUsuario.css">


<div class="bloq">
    <!-- Formulario para la búsqueda del usuario -->
    <form action="bloquearUsuario" method="POST" class="formu">
    <?php foreach($errores as $error): ?>
        <div>
            <p class="error"><?= htmlspecialchars($error); ?></p>
        </div>
    <?php endforeach; ?>
        <?php include __DIR__ . '/../../includes/templates/forms/formulario_bloqUsu.php'; ?>        
    </form>
</div>

<div class="centro margen">
    <a href="/usuario" class="buton grande">Volver</a>
</div>
<!-- Se incluye los archivos de javascript -->
<script src="../build/js/index.js"></script>
