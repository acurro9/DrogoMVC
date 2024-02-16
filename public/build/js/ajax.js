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
