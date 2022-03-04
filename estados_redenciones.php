<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <?php include 'componentes/componentes_basicos.php'; ?>

        <link href="css/foundation-datepicker.css" rel="stylesheet" type="text/css"/>
        <script src="js/foundation-datepicker.js" type="text/javascript"></script>
        <script src="js/locales/foundation-datepicker.es.js" type="text/javascript"></script>

        <script src="interfaces/estados_redencion.js" type="text/javascript"></script>

        <script>
            var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
            var id_redencion = 0;
            if (typeof getParameterByName("id_redencion") !== 'undefined' && getParameterByName("id_redencion") != "")
            {
                id_redencion = getParameterByName("id_redencion");
            } else
            {
                alert("Redención no disponible.");
            }
        </script>
    </head>
    <body ng-app="estadosRedencionApp" ng-controller="estadosRedencionController">


        <div id="main_container" class="grid-container off-canvas-content">
            <div class="callout">
                <?php include 'componentes/controles_superiores.php'; ?>
                <?php include 'componentes/menu.php'; ?>
                <div class="grid-x">
                    <div class="col small-12">
                        <h1>Seguimiento premios</h1>
                    </div>
                    <div class="col small-5">
                        <b>Premio</b>
                        <br/>
                        {{redencion.premio}}
                    </div>
                    <div class="col small-3">
                        <b>Fecha Redencion</b>
                        <br/>
                        {{redencion.fecha_redencion}}
                    </div>
                    <div class="col small-2">
                        <b>Puntos</b>
                        <br/>
                        {{redencion.puntos}}
                    </div>
                    <div class="col small-2">
                        <button class="button alert" onclick="javascript:history.back();">Volver</button>
                    </div>
                    <div class="col small-12">
                        <br/>
                        <h4>Estados de la redencion</h4>
                    </div>
                    <div class="small-12 cell">
                        <table>
                            <thead>
                                <tr>
                                    <th>Operación</th>
                                    <th>Comentario</th>
                                    <th>Referencia</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="seguimiento in seguimiento_redencion track by $index">
                                    <td>{{seguimiento.operacion}}</td>
                                    <td>{{seguimiento.comentario}}</td>
                                    <td>{{seguimiento.referencia}}</td>
                                    <td>{{seguimiento.fecha}}</td>
                                    <td ng-show="seguimiento.operacion == 'Entregado'">
                                        <a class="button" ng-href="encuesta_premio.php?id_redencion={{redencion.folio}}">
                                            Encuesta
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="grid-x grid-padding-x" ng-show="redencion.operacion != 'Encuestado'">
                    <div class="small-3 cell">
                        <label>
                            Nuevo estado
                            <select ng-model='nuevo_estado.id_operacion'>
                                <option ng-repeat="operacion in operaciones_redencion track by $index" value='{{operacion.id}}'>{{operacion.nombre}}</option>
                            </select>
                        </label>
                    </div>
                    <div class="small-3 cell">
                        <label>
                            Comentario
                            <input type="text" placeholder="Comentario" ng-model="nuevo_estado.comentario">
                        </label>
                    </div>
                    <div class="small-3 cell">
                        <label>
                            Referencia
                            <input type="text" placeholder="Referencia" ng-model="nuevo_estado.referencia">
                        </label>
                    </div>
                    <div class="small-3 cell">
                        <br/>
                        <button class="button" ng-click="RegistrarSeguimiento()">Registrar Seguimiento</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'componentes/coponentes_js.php'; ?>
    </body>
</html>