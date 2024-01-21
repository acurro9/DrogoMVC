<?php 
//Para el area personal del usuario común
    //En caso de no estar logueado nos redirige al index.php
    $auth=$_SESSION['login']??false;
    if(!$auth){
        header('Location: /');
    }
    
    
    
    // Se guarda la id del usuario pasada por la sesión y se realizan las consultas necesarias para tener los datos que necesitamos
    $usuario=$_SESSION['usuario'];
    $query="SELECT * FROM usuario WHERE email='${usuario}';";
    $resultado=mysqli_query($db, $query);

    if ($resultado) {
        $datosUsuario = mysqli_fetch_assoc($resultado);
    } 

    $tipoQuery="SELECT tipo FROM usuario WHERE email='${usuario}';";

    $resultadoTipo=mysqli_query($db, $tipoQuery);

    if ($resultadoTipo) {
        $tipoUsuario=mysqli_fetch_assoc($resultadoTipo)['tipo'];
        //Dependiendo del tipo del usuario realizamos una consulta u otra 
        switch($tipoUsuario){
            case 'Vendedor':
                $queryHashCartera="SELECT hash_carteraVendedor FROM vendedor WHERE hash_vendedor=(SELECT id FROM usuario WHERE email='${usuario}');";
                break;
            case 'Comprador':
                $queryHashCartera="SELECT hash_carteraComprador FROM comprador WHERE hash_comprador=(SELECT id FROM usuario WHERE email='${usuario}');";
                break;
            case 'Distribuidor':
                $queryHashCartera="SELECT hash_carteraDistribuidor FROM distribuidor WHERE hash_distribuidor=(SELECT id FROM usuario WHERE email='${usuario}');";
                break;
            
                default:
                break;
        }

        $resultadoHashCartera = mysqli_query($db, $queryHashCartera);
    
        if ($resultadoHashCartera) {
            $hashCartera = mysqli_fetch_assoc($resultadoHashCartera);
        }
    }

?>
    <!--Se importan los css necesarios-->
    <link rel="stylesheet" href="../build/css/areaPersonal.css">
   
    <div class="intro">
    <h1 class="bvnd">¡Bienvenido/a!</h1>
        <h2 class="userOpt_title">Elige una opción: </h2>
    </div>
    <section class="banner_bottom">
        <div class="icon_drogo_div_area">
            <img src="../build/img/logoimg/paquete.png" alt="icono drogo" class="icon_area">
        </div>
    </section>

    <main class=main_personalArea>
        
        <section class="userOptions">
            <div class="userOpt leftPannel">
                <div class="user_inner_left">
                    <div class="userOpt account">
                        <img src="../build/img/icons/lock.svg" alt="" class="lock_icon">
                        <a href="#" class="a_title">Mi cuenta</a>
                    </div>
                    <!--Si es distribuidor no tiene pedidos por lo que no se muestra la opción de mis pedidos pero se muestran las distribuciones que tiene-->
                    <?php if($_SESSION['tipo']!='Distribuidor'){ ?>    
                        <div class="userOpt">
                            <img src="../build/img/icons/lock.svg" alt="">
                            <a href="/Pedidos/pedidos.php"  class="a_title">Mis Pedidos</a>
                        </div>
                    <?php } else{?>
                        <div class="userOpt">
                            <img src="../build/img/icons/lock.svg" alt="">
                            <a href="/Pedidos/entregas.php?id=<?php echo $_SESSION['id'];?>"  class="a_title">Distribuciones</a>
                        </div>
                    <?php } ?>
                    <div class="userOpt">
                        <img src="../build/img/icons/lock.svg" alt="">
                        <a href="cerrar-sesion.php"  class="a_title">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </section>
            <section class="miCuenta hidden">
                <div class="userOptRight rightPannel">
                    <div class="user_inner_right">
                        <div class="userOptRight mostrar">
                            <!--se cambia a paragraph la etiqueta porque con el click de js en el div da problemas tenerlo como a -->
                            <img src="../build/img/icons/detective.svg" alt="detective">
                            <p class="miCuentaOpcion p_title">Mostrar Datos</p>
                        </div>
                        <div class="userOptRight miCuentaOpciones">
                            <img src="../build/img/icons/writer.svg" alt="punta de boli">
                            <a href="./modificarDatos.php" class="miCuentaOpcion" class="a_title">Modificar Datos</a>
                        </div>
                        <div class="userOptRight miCuentaOpciones">
                            <img src="../build/img/icons/close.svg" alt="cerrar">
                            <a href="cerrar-sesion.php" class="miCuentaOpcion a_title">Cerrar Sesión</a>
                        </div>
                        <div class="userOptRight miCuentaOpciones">
                            <img src="../build/img/icons/trash.svg" alt="basura">
                            <a href="./borrar-cuenta.php" class="miCuentaOpcion a_title" id="deleteAccount">Borrar Cuenta</a>
                        </div>
                    </div>
                </div>
            </section>     
    </main>

    <section class="tabla_datos hid">
    <div class="grid-container">
        <div class="header">Nombre de usuario:
            <div class="data"><?php echo $datosUsuario['username']?></div>
            </div>
        <div class="header">Correo Electrónico:
            <div class="data"><?php echo $datosUsuario['email']?></div>
        </div>
    </div>
    </section>
    <!-- Se incluye los archivos de javascript -->
    <script src="../build/js/cuenta.js"></script> 
    <script src="../build/js/index.js"></script>
    