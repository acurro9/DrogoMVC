
    <!--Se importan los css necesarios-->
    <link rel="stylesheet" href="../build/css/areaPersonal.css">

   
    <div class="intro">
    <h1 class="bvnd">¡Bienvenido/a!</h1>
    <?php 
    if(isset($_SESSION['mensaje_exito'])): ?>
        <p class='success'><?php echo htmlspecialchars($_SESSION['mensaje_exito']); ?></p>
        <?php unset($_SESSION['mensaje_exito']); // Elimina el mensaje de la sesión después de mostrarlo
    endif; ?>
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
                            <a href="/pedidos"  class="a_title">Mis Pedidos</a>
                        </div>
                    <?php } else{?>
                        <div class="userOpt">
                            <img src="../build/img//icons/lock.svg" alt="">
                            <a href="/Pedidos/entregas.php?id=<?php echo $_SESSION['usuario'];?>"  class="a_title">Distribuciones</a>
                        </div>
                    <?php } ?>
                    <div class="userOpt">
                        <img src="../build/img/icons/lock.svg" alt="">
                        <form action="/logout" method="POST">
                            <!--Corregir butón que pasa a ser submit -->
                            <button type="submit">Cerrar Sesión</button>
                        </form>
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
                            <form action="/modDatos" method="POST">
                            <!--Corregir butón que pasa a ser submit -->
                                <button type="submit">Modificar Datos</button>
                            </form>
                        </div>
                        <div class="userOptRight miCuentaOpciones">
                            <img src="../build/img/icons/close.svg" alt="cerrar">
                            <form action="/logout" method="POST">
                            <!--Corregir butón que pasa a ser submit -->
                                <button type="submit">Cerrar Sesión</button>
                            </form>
                        </div>
                        <div class="userOptRight miCuentaOpciones">
                            <img src="../build/img/icons/trash.svg" alt="basura">
                            <!-- <a href="./borrar-cuenta.php" class="miCuentaOpcion a_title" id="deleteAccount">Borrar Cuenta</a> -->
                            <form action="/borrarCuenta" method="POST">
                                <button type="submit">Borrar Cuenta</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>     
    </main>

    <section class="tabla_datos hid">
    <div class="grid-container">
    <?php if(isset($datosUsuario) && is_object($datosUsuario)): ?>
        <div class="header">Nombre de usuario:
            <div class="data"><?php echo htmlspecialchars($datosUsuario->username); ?></div>
        <div class="header">Correo Electrónico:
            <div class="data"><?php echo htmlspecialchars($datosUsuario->email); ?></div>
        </div>
    </div>
    <?php endif; ?>
    </section>
    <!-- Se incluye los archivos de javascript -->
    <script src="../build/js/cuenta.js"></script> 
    <script src="../build/js/index.js"></script>
