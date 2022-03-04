angular.module('listadoNegocioApp', []).controller('listadoNegocioController', function ($scope, $http) {
    
     $scope.filtros = {nombre: ""};
    // <editor-fold defaultstate="collapsed" desc="Negocios">
    
    $scope.MostrarNegocios = function()
    {                    
        var parametros = {
            catalogo: "negocio"
        };
        
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.ResultadoNegocio);        
    };
    
    $scope.ResultadoNegocio = function(data)
    {
        $scope.negocio = data;
        $scope.SeleccionarListadoNegocios();
    };
    
    $scope.lista_negocio = Array();
    $scope.SeleccionarListadoNegocios = function()
    {
        $scope.lista_negocio = Array();
        angular.forEach($scope.negocio, function(negocio){
            
            if(negocio.negocio != null)
            {
                if(
                    $scope.filtros.nombre.length == 0 || negocio.negocio.toString().toLowerCase().indexOf($scope.filtros.nombre.toLowerCase()) > -1
                )
                {
                    if($scope.lista_negocio.length < 50)
                    {
                        $scope.lista_negocio.push(negocio);
                    }
                }
            }
                
        });
        
    };
    
    // </editor-fold>
    
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
    $scope.MostrarNegocios();
});