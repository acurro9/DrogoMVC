// Parte de Aarón
$(document).ready(function () {
  $("#ajaxAaron").keyup(function () {
    let valor = $("#ajaxAaron").val();
    $.ajax({
      type: "POST",
      data: {
        param: valor,
      },
      beforeSend: function () {},
      success: function (response) {
        $("body").html(response);
        $("#ajaxAaron").focus();
        $("#ajaxAaron").val(valor);
        console.log(response);
      },
      error: function (xhr, status, error) {
        alert("Error: " + xhr.responseText);
      },
    });
  });
});
