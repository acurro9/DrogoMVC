
<link rel="stylesheet" href="../build/css/usuarios.css">
<main>
    <h1 class="abajo">Usuarios</h1>
    <div class="centrado">
        <form class="paginado" method="GET">
        <?php include __DIR__ . '/../../includes/templates/paginado.php'; ?>
        </form>
    </div>

    <table class="tabla">
        <?php include __DIR__ . '/../../includes/templates/tables/tabla_usuarios.php'; ?>
    </table>

    <div class="pagComplete">
        <!-- Implementar la paginación -->
            <?php for($i=1; $i<=$totalPaginas; $i++){ ?>
                <a href="?producto=<?= $ppp ?>&pagina=<?= $i ?>" class="<?= $paginaActual == $i ? 'active' : '' ?>"><?= $i ?></a>
            <?php } ?>
        </div>
    </div>

    <div class="centro">
        <a href="/areaPersonalAdmin" class="buton grande">Volver</a>
    </div>
</main>

<!-- Se incluye los archivos de javascript -->
<script src="../build/js/index.js"></script>
