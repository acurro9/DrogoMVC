<?php 
//Para realizar el login
    //En caso de no estar logueado nos redirige al index.php
    $auth=$_SESSION['login']??false;
    if(!$auth){
        header('Location: /');
    }

    // Se guarda el email del usuario y se realiza la query para seleccionar los datos del usuario
    $usuario=$_SESSION['usuario'];
    $query="SELECT * FROM usuario WHERE email='{$usuario}';";
    $resultado=mysqli_query($db, $query);

    if ($resultado) {
        $datosUsuario = mysqli_fetch_assoc($resultado);
    } 
    // Se realiza la query para seleccionar el tipo del usuario
    $tipoQuery="SELECT tipo FROM usuario WHERE email='{$usuario}';";
    $resultadoTipo=mysqli_query($db, $tipoQuery);
    if ($resultadoTipo) {
        $tipoUsuario=mysqli_fetch_assoc($resultadoTipo)['tipo'];
        // Dependiendo del tipo de usuario realizamos una consulta a una tabla o a otra
        switch($tipoUsuario){
            case 'Vendedor':
                $queryHashCartera="SELECT hash_carteraVendedor FROM vendedor WHERE hash_vendedor=(SELECT id FROM usuario WHERE email='{$usuario}');";
                break;
            case 'Comprador':
                $queryHashCartera="SELECT hash_carteraComprador FROM comprador WHERE hash_comprador=(SELECT id FROM usuario WHERE email='{$usuario}');";
                break;
            case 'Distribuidor':
                $queryHashCartera="SELECT hash_carteraDistribuidor FROM distribuidor WHERE hash_distribuidor=(SELECT id FROM usuario WHERE email='{$usuario}');";
                break;
            default:
                break;
        }
        $resultadoHashCartera = mysqli_query($db, $queryHashCartera);
        if ($resultadoHashCartera) {
            $hashCartera = mysqli_fetch_assoc($resultadoHashCartera);
        }else{
            $hashCartera=array();
        }
        // Si la respuesta a la consulta es un array
        if(is_array($hashCartera)){
            
            $carteraURL='';
            // Dependiendo del tipo de usuario se guarda una URL u otra para modificar la cartera
            switch($tipoUsuario){
                case 'Vendedor':
                    $carteraURL = './datos.php?type=cartera&value=' . $hashCartera['hash_carteraVendedor'];
                    break;
                case 'Comprador':
                    $carteraURL = './datos.php?type=cartera&value=' . $hashCartera['hash_carteraComprador'];
                    break;
                case 'Distribuidor':
                    $carteraURL = './datos.php?type=cartera&value=' . $hashCartera['hash_carteraDistribuidor'];
                    break;
                default:
                    break;
            }


        }
    }

?>
<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/styles.css">
<link rel="stylesheet" href="../build/css/modificar.css">
<main>
    <div class="general">
        <!-- Botones para seleccionar el dato a cambiar -->
        <h2>Cambiar Datos</h2>
        <div class="grid">
            <a class="boton1 derec" href="./datos.php?type=username&value=<?php echo $datosUsuario['username']; ?>">Nombre de Usuario</a>
            <a class="boton1" href="./datos.php?type=email&value=<?php echo $datosUsuario['email']; ?>">Correo Electrónico</a>
            <a class="boton1 derec" href="./datos.php?type=password">Contraseña</a>
            <a class="boton1" href="<?php echo $carteraURL ?>">Cartera</a>
        </div>
        <a class="boton1" href="/areaPersonal.php">Volver</a>
    </div>
</main>