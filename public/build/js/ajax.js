// Parte de Aarón
$(document).ready(function () {
  $("#ajaxAaron").keyup(function () {
    let valor = $("#ajaxAaron").val();
    $.ajax({
      type: "POST",
      data: {
        param: valor,
      },
      success: function (response) {
        let tr = $(response).find("tr");
        $("table").html(tr);
        $("#ajaxAaron").focus();
        $("#ajaxAaron").val(valor);
      },
      error: function (xhr, status, error) {
        alert("Error: " + xhr.responseText);
      },
    });
  });
});

/**
 * Maneja la búsqueda AJAX de lockers.
 *
 * Esta función se activa cuando se introduce texto en el campo de búsqueda ajaxCristina
 * Realiza una solicitud POST al servidor con el texto de búsqueda y actualiza resultados
 * en la tabla con los datos devueltos.
 */

  $(function(){
    $("#ajaxCristina").on('input', function(){
      $.post('/locker', {ajaxCristina:this.value}, function(data){
        var htmlData = $(data);
        var tbodyTrs = htmlData.find("tbody tr");
        $('table tbody').empty().append(tbodyTrs);
    }).fail(function(xhr){
      alert("Error: "+xhr.responseText);
    });
  });
  });

