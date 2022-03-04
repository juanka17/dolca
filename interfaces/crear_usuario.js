angular.module('datosUsuarioApp', []).controller('datosUsuarioController', function($scope, $http) {

    $scope.datos_usuario = {
        nombre: "",
        tipo_documento: "",
        documento: "",
        correo: "",
        telefono: ""
    };

    $scope.ObtenerTipoDocumento = function() {

        var parametros = {
            catalogo: "tipo_documento"
        };

        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarTipoDocumento);
    };

    $scope.MostrarTipoDocumento = function(data) {
        $scope.tipo_documento = data;
    };

    // <editor-fold defaultstate="collapsed" desc="Datos básicos">

    $scope.CrearUsuario = function() {

        let datos = {
            nombre: $scope.datos_usuario.nombre,
            id_tipo_doc: $scope.datos_usuario.tipo_documento,
            documento: $scope.datos_usuario.documento,
            correo: $scope.datos_usuario.correo,
            telefono: $scope.datos_usuario.telefono,
            id_rol: 2,
            id_creacion: $scope.usuario_en_sesion.id
        }

        var parametros = {
            catalogo_real: "participantes",
            datos: datos
        };
        $scope.EjecutarLlamado("especiales", "crear_usuario", parametros, $scope.ResultadoCreacionUsuario);

    };

    $scope.ResultadoCreacionUsuario = function(data) {
        console.log(data)
        if (data.ok) {
            document.location.href = "subir_productos.php?id_usuario=" + data.datos_usuario;
        } else {
            alert(data.error);
        }
    };

    // </editor-fold>

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
    $scope.ObtenerTipoDocumento();
});