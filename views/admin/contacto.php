<?php 
//Para la tabla de los mensajes enviados através del formulairo de contacto
    //En caso de no estar logueado y no ser el administrador nos redirige al index.php
    $auth=$_SESSION['login']??false;
    if(!$auth || $_SESSION['tipo']!='Administrador'){
        header('Location: /');
    }

    //Se realiza la consulta para tener el nº total de propiedades
    $consultaCont="SELECT count(*) as contador FROM contacto;";
    $datosCont=mysqli_query($db,$consultaCont);
    $data=mysqli_fetch_assoc($datosCont);
    $cantPropiedades=$data['contador'];
    $cantPropiedades2=$data['contador'];

    /*Se crean las variables para la paginacion
    Por defecto los productos por pagina son 5 y la página es 1, si en la url está presente cambia*/
    $ppp = 5;
    if (isset($_GET["producto"])) {
        $ppp = $_GET["producto"];
    }
    $pagina = 1;
    if (isset($_GET["pagina"])) {
        $pagina = $_GET["pagina"];
    }
    if($cantPropiedades==0){
        $totalPaginas=1;
        $offset=0;
        $limit=10;
        $cant="No hay mensajes de contacto.";
    } else{
        //Se coge el total de páginas redondeando hacia arriba
        $totalPaginas=ceil($cantPropiedades/$ppp);
        //Se calculan el limit y el offset
        $offset=($pagina-1)*$ppp;
        $limit= $ppp;
        $cant="";
    }
    //Guardamos el tipo del usuario y la respuesta a la acción realizada
    $res=$_GET['res']??NULL;
    $tipo=$_SESSION['tipo'];

    $query="SELECT * from contacto limit $limit offset $offset;";
    $datos=mysqli_query($db, $query);
    
    //En caso de hacer el post en el fomulario
    if ($_SERVER['REQUEST_METHOD']==='POST'){
        //Se guardan las variables del id y se crea la consulta para eliminar
        $id=$_POST['id'];
        $consulta="DELETE from contacto where id='$id';";
        $result=mysqli_query($db, $consulta);
        //En caso de que se realize la query
        if($result){
            header("Location: /Admin/contacto.php?res=1");
        }
    }
    
?>
<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/mensaje.css">
<link rel="stylesheet" href="../build/css/styles.css">
<main>
<h1 class="abajo">Contacto</h1>
<div class="centrado">
        <!--Se le pide al usuario el número de pedidos por página-->
        <form class="paginado">
        <?php include __DIR__ . '/../../includes/templates/paginado.php'; ?>
        </form>
    </div>
<main>
    
    <table class="tabla">
    <?php
    //En caso de que el resultado sea 1
        if(intval($res)===1){?>
            <p class="success">Mensaje borrado con exito.</p>
        <?php } ?>
        <?php echo '<p class="error">'.$cant.'</p>'?>
        <!-- Tabla de los mensajes -->
        <?php include __DIR__ . '/../../includes/templates/tables/tabla_contacto.php'; ?>
    </table>
    <!--Para moverse entre las páginas-->
    <div class="pagComplete">
            <?php if($cantPropiedades!=0){ if($pagina>1){?>
                
            <a class="pag" href="/Admin/contacto.php?producto=<?php echo $ppp;?>&pagina=<?php echo $pagina-1?>"><</a><?php } ?>
            <?php for($i=0; $i<$totalPaginas; $i++){ ?>
                <a class="pag" href="/Admin/contacto.php?producto=<?php echo $ppp;?>&pagina=<?php echo $i+1;?>" <?php echo $pagina==$i+1?'style="color: #71B100; font-weight: 800;"':'';?>><?php echo $i+1;?></a>
                <?php } 
                if($pagina<$totalPaginas){
                    ?>
            <a class="pag" href="/Admin/contacto.php?producto=<?php echo $ppp;?>&pagina=<?php echo $pagina+1?>">></a>
                    <?php } } ?>
        </div>
</main>
<!-- Se incluye los archivos de javascript -->
<script src="../build/js/index.js"></script>
