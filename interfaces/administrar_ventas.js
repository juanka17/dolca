angular.module('administrarVentasApp', []).controller('administrarVentasController', function ($scope, $http, $document) {

    $scope.nuevo_registro = {elemento: 'cuota', tipo: 'general', id_periodo: 0, valor: 0};

    $scope.CargarPeriodos = function()
    {
        var parametros = { catalogo: "periodos_temporada"};
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarPeriodos);
        $scope.CargarDatosUsuario();
    };
    
    $scope.MostrarPeriodos = function(data)
    {
        $scope.periodos = data;
        $scope.CargarDatosUsuario();
    };

    // <editor-fold defaultstate="collapsed" desc="Datos usuario">
    
    $scope.CargarDatosUsuario = function()
    {
        var parametros = { catalogo: "usuario", id: id_usuario };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarDatosUsuario);
    }; 
    
    $scope.MostrarDatosUsuario = function(data)
    {
        $scope.datos_usuario = data[0];
        $scope.ObtenerDatos();
    };
    
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="Datos">
    
    $scope.ObtenerDatos = function()
    {
        var parametros = { 
            catalogo: "datos_administracion", 
            elemento: $scope.nuevo_registro.elemento, 
            lija_seca: $scope.nuevo_registro.tipo == "general" ? 0 : 1,
            id_usuario: $scope.datos_usuario.id 
        };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarDatos);
    };
    
    $scope.MostrarDatos = function(data)
    {
        $scope.datos = data;
    };
    
    $scope.EliminarRegistro = function(id)
    {
        var elemento = $scope.nuevo_registro.elemento + "s";
        
        var parametros = { 
            catalogo_real: elemento,
            id: id,
            catalogo: "datos_administracion", 
            elemento: $scope.nuevo_registro.elemento, 
            lija_seca: $scope.nuevo_registro.tipo == "general" ? 0 : 1,
            id_usuario: $scope.datos_usuario.id
        };
        $scope.EjecutarLlamado("catalogos", "EliminaCatalogoMixta", parametros, $scope.MostrarDatos);
    };
    
    $scope.CrearRegistro = function()
    {
        var elemento = $scope.nuevo_registro.elemento + "s";
        var columna = $scope.nuevo_registro.elemento;
        
        var datos = {
            id_periodo: $scope.nuevo_registro.id_periodo,
            id_usuario: $scope.datos_usuario.id,
            lija_seca: $scope.nuevo_registro.tipo == "general" ? 0 : 1
        };
        
        datos[columna] = $scope.nuevo_registro.valor;
        
        var parametros = { 
            catalogo_real: elemento,
            catalogo: "datos_administracion", 
            elemento: $scope.nuevo_registro.elemento, 
            lija_seca: $scope.nuevo_registro.tipo == "general" ? 0 : 1,
            id_usuario: $scope.datos_usuario.id,
            datos: datos
        };
        $scope.EjecutarLlamado("catalogos", "RegistraCatalogoMixto", parametros, $scope.MostrarDatos);
        
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
    
    $scope.CargarPeriodos();
});
