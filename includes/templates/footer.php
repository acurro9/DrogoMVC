<?php
//Se realiza la conexion a la base de datos
    $db=mysqli_connect('localhost', 'root', '', 'drogoDB');

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
    <script src="/js/index.js"></script>
    </body>
</html>