<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include 'componentes/componentes_basicos.php'; ?>

    <link href="css/foundation-datepicker.css" rel="stylesheet" type="text/css" />
    <script src="js/foundation-datepicker.js" type="text/javascript"></script>
    <script src="js/locales/foundation-datepicker.es.js" type="text/javascript"></script>
    <script src="interfaces/crear_usuario.js?reload=2&charge=kss" type="text/javascript"></script>

    <script>
        var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
    </script>
</head>

<body ng-app="datosUsuarioApp" ng-controller="datosUsuarioController">
    <div id="main_container" class="grid-container off-canvas-content">
        <div class="callout1">
            <?php include 'componentes/controles_superiores.php'; ?>
            <?php include 'componentes/menu.php'; ?>
            <div class="grid-x">
                <div class="col small-12">
                    <h4 class="text-center">Crear Nuevo Participante</h4>
                </div>
                <div class="small-12 medium-offset-3 medium-6 cell">
                    <form ng-submit="CrearUsuario()">
                        <div class="grid-x grid-margin-x">
                            <div class="medium-6 cell">
                                <label>Nombre</label>
                                <input type="text" placeholder="Nombre" ng-model="datos_usuario.nombre">
                            </div>
                            <div class="medium-6 cell" ng-init="datos_usuario.tipo_documento = 1">
                                <label>Tipo Documento</label>
                                <select ng-model="datos_usuario.tipo_documento">
                                    <option ng-repeat="tipo in tipo_documento" value="{{tipo.id}}">
                                        {{tipo.nombre}}
                                    </option>
                                </select>
                            </div>
                            <div class="medium-6 cell">
                                <label>Documento</label>
                                <input type="text" placeholder="Documento" ng-model="datos_usuario.documento">
                            </div>
                            <div class="medium-6 cell">
                                <label>Correo</label>
                                <input type="email" name="email" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" placeholder="Correo" ng-model="datos_usuario.correo">
                            </div>
                            <div class="medium-12 cell">
                                <label>Telefono</label>
                                <input type="text" placeholder="Telefono" ng-model="datos_usuario.telefono">
                            </div>
                            <div class="small-12 cell text-center">
                                <button type="submit" class="button">Crear Participante</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'componentes/coponentes_js.php'; ?>
</body>

</html>