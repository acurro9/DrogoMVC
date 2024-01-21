<?php
//Para la tabla de los lockers
    //En caso de no estar logueado y no ser el administrador nos redirige al index.php
    $auth=$_SESSION['login']??false;
    if(!$auth || $_SESSION['tipo']!='Administrador'){
        header('Location: /');
    }

    //Se inicializan las variables a vacio
    $id="";

    //Se realiza la consulta para tener el nº total de lockers
    $consultaCont="SELECT count(*) as contador FROM locker;";
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
        $cant="No hay lockers.";
    } else{
        //Se coge el total de páginas redondeando hacia arriba
        $totalPaginas=ceil($cantPropiedades/$ppp);
        //Se calculan el limit y el offset
        $offset=($pagina-1)*$ppp;
        $limit= $ppp;
        $cant="";
    }
    //Se crea la query para mostrar los datos y se envia al servidor
    $query = "SELECT refLocker, direccion, passwordLocker from locker limit $limit offset $offset;";
    $datos = mysqli_query($db, $query);

    // En caso de realizar el post para la eliminación
    if ($_SERVER['REQUEST_METHOD']==='POST'){
        //Se guarda la referencia y se realiza la consulta para la eliminación, en caso de ser correcto aparece un mensaje exito
        $id=$_POST['refLocker'];
        $consulta="DELETE from locker where refLocker='$id';";
        $result=mysqli_query($db, $consulta);
        if($result){
            header("Location: /Lockers/lockers.php?res=3");
        }
    }
    
?>
<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/lockers.css">
<main>
    <h1 class="abajo">Lockers: </h1>
    <div class="centrado">
        <!--Se le pide al usuario el número de pedidos por página-->
        <form class="paginado">
        <?php include __DIR__ . '/../../includes/templates/paginado.php'; ?>
        </form>

    </div>
    <!-- Si no hay lockers se imprime -->
<?php echo '<p class="error">'.$cant.'</p>'?>
    <table>
    <?php include __DIR__ . '/../../includes/templates/tables/tabla_lockers.php'; ?>
    </table>
        <!--Para moverse entre las páginas-->
        <div class="pagComplete">
            <?php if($cantPropiedades!=0){ if($pagina>1){?>
                
            <a class="pag" href="/Lockers/lockers.php?producto=<?php echo $ppp;?>&pagina=<?php echo $pagina-1?>"><</a><?php } ?>
            <?php for($i=0; $i<$totalPaginas; $i++){ ?>
                <a class="pag" href="/Lockers/lockers.php?producto=<?php echo $ppp;?>&pagina=<?php echo $i+1;?>" <?php echo $pagina==$i+1?'style="color: #71B100; font-weight: 800;"':'';?>><?php echo $i+1;?></a>
                <?php } 
                if($pagina<$totalPaginas){
                    ?>
            <a class="pag" href="/Lockers/lockers.php?producto=<?php echo $ppp;?>&pagina=<?php echo $pagina+1?>">></a>
                    <?php } } ?>
        </div>
    <div class="centro">
        <a href="/Lockers/crearLockers.php" class="buton grande">Crear Locker</a>
    </div>
</main>
<!-- Se incluye los archivos de javascript -->
<script src="../build/js/index.js"></script>