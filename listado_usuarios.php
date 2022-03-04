<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include 'componentes/componentes_basicos.php'; ?>
    <script src="interfaces/listado_usuarios.js?var=1" type="text/javascript"></script>
    <script>
        var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
    </script>
</head>

<body ng-app="listadoUsuariosApp" ng-controller="listadoUsuariosController">

    <div id="main_container" class="grid-container off-canvas-content">
        <div class="callout1">
            <?php include 'componentes/controles_superiores.php'; ?>
            <?php include 'componentes/menu.php'; ?>
            <div class="grid-x grid-padding-x">
                <div class="cell small-12 medium-3">
                    <label>
                        Cédula
                        <input type="text" placeholder="Cédula" ng-model="filtros.cedula" />
                    </label>
                </div>
                <div class="cell small-12 medium-3">
                    <label>
                        Nombre
                        <input type="text" placeholder="Nombre" ng-model="filtros.nombre" />
                    </label>
                </div>
                <div class="cell small-12 medium-3">
                    <label>
                        Telefono
                        <input type="text" placeholder="Nombre" ng-model="filtros.telefono" />
                    </label>
                </div>
                <div class="cell small-12 medium-3">
                    <br class="hide-for-small-only" />
                    <button class="button" ng-click="BuscarUsuarios()"><i class="fa fa-search"></i> Buscar Usuarios</button>
                </div>
            </div>
            <div class="grid-x grid-padding-x">
                <div class="cell small-12">
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th class="hide-for-small-only">Documento</th>
                                <th>Nombre</th>
                                <th class="hide-for-small-only">Correo</th>
                                <th class="hide-for-small-only">Telefono</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="usuario in listado_usuarios track by $index">
                                <td>
                                    <a class="button small" href="formulario_usuario.php?id_usuario={{usuario.id}}"><i class="fa fa-search"></i></a>
                                </td>
                                <td class="hide-for-small-only">{{usuario.documento}}</td>
                                <td>{{usuario.nombre}}</td>
                                <td class="hide-for-small-only">{{usuario.correo}}</td>
                                <td class="hide-for-small-only">{{usuario.telefono}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <?php include 'componentes/coponentes_js.php'; ?>
</body>

</html>