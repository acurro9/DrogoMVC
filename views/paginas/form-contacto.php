<?php 
//Para el formulario de contacto
    // Se inicializan las variables a vacio
    $errores=[];
    $nombre="";
    $correo="";
    $tlf="";
    $mensaje="";
    $terms="";
    // En caso de hacer el POST
    if($_SERVER['REQUEST_METHOD']==='POST'){
        // Se guardan los datos del formulario
        $nombre=mysqli_real_escape_string($db, $_POST['nombre']);
        $correo=mysqli_real_escape_string($db, $_POST['correo']);
        $tlf=mysqli_real_escape_string($db, $_POST['telefono']);
        $mensaje=mysqli_real_escape_string($db, $_POST['mensaje']);
        $terms=isset($_POST['terminos']) ? 1 : 0;

        // Si falta algún dato se crea un error
        if(!$nombre){
            $errores[]="Debes añadir un nombre.";
        }
        if(!$correo){
            $errores[]="Debes añadir un correo electrónico.";
        }
        if(!$tlf){
            $errores[]="Debes añadir un teléfono.";
        }
        if(!$mensaje){
            $errores[]="Debes añadir un mensaje.";
        }
        if($terms==0){
            $errores[]="Debes aceptar los términos y condiciones.";
        }
        // Si no hay errores se crea la consulta para añadir el mensaje a contacto
        if(empty($errores)){
            $query="INSERT into contacto (nombre, email, telefono, mensaje) values ('$nombre', '$correo', '$tlf', '$mensaje');";
            $consulta=mysqli_query($db, $query);

            if($consulta){
                header("Location: /");
            }
        }

    }
?>

    <!--Se importan los css necesarios-->
    <link rel="stylesheet" href="../build/css/contacto.css">
    <header>Formulario de contacto</header>

    <main class="formularioEntero">
        <!-- FORMULARIO -->
        <?php foreach($errores as $error){ ?>
            <p class="error"><?php echo $error;?></p>
        <?php } ?>
        <form class="formulario" id="formulario" enctype="multipart/form-data" method="POST">

        <?php include __DIR__ . '/../../includes/templates/forms/formulario_contacto.php'; ?>

        </form>
    </main>
    <section class="banner_bottom">
        <div class="icon_drogo_div">
            <img src="../build/img/logoimg/icon_green.png" alt="icono drogo" class="icon_drogo">
        </div>
          <!-- Botón para ir al registro -->
          <a href="registro.php" class="registro">Registro</a>
    </section>