<?php 
//Para la tabla de los usuarios suscritos al newsletters
    //En caso de no estar logueado y no ser el administrador nos redirige al index.php
    $auth=$_SESSION['login']??false;
    if(!$auth || $_SESSION['tipo']!='Administrador'){
        header('Location: /');
    }
    $res=$_GET['res']??NULL;
    $tipo=$_SESSION['tipo'];

    //Se realiza la consulta para tener los correos del newsletter
    $consultaCont="SELECT count(*) as contador FROM newsletter;";
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
        $cant="No hay emails para el newsletter.";
    } else{
        //Se coge el total de páginas redondeando hacia arriba
        $totalPaginas=ceil($cantPropiedades/$ppp);
        //Se calculan el limit y el offset
        $offset=($pagina-1)*$ppp;
        $limit= $ppp;
        $cant="";
    }

    //Se realiza la query
    $query="SELECT * from newsletter limit $limit offset $offset;";
    $datos=mysqli_query($db, $query);

    //En caso de hacer el post de eliminar
    if ($_SERVER['REQUEST_METHOD']==='POST'){
        //Se guardan el id y se realiza la query
        $id=$_POST['id'];
        $consulta="DELETE from newsletter where email='$id';";
        $result=mysqli_query($db, $consulta);
        if($result){
            header("Location: /Admin/newsletter.php?res=1");
        }
    }
    
?>
<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/mensaje.css">
<link rel="stylesheet" href="../build/css/styles.css">

<main>
<h1 class="abajo">Newsletter</h1>
<div class="centrado">
        <!--Se le pide al usuario el número de pedidos por página-->
        <form class="paginado">
        <?php include __DIR__ . '/../../includes/templates/paginado.php'; ?>
        </form>
    </div>
<main>
    <!-- Tabla del newsletter -->
    <table class="tabla dos">
    <?php
    // En caso del resultado ser 1
        if(intval($res)===1){?>
            <p class="success">Usuario borrado con exito.</p>
        <?php } ?>
        <?php echo '<p class="error">'.$cant.'</p>'?>
        <?php include __DIR__ . '/../../includes/templates/tables/tabla_newsletter.php'; ?>
    </table>
    <!--Para moverse entre las páginas-->
    <div class="pagComplete">
            <?php if($cantPropiedades!=0){ if($pagina>1){?>
                
            <a class="pag" href="/Admin/newsletter.php?producto=<?php echo $ppp;?>&pagina=<?php echo $pagina-1?>"><</a><?php } ?>
            <?php for($i=0; $i<$totalPaginas; $i++){ ?>
                <a class="pag" href="/Admin/newsletter.php?producto=<?php echo $ppp;?>&pagina=<?php echo $i+1;?>" <?php echo $pagina==$i+1?'style="color: #71B100; font-weight: 800;"':'';?>><?php echo $i+1;?></a>
                <?php } 
                if($pagina<$totalPaginas){
                    ?>
            <a class="pag" href="/Admin/newsletter.php?producto=<?php echo $ppp;?>&pagina=<?php echo $pagina+1?>">></a>
                    <?php } } ?>
        </div>
</main>
<!-- Se incluye los archivos de javascript -->
<script src="../build/js/index.js"></script>