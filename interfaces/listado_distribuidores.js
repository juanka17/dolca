angular.module('listadoDistribuidoresApp', []).controller('listadoDistribuidoresController', function ($scope, $http) {


    $scope.BuscarDistribuidores = function ()
    {
        var parametros = {catalogo: "cargar_lista_distribuidores"};
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarDistribudores);
    };

    $scope.MostrarDistribudores = function (data)
    {
        $scope.listado_distribuidores = data;
    };

    $scope.EjecutarLlamado = function (modelo, operacion, parametros, CallBack)
    {
        $http({
            method: "POST", url: "clases/jarvis.php", headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            data: {modelo: modelo, operacion: operacion, parametros: parametros}
        }).success(function (data) {
            if (data.error == "")
            {
                CallBack(data.data);
            } else
            {
                console.log(data);
                $scope.errorGeneral = data.error;
            }
        });
    };

    $scope.usuario_en_sesion = usuario_en_sesion;
    $scope.BuscarDistribuidores();
});