angular.module('capacitacionApp', []).controller('capacitacionController', function ($scope, $http) {

    $scope.rta1 = false;
    $scope.rta2 = false;
    $scope.rta3 = false;
    $scope.rta4 = false;
    $scope.rta5 = false;
    $scope.rta6 = false;
    $scope.rta7 = false;
    $scope.rta8 = false;
    $scope.rta9 = false;
    $scope.rta10 = false;
    $scope.rta11 = false;
    $scope.rta12 = false;
    $scope.rta13 = false;
    $scope.rta14 = false;
    $scope.rta15 = false;
    

    $scope.respuestas = [0,0,0,0,0];
    $scope.CambiarCalificacionPregunta = function(value, index)
    {
        console.log(index);
        console.log(value);
        $scope.respuestas[index] = value;
    };
    
    $scope.EnviarRespuestas = function()
    {
        var total = 0;
        angular.forEach($scope.respuestas, function(value){
            total += value;
        });
        alert("Respuestas correctas: " + total);
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