angular.module('subirArchivosApp', ['angular.filter']).controller('subirArchivosController', function($scope, $http) {

    $scope.Profiles = [{
        codigo: "",
        lote: "",
        fecha: ""
    }];

    $scope.entity = {};

    $scope.delete = function(index) {
        $scope.Profiles.splice(index, 1);
    };

    $scope.add = function() {
        $scope.Profiles.push({
            codigo: "",
            lote: "",
            fecha: ""
        });
    };


    $scope.ObtenerTipoProducto = function() {
        var parametros = {
            catalogo: "tipo_productos",
            id_usuario: id_usuario
        };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarTipoProducto);
    };

    $scope.MostrarTipoProducto = function(data) {
        $scope.tipo_productos = data;
    };

    $scope.ObtenerProductos = function(id_tipo_producto) {
        var parametros = {
            catalogo: "productos",
            id_tipo_producto: id_tipo_producto
        };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarProductos);
    };

    $scope.MostrarProductos = function(data) {
        $scope.productos = data;
    };

    $scope.CargarProductos = function() {
        var url = "clases/cargar_archivos.php";

        var jsonSent = JSON.stringify($scope.Profiles, function(key, value) {
            if (key === "$$hashKey") {
                return undefined;
            }

            return value;
        });

        var formData = new FormData();
        formData.append('id_tipo_producto', $("#id_tipo_producto").val());
        formData.append('id_producto', $("#id_producto").val());
        formData.append('id_usuario', id_usuario);
        formData.append('id_registra', usuario_en_sesion.id);
        formData.append('dinamyc', jsonSent);

        $.ajax({
            url: url,
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: formData
        }).done(function(e) {
            $scope.ObtenerProductosRegistrados();
        });


        document.getElementById("dataForm").reset();
        $scope.Profiles = [{
            codigo: "",
            lote: "",
            fecha: ""
        }];
    };

    $scope.ObtenerProductosRegistrados = function() {
        var parametros = {
            catalogo: "verificar_producto",
            id_participante: id_usuario
        };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarProductosRegistrados);
    };

    $scope.MostrarProductosRegistrados = function(data) {

        $scope.productos_registrados = data;
        $('#productos').foundation('open');

        $scope.profiles_factura = [{
            id_producto: "",
            valor: ""
        }];
        console.log($scope.profiles_factura)
        $scope.entity = {};

        $scope.deleteProducto = function(index) {
            $scope.profiles_factura.splice(index, 1);
        };

        $scope.addProducto = function() {
            $scope.profiles_factura.push({
                id_producto: "",
                valor: ""
            });
        };
    };

    // </editor-fold 

    $scope.GuardarDatosFactura = function() {
        var url = "clases/guardar_archivos_factura.php";

        var jsonSent = JSON.stringify($scope.profiles_factura, function(key, value) {
            if (key === "$$hashKey") {
                return undefined;
            }

            return value;
        });

        var formDataFactura = new FormData();
        formDataFactura.append('lugar_factura', $("#lugar_factura").val());
        formDataFactura.append('fecha_registro', $("#fecha_factura_compra").val());
        formDataFactura.append('id_usuario', id_usuario);
        formDataFactura.append('id_registra', usuario_en_sesion.id);
        formDataFactura.append('dinamyc', jsonSent);

        $.ajax({
            url: url,
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: formDataFactura
        }).done(function(e) {
            console.log(e)
        });


        document.getElementById("dataFormFactura").reset();
        $scope.profiles_factura = [{
            id_producto: "",
            valor: ""
        }];
    };

    $scope.ObtenerProductosValidados = function() {
        var parametros = {
            catalogo: "verificar_producto",
            id_participante: id_usuario
        };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarProductosValidados);
    };

    $scope.MostrarProductosValidados = function(data) {
        $scope.productos_validados = data;
        $scope.ValidarValorTotal();
    };

    $scope.ValidarValorTotal = function() {
        var parametros = {
            catalogo: "validar_valor_total",
            id_participante: id_usuario
        };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarTotalProductosValidados);
    };

    $scope.MostrarTotalProductosValidados = function(data) {
        $scope.total_valor = data;
        if ($scope.total_valor[0].mecanica > 20000) {
            $scope.residual = $scope.total_valor[0].mecanica - 20000;
        } else {
            $scope.residual = $scope.total_valor[0].mecanica - 20000;
        }
        $('#bonos').foundation('open');
    };

    $scope.SolicitarBono = function(id_registro, valor) {
        $scope.id_registro = id_registro;
        $scope.valor = valor;

        var parametros = {
            catalogo: "obtener_bono",
            valor: $scope.valor
        };

        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarBonoSolicitado);
    };

    $scope.MostrarBonoSolicitado = function(data) {
        $scope.bono = data;

        var parametros = {
            catalogo: "guardarBono",
            id_registro: $scope.id_registro,
            id_participante: id_usuario,
            id_bono: $scope.bono[0].id,
            id_registra: usuario_en_sesion.id

        };
        $('#bonos').foundation('close');
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.BonoSolicitado);

    };

    $scope.BonoSolicitado = function() {
        $('#bonoseleccionado').foundation('open');
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
    $scope.id_usuario = id_usuario;
    $scope.ObtenerTipoProducto();
});