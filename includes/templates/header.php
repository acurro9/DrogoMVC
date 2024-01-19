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
    <title>Drogo | Plantilla</title>
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
                <?php
                } } else{ ?>
                <!--En caso de que no esté logeado se muestran dos link, para iniciar sesión y para registrarse-->
                  <div class="botones_nav" id="btn_nav">
                    <a href="/login.php" class="btn_nav login_nav">Login</a>
                    <a href="/registro.php" class="btn_nav registro_nav">Registro</a>
                  </div>
              <?php  }?>
            </nav>
              </div>
      <!-- Se incluye los archivos de javascript -->
      <script src="/js/header.js"></script>