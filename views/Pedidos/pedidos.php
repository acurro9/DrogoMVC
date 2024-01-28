<?php
session_start();
    $tipo = $_SESSION['tipo'];
?>
<!--Se importan los css necesarios-->
<link rel="stylesheet" href="../build/css/pedidos.css">
<link rel="stylesheet" href="../build/css/styles.css">
<main>
    <h1 class="abajo">Pedidos</h1>
    <div class="centrado">
        <!--Se le pide al usuario el número de pedidos por página-->
        <form class="paginado">
        <?php include __DIR__ . '/../../includes/templates/paginado.php'; ?>
        </form>
    </div>
    
    <table class="tabla">
  
    <?php include __DIR__ . '/../../includes/templates/tables/tabla_pedidos.php'; ?>
    </table>
    <!--Para moverse entre las páginas-->
    <div class="pagComplete">
        <!-- Implementar la paginación -->
            <?php for($i=1; $i<=$totalPaginas; $i++){ ?>
                <a href="?producto=<?= $ppp ?>&pagina=<?= $i ?>" class="<?= $paginaActual == $i ? 'active' : '' ?>"><?= $i ?></a>
            <?php } ?>
        </div>
        <?php
            if($_SESSION['tipo']=='Administrador'){
        ?>
            <div class="centro">
                <a href="/crearPedido" class="buton grande">Crear Pedido</a>
            </div>
        <?php } ?>
</main>
<!-- Se incluye los archivos de javascript -->
<script src="../build/js/index.js"></script>