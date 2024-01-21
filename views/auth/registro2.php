<?php 
//Para registrar la cartera del usuario
    // Se guarda el tipo de usuario y el correo
    $tipo=$_GET['tipo'] ?? null;
    $usuario=$_GET['usuario'] ?? null;
    

    //Se crea un vector para los errores
    $errores=[];
    //Se inicializan las variables vacias
    $cartera='';
    // En caso de hacer un POST
    if ($_SERVER['REQUEST_METHOD']==="POST"){
        // Se guardan los datos del formulario
        $cartera=mysqli_real_escape_string($db, $_POST['cartera']);
        $usuario=mysqli_real_escape_string($db, $_POST['usuario']);

        // Se selecciona el id del usuario
        $query = "SELECT id from usuario where username like '$usuario';";
        $codigo=mysqli_query($db, $query);
        $cod=mysqli_fetch_assoc($codigo);
        $codUsuario=$cod['id'];

        // En caso de que falte algún dato se crea un error
        if(!$usuario){
            $errores[] = "Error: Indica el nombre del usuario.";
        }
        if(!$codigo){
            $errores[] = "Error: No se pudo obtener el id del usuario.";
        }
        if(!$cartera){
            $errores[] = "Error: Introduce el código de la cartera.";
        }
        // Dependiendo del tipo de usuario las variables tendran un valor u otro para la consulta
        if(intval($tipo)===1){
            $tabla="Comprador";
            $hash="hash_comprador";
            $hashCartera="hash_carteraComprador";
        } else if(intval($tipo)===2){
            $tabla="Vendedor";
            $hash="hash_vendedor";
            $hashCartera="hash_carteraVendedor";
        } else if(intval($tipo)===3){
            $tabla="Distribuidor";
            $hash="hash_distribuidor";
            $hashCartera="hash_carteraDistribuidor";
        } else {
            $errores[] = "Error: Tipo de usuario no existente.";
        }
        // Si no hay errores
        if(empty($errores)){
            // Se hashea la cartera
            $cart=password_hash($cartera, PASSWORD_DEFAULT);
            // Se inserta la cartera en la tabla del usuario
            $consulta = "INSERT INTO $tabla ($hash, $hashCartera) values ('$codUsuario', '$cart');";
            $resultado=mysqli_query($db, $consulta);

            if($resultado){
                header('Location: /login.php');
            }
        }
    }
?>
<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/registro.css">
        <main class="reg2">
        <!-- Formulario del registro de la cartera -->
        <form method="POST" enctype="multipart/form-data">
            <h3>Finalizar registro</h3>

            <?php foreach($errores as $error){ ?>
                <!-- Se imprimen los errores si los hay -->
                <div style="color: red;">
                    <?php echo $error; ?>
                </div>

            <?php } ?>

            

            <?php include __DIR__ . '/../../includes/templates/forms/formulario_registro2.php'; ?>
        </form>
        </main>
    </body>
</html>