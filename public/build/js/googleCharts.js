// Google Charts Aarón

// Load the Visualization API and the corechart package.
google.charts.load("current", { packages: ["corechart"] });

// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(drawCharts);


// Callback that creates and populates a data table,
// instantiates the pie chart, passes in the data and
// draws it.
function drawChartCompradores() {
  // Create the data table.
  var data = new google.visualization.DataTable();
  data.addColumn("string", "Compradores");
  data.addColumn("number", "Pedidos");

  // Create pie chart
  datosComp.forEach((comprador) => {
    data.addRow(comprador);
  });

  // Set chart options
  var options = {
    title: "Pedidos por comprador",
    width: 500,
    height: 400,
    is3D: true,
  };

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.PieChart(
    document.getElementById("chart_div_Aaron")
  );
  chart.draw(data, options);
}


//Google Charts Cristina
function drawChartVendedores() {
  // Arreglo predefinido de colores para que cada barra sea distinta
  var colores = ["silver", "gold", "blue"];
  //Se mapea por nombre de vendedor, cantidad de pedidos para poder generar la tabla y ajustar a los parámetros exigidos del arrayToData
  var data = google.visualization.arrayToDataTable([
    ["Vendedor", "Pedidos", { role: "style" }],
    ...datosVend.map((vendedor, indice) => [
      vendedor[0], 
      vendedor[1], 
      //Para que itere sobre el arreglo de colores y genere uno distinto
      colores[indice % colores.length] 
    ])
  ]);
  

  var view = new google.visualization.DataView(data);
  view.setColumns([0, 1,
                   { calc: "stringify",
                     sourceColumn: 1,
                     type: "string",
                     role: "annotation" },
                   2]);

  var options = {
    title: "Pedidos por vendedor",
    width: 500,
    height: 400,
    bar: {groupWidth: "95%"},
    legend: { position: "none" },
  };

  var chart = new google.visualization.ColumnChart(document.getElementById("chart_div_Cris"));
  chart.draw(view, options);
}


function drawCharts() {

  drawChartCompradores();
  drawChartVendedores();
}