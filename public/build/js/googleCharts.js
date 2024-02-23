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
  data.addColumn("string", "Navegadores");
  data.addColumn("number", "Slices");

  data.addRows([["nombre", 1]]);

  // Set chart options
  var options = {
    title: "% de navegadores",
    width: 400,
    height: 300,
  };

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.PieChart(
    document.getElementById("chart_div_Aaron")
  );
  chart.draw(data, options);
}
