<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="es" dir="ltr">
    <head>
        <?php include 'componentes/componentes_basicos.php'; ?>
        <script src="interfaces/modulos/inventario/select_load_inventory.js?ver=2" type="text/javascript"></script>
        <link rel="stylesheet" href="css/jquery.dataTables.min.css">
        <script>
            var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
        </script> 
    </head>
    <body ng-app="inventoryApp" ng-controller="inventoryController">        

        <div id="main_container" class="grid-container off-canvas-content" ng-init="select_load_inventory(); select_almacenes();">
            <div class="callout1">
                <?php include 'componentes/controles_superiores.php'; ?>
                <?php include 'componentes/menu.php'; ?>

                <form id="dataForm" method="post" enctype="multipart/form-data">

                    <div class="grid-x grid-margin-x">

                        <div class="cell small-12 medium-12">
                            <h3> Cargar Listas de Inventario </h3>  
                        </div>


                        <div class="cell small-12 medium-6">   
                            <input type="file" accept="csv/*" id="file" name="csv"  />                          
                        </div>

                        <div class="cell small-12 medium-6">   
                            <div class="grid-x grid-margin-x">
                                <div class="cell small-12 medium-6"> <button type="button" class="expanded button"  name="send" ng-click="insert_load_inventory()">Enviar</button>   </div>

                                <div class="cell small-12 medium-6"> <a class="expanded button alert" href="./modulo_inventario_manual.php" > Ingresar Manualmente</a> </div>
                            </div>  


                        </div>        

                        <div class="cell small-12 medium-12">                                                        
                            <select  name="id_almacenes" id="id_almacenes"   required>
                                <option ng-repeat="data in almacenes" ng-value="data.id">{{data.nombre}}</option>
                            </select>                            
                        </div>                                        

                        <div class="cell small-12 medium-12">
                            <table id="myTable" class="display">
                                <thead>
                                    <tr>
                                        <td>id</td>
                                        <td>creado</td>
                                        <td>fecha inventario</td>
                                        <td>almacen</td>
                                        <td>producto</td>
                                        <td>metros</td>
                                        <td>espesor</td>
                                        
                                    </tr>
                                </thead>
                            </table>   
                        </div>
                    </div>

                </form>
                <script src="js/jquery.dataTables.min.js"></script>
                <?php include 'componentes/footer.php'; ?>
            </div>           
        </div>
        <?php include 'componentes/coponentes_js.php'; ?>  
    </body>
</html>