angular.module('datosUsuarioApp', []).controller('datosUsuarioController', function($scope, $http) {

    $scope.datos_usuario = { nombre: "", apellido: "", telefono: "", direccion: "", negocio: "", correo: "", documento: "" };



    // <editor-fold defaultstate="collapsed" desc="Datos básicos">

    $scope.CargarDatosUsuarioAdmin = function() {
        var parametros = { catalogo: "usuarios", id: id_usuario };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarDatosUsuario);
    };

    $scope.CargarDatosUsuario = function() {
        var parametros = { catalogo: "participantes", id: id_usuario };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarDatosUsuario);
    };

    var datos_usuario_temp;
    $scope.modificar_ciudad = true;
    $scope.MostrarDatosUsuario = function(data) {
        $scope.datos_usuario = data[0];
        $scope.datos_usu = data[0];
        datos_usuario_temp = angular.copy($scope.datos_usuario);

        $scope.VerificarCiudad();
        $scope.VarificaEstadoClave();
        $scope.VerificarCambios();
    };

    $scope.cambios_informacion = Array();
    $scope.VerificarCambios = function() {
        $scope.cambios_informacion = Array();
        if (JSON.stringify($scope.seleccionado) != JSON.stringify(datos_usuario_temp)) {
            for (var propertyName in $scope.datos_usuario) {
                if (propertyName != "$$hashKey" && $scope.datos_usuario[propertyName] != datos_usuario_temp[propertyName])
                    if (!$scope.cambios_informacion.hasOwnProperty("ID_" + propertyName))
                        $scope.cambios_informacion.push({ property: propertyName, value: $scope.datos_usuario[propertyName] });
            }
        }
    };

    $scope.ActualizarDatosUsuario = function() {
        if ($scope.cambios_informacion.length > 0) {
            var datos = {};
            angular.forEach($scope.cambios_informacion, function(value, key) {
                datos[value.property] = value.value;
            });

            var parametros = {
                catalogo_real: "participantes",
                datos: datos,
                id: $scope.datos_usuario.id
            };

            $scope.EjecutarLlamado("especiales", "actualizar_usuario", parametros, $scope.ResultadoModificacionUsuario);
        }
    };

    $scope.ResultadoModificacionUsuario = function(data) {
        if (data.ok) {
            $scope.datos_usuario = data.datos_usuario;
            datos_usuario_temp = angular.copy($scope.datos_usuario);
            $scope.VerificarCambios();
            $scope.VerificarCiudad();
            CallToast("Datos modificados correctamente");
        } else {
            CallToast(data.error);
        }
    };

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Ciudad">

    $scope.VerificarCiudad = function() {
        $scope.modificar_ciudad = true;
        $scope.nombre_ciudad = "";
        $scope.ciudades = [];
        if ($scope.datos_usuario.id_ciudad > 0) {
            $scope.modificar_ciudad = false;
            $scope.nombre_ciudad = $scope.datos_usuario.ciudad;
        }
    };

    $scope.nombre_ciudad = "";
    $scope.ciudades = [];
    $scope.BuscarCiudad = function() {
        var parametros = { catalogo: "ciudad", nombre_ciudad: $scope.nombre_ciudad };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarCiudades);
    };

    $scope.MostrarCiudades = function(data) {
        $scope.ciudades = data;
    };

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Datos Clave">

    $scope.VarificaEstadoClave = function() {
        if (usuario_en_sesion.id == $scope.datos_usuario.id && $scope.datos_usuario.acepto_terminos == 0) {
            $scope.AbrirModalClave();
        }
    };

    $scope.AbrirModalClave = function() {
        $('#modal_clave').foundation('open');

        $(document).on('closed.zf.reveal', '[data-reveal]', function() {
            $scope.VarificaEstadoClave();
        });
    };

    $scope.datos_clave = { clave_actual: "", clave_nueva: "", clave_confirma: "" };

    $scope.VerificaClave = function() {
        var datos_clave_completos = "";
        if ($scope.datos_usuario.acepto_terminos == 1) {
            if ($scope.datos_clave.clave_actual.trim() == "") {
                datos_clave_completos = "Debes completar la clave actual";
            }
        } else if ($scope.datos_clave.clave_nueva.trim() == "" || $scope.datos_clave.clave_confirma.trim() == "") {
            datos_clave_completos = "Debes completar la clave nueva y la confirmación";
        } else if ($scope.datos_clave.clave_nueva != $scope.datos_clave.clave_confirma) {
            datos_clave_completos = "La clave actual y la confirmación no coinciden.";
        }

        if (datos_clave_completos == "") {
            $scope.ActualizaClave();
        } else {
            CallToast(datos_clave_completos);
        }
    };

    $scope.ActualizaClave = function() {
        var datos = {
            clave_nueva: $scope.datos_clave.clave_nueva,
            clave_confirma: $scope.datos_clave.clave_confirma,
            clave_actual: $scope.datos_clave.clave_actual
        };

        var parametros = {
            acepto_terminos: $scope.datos_usuario.acepto_terminos,
            datos: datos,
            id: $scope.datos_usuario.id
        };

        $scope.EjecutarLlamado("especiales", "actualizar_clave", parametros, $scope.ResultadoActualizacionClave);
    };

    $scope.ResultadoActualizacionClave = function(data) {
        if (data.ok) {
            if ($scope.datos_clave.clave_actual == 0 && $scope.usuario_en_sesion.id_rol != 2) {
                document.location.href = "bienvenida.php";
            } else {
                $scope.datos_clave = { clave_actual: "", clave_nueva: "", clave_confirma: "" };
                $scope.datos_usuario = data.usuario;
                $('#modal_clave').foundation('close');
                CallToast(data.resultado);
            }
        } else {
            CallToast(data.resultado);
        }
    };

    $scope.RestaurarClaveUsuario = function() {
        var parametros = {
            id_usuario: $scope.datos_usuario.id
        };

        $scope.EjecutarLlamado("especiales", "restaurar_clave", parametros, $scope.ResultadoActualizacionClave);
    };

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Llamadas">

    $scope.subCategoria = 0;
    $scope.subcategorias = Array();
    $scope.anteriores = Array();
    $scope.categorias_anteriores = Array();
    $scope.subCategoriaSeleccionada = 0;
    $scope.comentarioLlamadas = '';
    $scope.llamadas_usuario = null;
    $scope.llamada = { COMENTARIO: "", id_subcategoria: 0 };
    var categorias_llamada = null;

    $scope.ObtenerCategoriasLlamada = function() {
        var parametros = { catalogo: "categorias_llamada" };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.CargarSubCategorias);
        $scope.ObtenerLlamadas();
    };

    $scope.CargarSubCategorias = function(data) {
        categoriasLlamada = data;
        $scope.ObtenerSubcategorias(0);
    };

    $scope.ObtenerSubcategorias = function(idParam) {
        $scope.llamada.id_subcategoria = $scope.subCategoria;
        var id = idParam;
        $scope.subCategoriaSeleccionada = id;
        if (idParam == -1) {
            id = $scope.categoriasAnteriores[$scope.categoriasAnteriores.length - 1].ID_PADRE;
            $scope.categoriasAnteriores.pop();
            $scope.anteriores.pop();
            $scope.categoriasAnteriores.pop();
            $scope.anteriores.pop();
        }

        if (idParam == 0) {
            $scope.categoriasAnteriores = Array();
            $scope.anteriores = Array();
        }

        $scope.subCategorias = Array();
        angular.forEach(categoriasLlamada, function(subCategoria) {
            if (id == subCategoria.ID_PADRE)
                $scope.subCategorias.push(subCategoria);

            if (id != 0 && id == subCategoria.ID) {
                $scope.categoriasAnteriores.push(subCategoria);
                $scope.anteriores.push(subCategoria.NOMBRE);
            }
        });
    };

    $scope.ObtenerLlamadas = function() {
        var parametros = { catalogo: "llamadas_usuarios", id_usuario: id_usuario };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarLlamadas);
    };

    $scope.MostrarLlamadas = function(data) {
        $scope.subCategoria = 0;
        $scope.subcategorias = Array();
        $scope.anteriores = Array();
        $scope.categorias_anteriores = Array();
        $scope.subCategoriaSeleccionada = 0;
        $scope.comentarioLlamadas = '';
        $scope.llamadas_usuarios = null;
        $scope.llamada = { comentario: "", id_subcategoria: 0 };
        categorias_llamada = null;

        $scope.llamadas_usuarios = data;
    };

    $scope.RegistraLlamada = function() {
        $scope.llamada.id_usuario = id_usuario;
        $scope.llamada.fecha = moment().format("YYYY-MM-DD HH:mm:ss");
        $scope.llamada.id_usuario_registra = usuario_en_sesion.id;
        var parametros = { catalogo: "llamadas_usuarios", id_usuario: id_usuario, datos: $scope.llamada };
        $scope.EjecutarLlamado("catalogos", "RegistraCatalogoSimple", parametros, $scope.MostrarLlamadas);
    };

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Familiares">

    $scope.ObtenerFamiliares = function() {
        var parametros = { catalogo: "familiares", id_usuario: id_usuario };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarFamiliares);
    };

    $scope.MostrarFamiliares = function(data) {
        $scope.familiar = { nombre: "", relacion: "" };
        $scope.familiares = data;
    };

    $scope.RegistrarFamiliar = function() {
        $scope.familiar.id_usuario = id_usuario;

        var parametros = { catalogo: "familiares", id_usuario: id_usuario, datos: $scope.familiar };
        $scope.EjecutarLlamado("catalogos", "RegistraCatalogoSimple", parametros, $scope.MostrarFamiliares);
    };

    $scope.EliminarFamiliar = function(id_familiar) {
        var parametros = { catalogo: "familiares", id: id_familiar, id_usuario: id_usuario };
        $scope.EjecutarLlamado("catalogos", "EliminaCatalogoSimple", parametros, $scope.MostrarFamiliares);
    };

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Intereses">

    $scope.ObtenerIntereses = function() {
        var parametros = { catalogo: "intereses", id_usuario: id_usuario };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarIntereses);
    };

    $scope.MostrarIntereses = function(data) {
        $scope.interes = { nombre: "", descripcion: "" };
        $scope.intereses = data;
    };

    $scope.RegistrarInteres = function() {
        $scope.interes.id_usuario = id_usuario;

        var parametros = { catalogo: "intereses", id_usuario: id_usuario, datos: $scope.interes };
        $scope.EjecutarLlamado("catalogos", "RegistraCatalogoSimple", parametros, $scope.MostrarIntereses);
    };

    $scope.EliminarInteres = function(id_interes) {
        var parametros = { catalogo: "intereses", id: id_interes, id_usuario: id_usuario };
        $scope.EjecutarLlamado("catalogos", "EliminaCatalogoSimple", parametros, $scope.MostrarIntereses);
    };

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Redenciones">

    $scope.ObtenerRedenciones = function() {
        var parametros = { catalogo: "redenciones_usuario", id_usuario: id_usuario };
        $scope.EjecutarLlamado("catalogos", "CargaCatalogo", parametros, $scope.MostrarRedenciones);
    };

    $scope.MostrarRedenciones = function(data) {
        $scope.redenciones = data;
    };

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Fotos">

    $scope.CargarImagenesEvaluacion = function() {
        var url = "clases/subir_foto.php?id_usuario=" + id_usuario;
        var img_perfil = $("#img_perfil").find("img").first().attr("src");

        var base64ImageContentExhibicion = img_perfil.replace(/^data:image\/(png|jpeg);base64,/, "");

        var blobExhibicion = base64ToBlob(base64ImageContentExhibicion, 'image/jpeg');

        var formData = new FormData();
        formData.append('img_perfil', blobExhibicion, id_usuario + ".jpg");
        $.ajax({
            url: url,
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: formData
        }).done(function(e) {
            console.log(e);
            location.reload(true);
        });
        console.log(2);
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
    $scope.id_usuario = id_usuario;
    if (id_usuario >= 12) {
        $scope.CargarDatosUsuario();
    } else {
        $scope.CargarDatosUsuarioAdmin();
    }



});

$(function() {
    $(".input_foto").on("change", function() {
        $(this).hide();
        handleFiles(this, this.files);
    });

    $("#img_perfil").on("click", function() {
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
    img.onload = function() {
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
    }
    img.src = URL.createObjectURL(file);
}

function base64ToBlob(base64, mime) {
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

    return new Blob(byteArrays, { type: mime });
}