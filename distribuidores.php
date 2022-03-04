<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <?php include 'componentes/componentes_basicos.php'; ?>

        <script src="interfaces/distribuidores.js?cant=tell&if=is_true&ver=2" type="text/javascript"></script>

        <script>
            var id_distribuidora = 0;
            var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
            if (typeof getParameterByName("id_distribuidora") !== 'undefined' && getParameterByName("id_distribuidora") != "")
            {
                id_distribuidora = getParameterByName("id_distribuidora");
            } else
            {
                alert("No hay distribuidora seleccionado.");
                document.location.href = "listado_distribuidores.php";
            }

        </script>
    </head>
    <body ng-app="distribuidoresApp" ng-controller="distribuidoresController" >        
        <div id="main_container" class="grid-container off-canvas-content">
            <div class="callout1">
                <?php include 'componentes/controles_superiores.php'; ?>
                <?php include 'componentes/menu.php'; ?>
                <div class="grid-x grid-margin-x">
                    <div class="cell small-12 medium-4">
                        <h3>
                            Inventario Almacen
                        </h3>
                        <table>                                
                            <thead>
                                <tr>
                                    <th>Periodo</th>
                                    <th>Tipo Vidrio</th>
                                    <th>Espesor</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="inventario in listado_inventario_distribuidores track by $index">                                   
                                    <td>{{inventario.periodo}}</td>
                                    <td>{{inventario.nombre}}</td>
                                    <td>{{inventario.espesor}}</td>
                                    <td>{{inventario.cantidad}} M</td>
                                </tr>
                            </tbody>
                        </table>    
                    </div>
                    <div class="cell small-12 medium-5">
                        <h3>
                            Facturas Reportadas
                        </h3>
                        <table>
                            <thead>
                            <th>Tipo Vidrio</th>
                            <th>Espesor</th>
                            <th>Cantidad</th>
                            </thead>
                            <tbody>
                                <tr ng-repeat="archivos in archivo_listado_inventario track by $index">
                                    <td>{{archivos.tipo_vidrio}}</td>
                                    <td>{{archivos.milimetros}}</td>
                                    <td>{{archivos.metros}} M   </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="cell small-12 medium-3">
                        <h3>
                            Inventario Restante
                        </h3>
                        <table>
                            <thead>
                            <th>Tipo Vidrio</th>
                            <th>Espesor</th>
                            <th>Cantidad</th>
                            </thead>
                            <tbody>
                                <tr ng-repeat="archivos in archivo_listado_inventario track by $index">
                                    <td>{{archivos.tipo_vidrio}}</td>
                                    <td>{{archivos.milimetros}}</td>
                                    <td style="color:red;">{{archivos.total}} M</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php include 'componentes/footer.php'; ?>
        </div>    

        <?php include 'componentes/coponentes_js.php'; ?>
    </body>
</html>