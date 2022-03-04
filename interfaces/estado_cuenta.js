angular.module('estadoCuentaApp', []).controller('estadoCuentaController', function ($scope, $http, $document) {

    // <editor-fold defaultstate="collapsed" desc="Datos usuario">

    $scope.CargarDatosUsuario = function ()
    {
        var parametros = {catalogo: "usuario", id: id_usuario};
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarDatosUsuario);
    };

    $scope.MostrarDatosUsuario = function (data)
    {
        $scope.datos_usuario = data[0];
        $scope.ObtenerEstadoCuenta();
    };

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Estado de Cuenta">

    $scope.filtros = {cedula: "", nombre: ""};
    $scope.ObtenerEstadoCuenta = function ()
    {
        var parametros = {catalogo: "estado_cuenta", id_usuario: id_usuario};
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarEstadoCuenta);
    };

    $scope.MostrarEstadoCuenta = function (data)
    {
        console.log(data);
        var periodos = Array();
        var periodo_actual = {id_periodo: 0, periodo: "", registros: []};
        angular.forEach(data, function (registro) {

            if (periodo_actual.id_periodo != registro.id_periodo)
            {
                if (periodo_actual.id_periodo > 0)
                {
                    console.log(periodo_actual);
                    periodos.push(periodo_actual);
                    periodo_actual = {id_periodo: 0, periodo: "", registros: []};
                }

                periodo_actual.id_periodo = registro.id_periodo;
                periodo_actual.periodo = registro.periodo;
                periodo_actual.registros = [];
            }
            periodo_actual.registros.push(registro);

        });
        periodos.push(periodo_actual);
        console.log(periodos);
        $scope.estado_cuenta = periodos;

        console.log(periodos.length);
        if (periodos.length > 0)
        {
            setTimeout(function () {
                $scope.AbrirPanelPeriodo(periodos[0].id_periodo);
            }, 500);

        }
        $scope.ObtenerPuntosPendientes();
    };
    
    $scope.AbrirPanelPeriodo = function (id_periodo)
    {
        $('#pnl_estado_cuenta').foundation('toggle', $("#panel_" + id_periodo));
    };

    // </editor-fold>  

    // <editor-fold defaultstate="collapsed" desc="Puntos Pedientes">

    $scope.ObtenerPuntosPendientes = function ()
    {
        var parametros = {catalogo: "puntos_pendientes", id_usuario: id_usuario};
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarPuntosPendientes);
    };

    $scope.MostrarPuntosPendientes = function (data)
    {
        $scope.puntos_pendientes = data;
        $scope.ObtenerTotalPuntosPendientes();
    };

    $scope.ObtenerTotalPuntosPendientes = function ()
    {
        var parametros = {catalogo: "total_puntos_pendientes", id_usuario: id_usuario};
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarTotalPuntosPendientes);
    };

    $scope.MostrarTotalPuntosPendientes = function (data)
    {
        $scope.total_puntos_pendientes = data;
        $scope.ObtenerPuntosUsuario();
    }
    // </editor-fold>  

    // <editor-fold defaultstate="collapsed" desc="Redenciones">
    $scope.ObtenerRedenciones = function ()
    {
        var parametros = {catalogo: "redenciones_usuario", id_usuario: id_usuario};
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarRedenciones);
    };

    $scope.MostrarRedenciones = function (data)
    {
        $scope.redenciones = data;
        $scope.ObtenerPuntosUsuario();
    };
    // </editor-fold>  

    // <editor-fold defaultstate="collapsed" desc="Puntos Usuarios">
    
    $scope.ObtenerPuntosUsuario = function ()
    {
        var parametros = {catalogo: "puntos_usuario", id_usuario: id_usuario};
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarPuntosUsuario);
    };

    $scope.MostrarPuntosUsuario = function (data)
    {
        $scope.puntos_usuario = data;
    };
    
    // </editor-fold> 
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
    $scope.CargarDatosUsuario();
});
