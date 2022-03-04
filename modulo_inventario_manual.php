<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <?php include 'componentes/componentes_basicos.php'; ?>
        <script src="interfaces/modulos/inventario/select_load_inventory.js" type="text/javascript"></script>
        <link rel="stylesheet" href="css/jquery.dataTables.min.css">
        <script>
            var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
        </script> 
    </head>
    <body ng-app="inventoryApp" ng-controller="inventoryController">        

        <div id="main_container" class="grid-container off-canvas-content" ng-init="select_load_inventory(); select_categoria_productos(); select_almacenes();">
            <div class="callout1">
                <?php include 'componentes/controles_superiores.php'; ?>
                <?php include 'componentes/menu.php'; ?>

                <form id="dataForm" method="post">

                    <div class="grid-x grid-margin-x">
                        
               <div class="cell small-12 medium-10">                        
                                                  
                        <h3>Carga Manual de Inventario</h3>                            
                    </div>                           

                        <div class="cell small-12 medium-12">
                            <input type="text" placeholder="Cédula" name="cedula" id="cedula" ng-model="usuario_en_sesion.cedula" readonly>
                            <input type="text"  name="id_usuarios" id="id_usuarios" ng-model="usuario_en_sesion.id" readonly>
                        </div>
                        
                        <div class="cell small-12 medium-12">                            
                            <!-- <input type="text"  name="id_almacenes" id="id_almacenes" ng-model="usuario_en_sesion.id_almacen" readonly> -->
                            <select  name="id_almacenes" id="id_almacenes"   required>
                                <option value="0">[ Escoger almacen]</option>
                                <option ng-repeat="data in almacenes" ng-value="data.id">{{data.nombre}}</option>
                            </select>                            
                        </div>                        

                        <div class="cell small-12 medium-12">
                            <input type="date" placeholder="Fecha" name="fecha" id="fecha" required >
                        </div>                        

                        <div class="cell small-12 medium-12">                             
                            <select  placeholder="Tipo Producto" name="id_categoria_productos" id="tipo_vidrio"  required >
                                <option value="0">[ Escoger producto]</option>
                                <option ng-repeat="data in categoria_productos" ng-value="data.id">{{data.nombre}}</option>
                            </select>                              
                        </div>

                        <div class="cell small-12 medium-12">
                            <input type="text" placeholder="Cantidad en Metros" name="cantidad" id="cantidad" 
                            title="Caracteres Invalidos Ejempllo: 10.5" pattern="[0-9]+([.][0-9]+)?"  required >
                        </div>

                        
                        <div class="cell small-12 medium-12">                      
                            <select  placeholder="Espesor" name="espesor" id="espesor" required>
                                <option value="0">[ Escoger Espesor]</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>                              
                        </div>
                        
                        
                        <div class="cell small-12 medium-12">   
                            <button type="submit" class="expanded button"  name="send" >Enviar</button>
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