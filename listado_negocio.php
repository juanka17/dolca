<?php  include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <?php include 'componentes/componentes_basicos.php'; ?>
        <script src="interfaces/listado_negocio.js" type="text/javascript"></script>
        <script>
            var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
        </script>
    </head>
    <body ng-app="listadoNegocioApp" ng-controller="listadoNegocioController">         

        <div id="main_container" class="grid-container off-canvas-content">
            <div class="callout1">
                <?php include 'componentes/controles_superiores.php'; ?>
                <?php include 'componentes/menu.php'; ?>
                <div class="grid-x grid-padding-x">
                    <div class="cell small-12 medium-4">
                       <input class="form-control" type='text' placeholder="Buscar por nombre" ng-model="filtros.nombre" ng-change="SeleccionarListadoNegocios()" />
                    </div>
                </div>
                <div class="grid-x grid-padding-x">
                    <div class="cell small-12">
                        <table>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Negocio</th>
                                    <th class="hide-for-small-only">Direccion</th>
                                    <th class="hide-for-small-only">Celular</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="negocio in lista_negocio track by $index">
                                    <td>
                                            <a class="button small" href="calificar_negocio.php?id_usuario={{negocio.id}}"><i class="fa fa-search"></i></a>
                                    </td>
                                    <td>{{negocio.negocio}}</td>
                                    <td class="hide-for-small-only">{{negocio.direccion}}</td>
                                    <td class="hide-for-small-only">{{negocio.celular}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php include 'componentes/footer.php'; ?>
            </div>
        </div>


        <?php include 'componentes/coponentes_js.php'; ?>
    </body>
</html>