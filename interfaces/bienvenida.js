angular.module('bienvenidaApp', []).controller('bienvenidaController', function ($scope, $http) {
    
       
    
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