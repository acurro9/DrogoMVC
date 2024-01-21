<?php
//Para la actualización de los lockers
    //En caso de no estar logueado y no ser el administrador nos redirige al index.php
    $auth=$_SESSION['login']??false;
    if(!$auth || $_SESSION['tipo']!='Administrador'){
        header('Location: /');
    }
    //Se guarda la referencia del locker pasado por URL, si no existe devuelve al area personal del admin
    $refLocker=$_GET['locker']??null;
    if(!$refLocker){
        header('Location: /areaPersonalAdmin.php');

    } else{
        //Se inicializa errores y se crea la query donde se seleccionan los datos del locker
        $errores=[];

        $query = "SELECT refLocker, direccion, passwordLocker from locker where refLocker='$refLocker';";
        $resultado = mysqli_query($db, $query);

        //Se guardan los datos de la consulta
        if($fila=mysqli_fetch_row($resultado)){
            $refLocker=$fila[0];
            $direccion=$fila[1];
            $passwordLocker=$fila[2];
        }
        // AL hacer el post se guarda la direccion del locker y la contraseña
        if($_SERVER['REQUEST_METHOD']==="POST"){
            $direccion=mysqli_real_escape_string($db, $_POST['direccion']);
            $passwordLocker=mysqli_real_escape_string($db, $_POST['passwordLocker']);

            // En caso de que falte algun dato
            if(!$direccion){
                $errores[]="Debes añadir una dirrecion del Locker.";
            }
            if(!$passwordLocker){
                $errores[]="Debes añadir una contraseña de Locker";
            }
            // Si no hay errores se realiza el update y nos redirige a la tabla de lockers si se realiza correctamente
            if(empty($errores)){
                $consulta="UPDATE locker set direccion='$direccion', passwordLocker='$passwordLocker' where refLocker='$refLocker';";
                $result=mysqli_query( $db, $consulta );
                if($result){
                    header("Location: /lockers/lockers.php?res=2");
                }
            }
        }
    }
?>
<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/lockers.css">
<!-- Formulario para la actualización de lockers -->
<form  method="POST" enctype="multipart/form-data" class="formu">
    <!-- Se imprimen los errores si los hay -->
    <?php foreach($errores as $error){?>
        <div>
            <?php echo $error;?>    
        </div>
    <?php } ?>
    <?php include __DIR__ . '/../../includes/templates/forms/formulario_actLocker.php'; ?>
</form>
