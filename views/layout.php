<?php
    //En caso de que no exista $_SESSION se inicia una session nueva y se comprueba si está logueado
    if(!isset($_SESSION)){
        session_start();
    }
    $auth=$_SESSION['login'] ?? false;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Drogo</title>
        <link rel="shortcut icon" href="../build/img/logos/drogobanner - copia.png">
        <link rel="stylesheet" href="../build/css/styles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    </head>
    <body>
        <div id="header">
            <div class="logo">
                <a href="/">
                    <img src="../build/img/logoimg/minuscula.png" alt="drogo logo" class="brand__img">
                </a>
                    <img src="../build/img/logoimg/paquete.png" class="brand__img hand" alt="drogo icono" id="hand">
            </div>  
            <section class="nave">
                <!-- Menú -->
                <nav id="navigation">
                    <ul>
                        <li>
                        <a href="/" class="link_nav">Home</a>
                        <a href="/servicios" class="link_nav">Servicios</a>
                        <a href="/nosotros" class="link_nav">Equipo</a>
                        <a href="/preguntasFrecuentes" class="link_nav">Preguntas Frecuentes</a>
                        <a href="/contacto" class="link_nav">Contacto</a>
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
                        <button class="boton" id="btn"><img src="../build/img/images/imagenPerfil.jpg" alt=""></button>
                        <section id="links" class="oculto">
                            <div class="links">
                                <a href="/areaPersonalAdmin">Area Admin</a>
                                <a href="/verContacto">Contacto</a>
                                <a href="/newsletter">Newsletter</a>
                                <!-- <a href="/bloquearUsuario">Bloquear Usuario</a> -->
                                <a href="/logout">Cerrar Sesión</a>
                            </div>
                        </section>
                    </div>
                    <?php } else if($_SESSION['tipo']!=='Administrador'){ ?>
                    <!--Opciones del usuario-->
                    <div class="desplegable">
                        <button class="boton" id="btn"><img src="../build/img/images/imagenPerfil.jpg" alt=""></button>
                        <section id="links" class="oculto">
                            <div class="links">
                                <a href="/areaPersonal">Ir a mi área personal</a>
                                <a href="/modDatos">Modificar Datos</a>
                                <!--Si es distribuidor no tiene pedidos por lo que no se muestran estas opción-->
                                <?php if($_SESSION['tipo']!='Distribuidor'){ ?>
                                    <a href="/pedidos">Ver Pedidos</a>
                                <?php } else { ?>
                                    <a href="/envios">Ver Envios</a>
                                <?php } ?>
                                <a href="/borrarCuenta" id="borrar">Borrar Cuenta</a>
                                <a href="/logout">Cerrar Sesión</a>
                            </div>
                        </section>
                    </div>
                    <?php }} else{ ?>
                    <!--En caso de que no esté logeado se muestran dos link, para iniciar sesión y para registrarse-->
                    <div class="botones_nav" id="btn_nav">
                        <a href="/login" class="btn_nav login_nav">Login</a>
                        <a href="/registro" class="btn_nav registro_nav">Registro</a>
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
                                <img src="../build/img/icons/location.svg" alt="" class="cta-icon">
                                <div class="cta-text">
                                    <h4>Encuéntranos</h4>
                                    <span>C. Ana Benítez, 15, 35014 Las Palmas de Gran Canaria, Las Palmas</span>
                                </div>
                            </div>
                            <div class="single-cta">
                                <img src="../build/img/icons/phone.svg" alt="" class="cta-icon">
                                <div class="cta-text">
                                    <h4>Llámanos</h4>
                                    <span>928 09 14 32</span>
                                </div>
                            </div>
                            <div class="single-cta">
                                <img src="../build/img/icons/mail.svg" alt="" class="cta-icon">
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
                                    <a href="/index"><img src="../build/img/logoimg/banner-msg.png" class="" alt="logo"></a>
                                </div>
                                <div class="footer-text">
                                    <p>Servicio de envíos anónimos: seguro y confidencial. Por el respeto a la privacidad y al libre intercambio. </p>
                                </div>
                                <div class="footer-social-icon">
                                    <span>Síguenos</span>
                                    <a href="#"><img src="../build/img/icons/redes/fb.svg" alt=""></a>
                                    <a href="#"><img src="../build/img/icons/redes/ig.svg" alt=""></a>
                                    <a href="#"><img src="../build/img/icons/redes/x.svg" alt=""></a>
                                </div>
                        </div>
                        <div class="subscription">
                            <h3>Subscribe</h3>
                            <div class="footer-text mb-25">
                                <p>Suscríbete a nuestro newsletter para recibir las últimas novedades</p>
                            </div>
                            <!-- Formulario para suscribirse al newsletter -->
                            <div class="subscribe-form">
                                <form method="POST" class="news_form" action="/añadirNewsletter" enctype="multipart/form-data">
                                <?php include __DIR__ . '/../includes/templates/forms/formulario_newsletter.php'; ?>
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
    <script src="../build/js/header.js"></script>
    <script src="../build/js/index.js"></script>
    <script src="../build/js/ajax.js"></script>
    </body>
</html>      