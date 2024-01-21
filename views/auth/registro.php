<?php 
//Para el resgistro
    //Se crea un vector para los errores
    $errores=[];
    //Se inicializan las variables vacias
    $usuario='';
    $email='';
    $contraseña= '';
    $contraseña2='';
    $tipo='';
    $mensaje='';
    // En caso de hacer el POST
    if ($_SERVER['REQUEST_METHOD']==="POST"){
        // Se guardan los datos del formulario
        $usuario=mysqli_real_escape_string($db, $_POST['usuario']);
        $email=mysqli_real_escape_string($db, $_POST['email']);
        $contraseña=mysqli_real_escape_string($db, $_POST['password']);
        $contraseña2=mysqli_real_escape_string($db, $_POST['password2']);
        $tipo=mysqli_real_escape_string($db, $_POST['tipo']);
        
        //Se consultan el username y el correo
        $consulta="SELECT username, email FROM usuario;";
        $resConsulta=mysqli_query($db, $consulta);
        
        // Se comprueba si el nombre de usuario o correo ya existe en la base de datos
        while($user=mysqli_fetch_assoc($resConsulta)){
            if($user['username']==$usuario){
                $errores[] = "El nombre de usuario ya existe.";
            }
            if($user['email']==$email){
                $errores[] = "El correo electrónico ya existe.";
            }
        }
        // En caso de que falte algún dato se crea un error
        if(!$usuario){
            $errores[] = "Debes introducir un nombre de usuario.";
        }
        if(!$email){
            $errores[] = "Debes introducir un email.";
        }
        if(!$contraseña){
            $errores[] = "Debes introducir la contraseña.";
        }
        if(!$contraseña2){
            $errores[] = "Debes repetir la contraseña.";
        }
        if(!$tipo){
            $errores[] = "Debes introducir el tipo de usuario que eres.";
        } else if($tipo!=1 && $tipo!=2 && $tipo!=3 && $tipo!=4){
            $errores[] = "Debes elegir un tipo de usuario existente.";
        }

        // Se compara las contraseñas que sean iguales
        if(strcmp($contraseña, $contraseña2)!==0){
            $errores[]= "Las contraseñas no coinciden";
        }
        // En caso de que no haya errores
        if(empty($errores)){
            // Se crea un hash para la id
            $codigo=md5(uniqid(rand(),true));
            // Se hashea la contraseña
            $passwordHash=password_hash($contraseña, PASSWORD_DEFAULT);
            // Se realiza la inserción con los datos introducidos
            $query="INSERT INTO usuario (id, username, email, password_hash, tipo) values 
            ('$codigo', '$usuario', '$email', '$passwordHash', $tipo);";
            $resultado=mysqli_query($db, $query);
            if($resultado){
                // En caso de que el tipo de usuario sea admin te redirige al login del admin
                if($tipo==4){
                header('Location: /loginAdmin.php');
                // En caso de que se registre pero no sea admin redirige a la pagina para incluir la cartera
                }else{
                header('Location:/registro2.php?tipo='.$tipo.'&usuario='.$usuario);
                }
            }
        }
    }

?>
    <!--Se importan los css necesarios-->
    <link rel="stylesheet" href="../build/css/registro.css">
<main>
    <!-- Formulario para el registro -->
<form method="POST" enctype="multipart/form-data">
    <h3>Registro</h3>

    <?php foreach($errores as $error){ ?>
        <!-- Se imprimen los errores si existen -->
        <div style="color: red;">
            <?php echo $error; ?>
        </div>

    <?php } ?>
    <?php include __DIR__ . '/../../includes/templates/forms/formulario_registro.php'; ?>
    
</form>
</main>
    <!-- Se incluye los archivos de javascript -->
    <script src="../build/js/contraseña.js"></script>
</body>
</html>
