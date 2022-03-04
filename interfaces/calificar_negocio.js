angular.module('evaluacionApp', []).controller('evaluacionController', function ($scope, $http) {

    $scope.CargarPeriodoActual = function ()
    {
        var parametros = {catalogo: "periodo_actual"};
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.SeleccionarPeriodoActual);
    };

    $scope.SeleccionarPeriodoActual = function (data)
    {
        $scope.periodo_actual = data[0];
        $scope.ValidarEvaluacionTienda();
    };

    $scope.ValidarEvaluacionTienda = function ()
    {
        var parametros = {
            catalogo: "evaluacion_tienda",
            id_usuario: $scope.id_usuario,
            id_periodo: $scope.periodo_actual.id
        };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.ValidarEvaluacion);
    };

    $scope.ValidarEvaluacion = function (data)
    {
        $scope.evaluacion = data;

        if ($scope.evaluacion.length > 0)
        {
            setTimeout(function () {
                $("#img_avisos_foto")      .attr("src", "clases/evaluacion/" + $scope.id_usuario + "_" + $scope.periodo_actual.id + "_img_avisos.jpg");
                $("#img_exhibidores_foto") .attr("src", "clases/evaluacion/" + $scope.id_usuario + "_" + $scope.periodo_actual.id + "_img_exhibidores.jpg");
                $("#img_graphic_floor_foto")    .attr("src", "clases/evaluacion/" + $scope.id_usuario + "_" + $scope.periodo_actual.id + "_img_graphic_floor.jpg");
                $("#img_branding_vehiculo_foto").attr("src", "clases/evaluacion/" + $scope.id_usuario + "_" + $scope.periodo_actual.id + "_img_branding_vehiculo.jpg");
                $("#img_branding_local_foto")   .attr("src", "clases/evaluacion/" + $scope.id_usuario + "_" + $scope.periodo_actual.id + "_img_branding_local.jpg");
            }, 1000);
        }
    };

    $scope.GuardarEvaluacionTienda = function ()
    {
        if ($("#img_avisos").html() != "" && $("#img_exhibidores").html() != "" && $("#img_activaciones").html() != "")
        {
            var evaluacion = {
                id_usuario: $scope.id_usuario,
                id_periodo: $scope.periodo_actual.id,
                avisos: $scope.avisos,
                exhibidores: $scope.exhibidores,
                triciclo: $scope.triciclo,
                graphic_floor: $scope.graphic_floor,
                branding_vehiculo: $scope.branding_vehiculo,
                branding_local: $scope.branding_local,
            };

            var parametros = {
                catalogo: "evaluacion_tienda",
                id_usuario: $scope.id_usuario,
                id_periodo: $scope.periodo_actual.id,
                datos: evaluacion
            };
            $scope.EjecutarLlamado("catalogos", "RegistraCatalogoSimple", parametros, $scope.CargarImagenesEvaluacion);
        } else
        {
            alert("Asegurese de seleccionar imágenes referentes a cada concepto.");
        }
    };

    $scope.CargarImagenesEvaluacion = function ()
    {
        var url = "clases/subir_archivo.php?id_usuario=" + $scope.id_usuario + "&id_periodo=" + $scope.periodo_actual.id;
        var img_avisos = $("#img_avisos").find("img").first().attr("src");
        var img_exhibidores = $("#img_exhibidores").find("img").first().attr("src");
        var img_graphic_floor = $("#img_graphic_floor").find("img").first().attr("src");
        var img_branding_vehiculo = $("#img_branding_vehiculo").find("img").first().attr("src");
        var img_branding_local = $("#img_branding_local").find("img").first().attr("src");

        var base64ImageContentAvisos = img_avisos.replace(/^data:image\/(png|jpeg);base64,/, "");
        var base64ImageContentExhibidores = img_exhibidores.replace(/^data:image\/(png|jpeg);base64,/, "");
        var base64ImageContentGraphicFloor = img_graphic_floor.replace(/^data:image\/(png|jpeg);base64,/, "");
        var base64ImageContentBrandingVehiculo = img_branding_vehiculo.replace(/^data:image\/(png|jpeg);base64,/, "");
        var base64ImageContentBrandingLocal = img_branding_local.replace(/^data:image\/(png|jpeg);base64,/, "");

        var blobAvisos = base64ToBlob(base64ImageContentAvisos, 'image/jpeg');
        var blobExhibidores = base64ToBlob(base64ImageContentExhibidores, 'image/jpeg');
        var blobGraphicFloor = base64ToBlob(base64ImageContentGraphicFloor, 'image/jpeg');
        var blobBrandingVehiculo = base64ToBlob(base64ImageContentBrandingVehiculo, 'image/jpeg');
        var blobBrandingLocal = base64ToBlob(base64ImageContentBrandingLocal, 'image/jpeg');

        var formData = new FormData();
        formData.append('img_avisos', blobAvisos, "img_avisos.jpg");
        formData.append('img_exhibidores', blobExhibidores, "img_exhibidores.jpg");
        formData.append('img_graphic_floor', blobGraphicFloor, "img_graphic_floor.jpg");
        formData.append('img_branding_vehiculo', blobBrandingVehiculo, "img_branding_vehiculo.jpg");
        formData.append('img_branding_local', blobBrandingLocal, "img_branding_local.jpg");

        $.ajax({
            url: url,
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: formData}
        ).done(function (e) {
            console.log(e);
            $scope.ResultadoCargaimagenes();
        });
        console.log(2);
    };

    $scope.ResultadoCargaimagenes = function ()
    {
        $scope.ValidarEvaluacionTienda();
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

    $scope.id_usuario = id_usuario;
    $scope.usuario_en_sesion = usuario_en_sesion;
    $scope.CargarPeriodoActual();
});

$(function () {
    $(".input_foto").on("change", function () {
        $(this).hide();
        handleFiles(this, this.files);
    });

    $("#img_avisos").on("click", function () {
        $(this).hide();
        $(this).html("");
        $($(this).data("upload")).show();
        $($(this).data("upload")).val("");
    });

    $("#img_exhibidores").on("click", function () {
        $(this).hide();
        $(this).html("");
        $($(this).data("upload")).show();
        $($(this).data("upload")).val("");
    });

    $("#img_graphic_floor").on("click", function () {
        $(this).hide();
        $(this).html("");
        $($(this).data("upload")).show();
        $($(this).data("upload")).val("");
    });

    $("#img_branding_vehiculo").on("click", function () {
        $(this).hide();
        $(this).html("");
        $($(this).data("upload")).show();
        $($(this).data("upload")).val("");
    });

    $("#img_branding_local").on("click", function () {
        $(this).hide();
        $(this).html("");
        $($(this).data("upload")).show();
        $($(this).data("upload")).val("");
    });
});

function handleFiles(input, files) {
    var file = files[0];
    var canvas = document.createElement("canvas");
    var ctx = canvas.getContext('2d');
    var img = new Image;
    console.log(file);
    var img_obj = document.createElement("img");
    img.onload = function () {
        var proporcion = 1024;
        var width = proporcion;
        var height = (img.height * proporcion) / img.width;
        canvas.width = width;
        canvas.height = height;
        ctx.drawImage(img, 0, 0, width, height);

        img_obj.src = canvas.toDataURL("image/jpeg");
        img_obj.style.width = width;
        img_obj.style.height = height;

        $($(input).data("img")).append(img_obj);
        $($(input).data("img")).show();
        console.log($($(input).data("img")).find("img").first());
    };
    img.src = URL.createObjectURL(file);
}

function base64ToBlob(base64, mime)
{
    mime = mime || '';
    var sliceSize = 1024;
    var byteChars = window.atob(base64);
    var byteArrays = [];

    for (var offset = 0, len = byteChars.length; offset < len; offset += sliceSize) {
        var slice = byteChars.slice(offset, offset + sliceSize);

        var byteNumbers = new Array(slice.length);
        for (var i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
        }

        var byteArray = new Uint8Array(byteNumbers);

        byteArrays.push(byteArray);
    }

    return new Blob(byteArrays, {type: mime});
}