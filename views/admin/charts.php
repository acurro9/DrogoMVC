<link rel="stylesheet" href="../build/css/charts.css">
<main>
    <div id="chart_div_Aaron"></div>
    <div id="chart_div_Cris"></div>
</main>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    var datosComp = <?= json_encode($datosComprador);?>;
    var datosVend = <?= json_encode($datosVendedor);?>;
</script>
<script type="text/javascript" src="../build/js/googleCharts.js"></script>
