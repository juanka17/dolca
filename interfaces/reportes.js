angular.module('reportesApp', []).controller('reportesController', function ($scope, $http) {
    
    $scope.CargarReporte = function()
    {
        if($scope.reporte_seleccionado != "")
        {
            var parametros = {};
            $scope.EjecutarLlamado("reportes", $scope.reporte_seleccionado, parametros, $scope.MostrarReporte);
        }
        else
        {
            CallToast("Seleccione un reporte para descargar.");
        }
    };
    
    $scope.data_reporte = null;
    $scope.MostrarReporte = function(data)
    {
        $scope.data_reporte = data;
        dataReporte = $scope.data_reporte;
        
        var htmlTable = Array();
        htmlTable.push("<table class='table table-striped'>");
        htmlTable.push("<thead><tr>");
        $.each(data.header, function(index, column){
            htmlTable.push("<th>" + column + "</th>");
        });
        htmlTable.push("<tr></thead>");

        htmlTable.push("<tbody>");
        $.each(data.data, function(index, row){
            if(index < 50)
            {
                htmlTable.push("<tr>");
                $.each(row, function(rowIndex, cell){
                    htmlTable.push("<td>" + cell + "</td>"); 
                });
                htmlTable.push("</tr>");
            }
            else
            {
                return false;
            }
        });
        htmlTable.push("</tbody>");
        htmlTable.push("</table>");
        
        $("#contenedorTabla").html(htmlTable.join(""));
    };
    
    $scope.DescargarReporte = function()
    {
        var nombre_reporte = "Reporte" + Capitalize($scope.reporte_seleccionado) + "_" + moment().format("YYYYMMDD");
        nombre_reporte+=".csv";
        ExportarReporte(nombre_reporte);
    };
    
    $scope.EjecutarLlamado = function(modelo, operacion, parametros, CallBack)
    {
        $http({ 
            method: "POST", url: "clases/jarvis.php", headers: {'Content-Type': 'application/x-www-form-urlencoded'}, 
            data: { modelo: modelo, operacion: operacion, parametros: parametros }
        }).success(function(data){
            if(data.error == "")
            {
                CallBack(data.data);
            }
            else
            {
                console.log(data);
                $scope.errorGeneral = data.error;
            }
        });
    };
    
    $scope.usuario_en_sesion = usuario_en_sesion;
});

var dataReporte = null;
function ExportarReporte(reporteNombre)
{
    if(dataReporte == null)
    {
        CallToast("No se ha cargado un reporte.");
        return false;
    }
    
    var csv = JSON2CSV(dataReporte);
    
    var downloadLink = document.createElement("a");
    var blob = new Blob(["\ufeff", csv]);
    var url = URL.createObjectURL(blob);
    
    downloadLink.href = url;
    downloadLink.download = reporteNombre;
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink); 
}

function JSON2CSV(objArray) {
    
    var array = objArray;

    var str = '';
    var line = '';

    if (true) 
    {
        var head = array[0];
        $.each(array.header, function(index, cell){
            line += cell + ';';
        });

        line = line.slice(0, -1);
        str += line + '\r\n';
    }

    for (var i = 0; i < array.data.length; i++) {
        var line = '';

        for (var index in array.data[i]) {
            line += array.data[i][index] + ';';
        }
        line = line.replace(/\r?\n/g, "");
        line = line.slice(0, -1);
        str += line + '\r\n';
    }
    return str;
}

function Capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}