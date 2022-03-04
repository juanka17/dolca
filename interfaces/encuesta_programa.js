angular.module('encuestaProgramaApp', []).controller('encuestaProgramaController', function ($scope, $http) {

    $scope.index_1 = 0;
    $scope.index_2 = 0;
    $scope.index_3 = 0;
    $scope.index_4 = 0;
    $scope.index_5 = 0;
    $scope.recomendaciones = "";
    $scope.otros = "";
    
    $scope.ObtenerEncuestaUsuario = function()
    {
        var parametros = {catalogo: "encuesta_programa_usuario", id_usuario: id_usuario};
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarEncuestaUsuario);
    };
    
    $scope.encuesta = { id: 0 };
    $scope.MostrarEncuestaUsuario = function(data)
    {
        if(data.length > 0)
        {
            $scope.encuesta = data[0];
            console.log($scope.encuesta);
            $scope.encuesta.otros = $scope.encuesta.p1.toString().indexOf("4") > -1 ? $scope.encuesta.p1.toString().split("|")[1] : "";
            $scope.encuesta.p1 = $scope.encuesta.p1.toString().indexOf("4") > -1 ? 4 : $scope.encuesta.p1;
        }
    };
    
    $scope.RegistrarEncuesta = function()
    {
        if( 
            $scope.index_1 > 0 && 
            $scope.index_2 > 0 && 
            $scope.index_3 > 0 && 
            $scope.index_4 > 0 && 
            $scope.index_5 > 0
        )
        {
            var encuesta = {
                id_usuario: id_usuario,
                p1: $scope.index_1 == 4 ? ("4|" + $scope.otros) : $scope.index_1,
                p2: $scope.index_2,
                p3: $scope.index_3,
                p4: $scope.index_4,
                p5: $scope.index_5,
                p6: $scope.recomendaciones
            };

            var parametros = {
                catalogo: "encuesta_programa_usuario", 
                catalogo_real: "encuesta_programa", 
                datos: encuesta,
                id_usuario: id_usuario
            };

            $scope.EjecutarLlamado("catalogos", "RegistraCatalogoMixto", parametros, $scope.MostrarEncuestaUsuario);
        }
        else
        {
            CallToast("Complete todos los datos.");
        }
    };

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
    
    $scope.ObtenerEncuestaUsuario();
});