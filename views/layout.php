<?php
    //En caso de que no exista $_SESSION se inicia una session nueva y se comprueba si está logueado
    if(!isset($_SESSION)){
        session_start();
    }
    $auth=$_SESSION['login'] ?? false;
    
        //Se crea un vector para los errores
        $errores=[];
        //Se inicia la variable vacía
        $correo="";
    
        //En caso de realizar un POST
        if ($_SERVER['REQUEST_METHOD']==="POST"){
            //Si se pulsa en el botón suscribirme se guarda y comprueba el email
            if(isset($_POST["Suscribirse"])){
                $correo=mysqli_real_escape_string($db, $_POST['email']);
                if(!$correo){
                    $errores[] = "Debes añadir un correo electrónico.";
                }
                //En caso de que no haya errores se realiza y envia la query a la base de datos
                if(empty($errores)){
                    $query = "INSERT INTO newsletter (email) values ('$correo');";
                    $resultado=mysqli_query($db, $query);
                    if($resultado){
                        
                    }
                }
                
            }
        }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Drogo</title>
        <link rel="stylesheet" href="/css/styles.css">
    </head>
    <body>
        <div id="header">
            <div class="logo">
                <a href="index.php">
                    <img src="/assets/logoimg/minuscula.png" alt="drogo logo" class="brand__img">
                </a>
                    <img src="/assets/logoimg/paquete.png" class="brand__img hand" alt="drogo icono" id="hand">
            </div>  
            <section class="nave">
                <!-- Menú -->
                <nav id="navigation">
                    <ul>
                        <li>
                        <a href="/index.php" class="link_nav">Home</a>
                        <a href="/servicios.php" class="link_nav">Servicios</a>
                        <a href="/equipo.php" class="link_nav">Equipo</a>
                        <a href="/preguntas-frecuentes.php" class="link_nav">Preguntas Frecuentes</a>
                        <a href="/form-contacto.php" class="link_nav">Contacto</a>
                        </li>
                    </ul>
                </nav>
            </section>
                <!-- Si está la sesión iniciada aparece un menú desplegable -->
            <nav class="desplegable">
                <?php
                    if($auth){ 
                    if ($_SESSION['tipo']=='Administrador'){?>
                    <!--Opciones del admin-->
                    <div class="desplegable">
                        <button class="boton" id="btn"><img src="/assets/images/imagenPerfil.jpg" alt=""></button>
                        <section id="links" class="oculto">
                            <div class="links">
                                <a href="/areaPersonalAdmin.php">Area Admin</a>
                                <a href="/Admin/contacto.php">Contacto</a>
                                <a href="/Admin/newsletter.php">Newsletter</a>
                                <a href="/bloquearUsuario.php">Bloquear Usuario</a>
                                <a href="/cerrar-sesion.php">Cerrar Sesión</a>
                            </div>
                        </section>
                    </div>
                    <?php } else{ ?>
                    <!--Opciones del usuario-->
                    <div class="desplegable">
                        <button class="boton" id="btn"><img src="/assets/images/imagenPerfil.jpg" alt=""></button>
                        <section id="links" class="oculto">
                            <div class="links">
                                <a href="/areaPersonal.php">Ir a mi área personal</a>
                                <a href="/modificarDatos.php">Modificar Datos</a>
                                <!--Si es distribuidor no tiene pedidos por lo que no se muestran estas opción-->
                                <?php if($_SESSION['tipo']!='Distribuidor'){ ?>
                                    <a href="/Pedidos/pedidos.php">Ver Pedidos</a>
                                <?php }?>
                                <a href="/borrar-cuenta.php" id="borrar">Borrar Cuenta</a>
                                <a href="/cerrar-sesion.php">Cerrar Sesión</a>
                            </div>
                        </section>
                    </div>
                    <?php } } else{ ?>
                    <!--En caso de que no esté logeado se muestran dos link, para iniciar sesión y para registrarse-->
                    <div class="botones_nav" id="btn_nav">
                        <a href="/login.php" class="btn_nav login_nav">Login</a>
                        <a href="/registro.php" class="btn_nav registro_nav">Registro</a>
                    </div>
                    <?php  }?>
                </nav>
        </div>

        <?php echo $contenido;?>



        <footer class="footer-section">
            <div class="container">
                <div class="footer-cta">
                    <div class="row">
                            <div class="single-cta">
                                <img src="/assets/icons/location.svg" alt="" class="cta-icon">
                                <div class="cta-text">
                                    <h4>Encuéntranos</h4>
                                    <span>C. Ana Benítez, 15, 35014 Las Palmas de Gran Canaria, Las Palmas</span>
                                </div>
                            </div>
                            <div class="single-cta">
                                <img src="/assets/icons/phone.svg" alt="" class="cta-icon">
                                <div class="cta-text">
                                    <h4>Llámanos</h4>
                                    <span>928 09 14 32</span>
                                </div>
                            </div>
                            <div class="single-cta">
                                <img src="/assets/icons/mail.svg" alt="" class="cta-icon">
                                <div class="cta-text">
                                    <h4>Escríbenos</h4>
                                    <span>drogo@info.com</span>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="footer-content">
                    <div class=" row footer-content-row">
                            <div class="footer-widget">
                                <div class="footer-logo">
                                    <a href="index.php"><img src="/assets/logoimg/banner-msg.png" class="" alt="logo"></a>
                                </div>
                                <div class="footer-text">
                                    <p>Servicio de envíos anónimos: seguro y confidencial. Por el respeto a la privacidad y al libre intercambio. </p>
                                </div>
                                <div class="footer-social-icon">
                                    <span>Síguenos</span>
                                    <a href="#"><img src="./assets/icons/redes/fb.svg" alt=""></a>
                                    <a href="#"><img src="./assets/icons/redes/ig.svg" alt=""></a>
                                    <a href="#"><img src="./assets/icons/redes/x.svg" alt=""></a>
                                </div>
                        </div>
                        <div class="subscription">
                            <h3>Subscribe</h3>
                            <div class="footer-text mb-25">
                                <p>Suscríbete a nuestro newsletter para recibir las últimas novedades</p>
                            </div>
                            <!-- Formulario para suscribirse al newsletter -->
                            <div class="subscribe-form">
                                <form method="POST" action="<?php $_SERVER[ 'PHP_SELF' ]; ?>" enctype="multipart/form-data">
                                    <div class="news">
                                        <input type="text" placeholder="Dirección de Email" class="text" name="email" value="">
                                        <input type="submit" class="botonSus" value="Suscribirme" name="Suscribirse">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright-area">
                <p class="copyright-text">Copyright &copy; 2023, Todos los Derechos Reservados, Drogo</p>            
            </div>
        </footer>
    <!-- Se incluye los archivos de javascript -->
    <script src="/js/header.js"></script>
    <script src="/js/index.js"></script>
    </body>
</html>      