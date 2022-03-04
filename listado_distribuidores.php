<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <?php include 'componentes/componentes_basicos.php'; ?>
        <script src="interfaces/listado_distribuidores.js" type="text/javascript"></script>
        <script>
            var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
        </script> 
    </head>
    <body ng-app="listadoDistribuidoresApp" ng-controller="listadoDistribuidoresController">        

        <div id="main_container" class="grid-container off-canvas-content">
            <div class="callout1">
                <?php include 'componentes/controles_superiores.php'; ?>
                <?php include 'componentes/menu.php'; ?>
                <div class="cell medium-12 large-12">
                    <div class="grid-x grid-padding-x">
                        <div class="cell small-12">
                            <table>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="almacen in listado_distribuidores track by $index">
                                        <td>
                                            <a class="button small" href="distribuidores.php?id_distribuidora={{almacen.id}}"><i class="fa fa-search"></i></a>
                                        </td>
                                        <td>{{almacen.id}}</td>
                                        <td>{{almacen.nombre}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br/>                    
                </div>  
                <?php include 'componentes/footer.php'; ?>
            </div>           
        </div>
        <?php include 'componentes/coponentes_js.php'; ?>  
    </body>
</html>