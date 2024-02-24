// Google Charts Aarón

// Load the Visualization API and the corechart package.
google.charts.load("current", { packages: ["corechart"] });

// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(drawChart);

// Callback that creates and populates a data table,
// instantiates the pie chart, passes in the data and
// draws it.
function drawChart() {
  // Create the data table.
  var data = new google.visualization.DataTable();
  data.addColumn("string", "Comnpradores");
  data.addColumn("number", "Pedidos");

  // Create pie chart
  datosComp.forEach((comprador) => {
    data.addRow(comprador);
  });

  // Set chart options
  var options = {
    title: "Pedidos por compador",
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
