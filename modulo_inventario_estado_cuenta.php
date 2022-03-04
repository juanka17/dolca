<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

    <head>
        <?php include 'componentes/componentes_basicos.php'; ?>
        <script src="interfaces/modulos/inventario/select_estado_cuenta.js?<?php echo rand(1, 100); ?>" type="text/javascript"></script>
        <link rel="stylesheet" href="css/jquery.dataTables.min.css">

        <!-- jQuery Modal -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

        <script>
        var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
        </script>

    </head>

    <body ng-app="inventoryApp" ng-controller="inventoryController" ngcloak>

        <div id="main_container" class="grid-container off-canvas-content" ng-init="select_estado_cuenta_general()">
            <div class="callout1">
                <?php include 'componentes/controles_superiores.php'; ?>
                <?php include 'componentes/menu.php'; ?>


                <form id="dataForm" method="post">

                    <div class="grid-x grid-margin-x">


                        <div class="cell small-12 medium-12">
                            <h3> Reporte Estado Cuenta </h3>

                          </div>

                        <div class="cell small-12 medium-12">
                            <table id="myTable" class="display">
                                <thead>
                                    <tr>
                                        <td>id</td>
                                        <td>id_usuario</td>
                                        <td>nombre</td>
                                        <td>fecha</td>
                                        <td>almacen</td>
                                        <td>producto negocio</td>
                                        <td>producto homologado</td>
                                        <td>cantidad</td>
                                        <td>puntos</td>
                                        <td>factura</td>
                                        <td>imagen</td>
                                        <td>validar</td>

                                    </tr>
                                </thead>

                            </table>
                        </div>

                    </div>

                    <!-- insert form create user -->



                    <!-- Modal -->
                    <div id="modalViewValidar" class="modal">

                        <form ng-submit="insert_negacion_estado_cuenta(formUser)">

                            <h3>Negacion </h3>

                            <hr>

                            <div>
                                <label for="id_negacion_archivo">Id factura </label>
                                <input type="text" class="form-control" id="id_negacion_archivo"
                                    name="id_negacion_archivo" ng-model="formUser.id_negacion_archivo"
                                    disabled required>
                            </div>

                            <div class="form-group">
                                <label for="id_negacion_factura_tipo">tipos de negacion</label>
                                <select class="form-control" id="id_negacion_factura_tipo"
                                    name="id_negacion_factura_tipo" ng-model="formUser.id_negacion_factura_tipo"
                                    required>
                                    <option ng-repeat="data in select_negacion_factura_tipo" ng-value="data.id_negacion_factura_tipo"> {{data.nombre}}</option>


                                </select>
                            </div>

                            <button class="button small expanded"  type="submit" ng-click="insert_negacion_estado_cuenta(formUser)"> Enviar </button>


                        </form>

                    </div>


                    <script src="js/jquery.dataTables.min.js"></script>
            </div>
        </div>
        <?php include 'componentes/coponentes_js.php'; ?>
    </body>

</html>
