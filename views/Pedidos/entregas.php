<?php 
//Para la tabla de distribucines
    //En caso de no estar logueado y no ser el administrador o distribuidor nos redirige al index.php
    $auth=$_SESSION['login']??false;
    if(!$auth || !($_SESSION['tipo']=='Distribuidor'||$_SESSION['tipo']=='Administrador')){
        header('Location: /');
    }

    //Se guarda la respuesta, el tipo de usuario y la id del usuario
    $res=$_GET['res']??NULL;
    $tipo=$_SESSION['tipo'];
    $idU=$_GET['id']??NULL;

    // Se realizan las querys necesarias
    if(!$idU){
        $query="SELECT * from entrega;";
    } else{
        $query="SELECT * from entrega where hash_distribuidor='$idU';";
    }
    $datos=mysqli_query($db, $query);
    
    // En el caso de hacer el POST
    if ($_SERVER['REQUEST_METHOD']==='POST'){
        //Se guarda la id y se realiza la consulta para la eliminación, en caso de ser correcto aparece un mensaje exito
        $id=$_POST['refCompra'];
        $consulta="DELETE from entrega where id='$id';";
        $result=mysqli_query($db, $consulta);
        if($result){
            header("Location: /Pedidos/entregas.php?res=1");
        }
    }
    
?>
<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/pedidos.css">
<link rel="stylesheet" href="../build/css/styles.css">

    <h1>Distribuciones</h1>
    
<main>
    
    <table class="tabla">
    <?php
    // Se imprime el mensaje necesario dependiendo de la respuesta
        if(intval($res)===1){?>
            <p class="success">Entrega eliminada con exito.</p>
        <?php } if(intval($res)===2){?>
        <p class="success">Entrega modificada con exito.</p>
        <?php } ?>
        <?php include __DIR__ . '/../../includes/templates/tables/tabla_envios.php'; ?>
    </table>
    <!-- Si el usuario no es distribuidor puede volver a la tabla pedidos -->
    <?php if($_SESSION['tipo']!='Distribuidor'){?>
        <div class="centro">
            <a href="/Pedidos/pedidos.php" class="buton grande">Ver Pedidos</a>
        </div>
    <?php } ?>
</main>
<!-- Se incluye los archivos de javascript -->
<script src="../build/js/index.js"></script>
