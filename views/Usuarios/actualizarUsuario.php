<?php
//Para la actualización de los usuarios
    //En caso de no estar logueado y no ser el administrador nos redirige al index.php
    $auth=$_SESSION['login']??false;
    if(!$auth || $_SESSION['tipo']!='Administrador'){
        header('Location: /');
    }

    //Se guarda la id del usuario pasado por URL, si no existe devuelve al area personal del admin
    $id=$_GET['usuario']??null;
    if(!$id){
        header('Location: /areaPersonalAdmin.php');
    } else{
        // Se inicializa errores y se crea la query necesaria para rellenar los datos
        $errores=[];
        $query = "SELECT id, username, email, tipo from usuario where id='$id';";
        $resultado = mysqli_query($db, $query);

        if($fila=mysqli_fetch_row($resultado)){
            // Se guardan los datos devueltos por la consulta
            $ref=$fila[0];
            $nombre=$fila[1];
            $correo=$fila[2];
            $tip=$fila[3];
        }
        $cont="";

        // En el caso de hacer POST
        if($_SERVER['REQUEST_METHOD']==="POST"){
            // Se guardan los datos de los inputs del formulario
            $ref=mysqli_real_escape_string($db, $_POST['id']);
            $nombre=mysqli_real_escape_string($db, $_POST['nombre']);
            $correo=mysqli_real_escape_string($db, $_POST['correo']);
            $tip=mysqli_real_escape_string($db, $_POST['tip']);
            $cont=mysqli_real_escape_string($db, $_POST['password']);

            // En caso de que falte algún dato se crea el error
            if(!$ref){
                $errores[]="Debes añadir una referencia del usuario.";
            }
            if(!$nombre){
                $errores[]="Debes añadir un nombre de usuario.";
            }
            if(!$correo){
                $errores[]="Debes añadir un correo electrónico.";
            }
            if(!$tip){
                $errores[]="Debes añadir el tipo de usuario que es.";
            }

            // En caso de no haber errores
            if(empty($errores)){
                if(!$cont){
                    // En caso de no indicar la contraseña se actualiza todo menos eso
                    $consulta="UPDATE usuario set id='$ref', username='$nombre', email='$correo', tipo=$tip where id='$id';";
                } else{
                    // En caso de indicar contraseña la hasheamos y se actualiza la base de datos
                    $contHash=password_hash($cont, PASSWORD_DEFAULT);
                    $consulta="UPDATE usuario set id='$ref', username='$nombre', email='$correo', password_hash='$contHash', tipo=$tip where id='$id';";
                }

                //Se realiza la consulta, si es correcta nos devuelve a la tabla de usuarios
                $result=mysqli_query( $db, $consulta );
                if($result){
                    header("Location: /Usuarios/usuario.php?res=3");
                }
            }
        }
    }
?>
<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/usuarios.css">
<link rel="stylesheet" href="../build/css/styles.css">
<!-- Formulario para la actualización de usuarios -->
<form method="POST" enctype="multipart/form-data" class="formu">
    <!-- Se imprimen los errores si los hay -->
    <?php foreach($errores as $error){?>
        <div>
            <p class="error">
                <?php echo $error;?>    
            </p>
        </div>
    <?php } ?>
    <?php include __DIR__ . '/../../includes/templates/forms/formulario_actUsu.php'; ?>
</form>
