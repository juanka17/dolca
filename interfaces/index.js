angular.module('indexApp', []).controller('indexController', function($scope, $http) {

    $scope.datos_usuario = { cedula: "", clave: "" };

    $scope.Login = function() {
        var parametros = {
            cedula: $scope.datos_usuario.cedula,
            clave: $scope.datos_usuario.clave
        };

        $scope.EjecutarLlamado("especiales", "iniciar_sesion_usuario", parametros, $scope.ResultadoLogin);
    };

    $scope.ResultadoLogin = function(data) {
        if (data.ok) {
            document.location.href = "bienvenida.php";
        } else {
            CallToast(data.error);
        }
    };

    $scope.EjecutarLlamado = function(modelo, operacion, parametros, CallBack) {
        $http({
            method: "POST",
            url: "clases/jarvis.php",
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            data: { modelo: modelo, operacion: operacion, parametros: parametros }
        }).success(function(data) {
            if (data.error == "") {
                CallBack(data.data);
            } else {
                console.log(data);
                $scope.errorGeneral = data.error;
            }
        });
    };
});