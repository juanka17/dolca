angular.module('distribuidoresApp', []).controller('distribuidoresController', function ($scope, $http) {


    $scope.BuscarInventarioDistribuidores = function ()
    {
        var parametros = {catalogo: "inventario_distribuidores",id_distribuidora:id_distribuidora};
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarInventarioDistribuidores );
    };

    $scope.MostrarInventarioDistribuidores = function (data)
    {
        $scope.listado_inventario_distribuidores = data;
        $scope.BuscarInventarioArchivos();
    };
    
    $scope.BuscarInventarioArchivos = function ()
    {
        var parametros = {catalogo: "inventario_archivos",id_almacen:id_distribuidora};
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarInventarioArchivos);
    };

    $scope.MostrarInventarioArchivos = function (data)
    {
        $scope.archivo_listado_inventario = data;
        $scope.RestarInventario();
    };
    
    $scope.RestarInventario = function ()
    {
        var index = 0;
        
        angular.forEach($scope.archivo_listado_inventario, function () {
            
            if($scope.listado_inventario_distribuidores[index].id_fecha == $scope.archivo_listado_inventario[index].id_fecha)
            {
                if($scope.listado_inventario_distribuidores[index].espesor == $scope.archivo_listado_inventario[index].milimetros)
                {
                    console.log("asd");                    
                }                
            }
            index++;
        });
        
        
        
        
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
    $scope.BuscarInventarioDistribuidores();
});