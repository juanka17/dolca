angular.module('listadoUsuariosApp', []).controller('listadoUsuariosController', function($scope, $http) {

    $scope.filtros = { cedula: "", nombre: "", telefono: "" };
    $scope.BuscarUsuarios = function() {
        var parametros = {
            cedula: $scope.filtros.cedula,
            nombre: $scope.filtros.nombre,
            telefono: $scope.filtros.telefono
        };
        $scope.EjecutarLlamado("especiales", "cargar_lista_usuarios", parametros, $scope.MostrarUsuarios);
    };

    $scope.MostrarUsuarios = function(data) {
        if (data.ok) {
            $scope.listado_usuarios = data.listado;
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

    $scope.usuario_en_sesion = usuario_en_sesion;
});