$(document).foundation();

if($('#txt_fecha_nacimiento').length > 0)
{
    $('#txt_fecha_nacimiento').fdatepicker({
        format: 'yyyy-mm-dd',
        disableDblClickSelection: true,
        language: 'es'
    });    
}

function CallToast(message) {
    $("#snackbar").html(message);
    var x = document.getElementById("snackbar");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

$(function() {
  $("#main ul li a").click(function() {
    // quitar .seleccionado a todos (por si hay alguno)
    $("#main ul li a").removeClass("seleccionado");
    // agregar seleccionado a "este" elemento.
    $(this).addClass("seleccionado");
  });
});