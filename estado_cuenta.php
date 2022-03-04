<?php include 'componentes/control_sesiones.php'; ?>    
<!doctype html>    
<html class="no-js" lang="en" dir="ltr">    
    <head>        
        <?php include 'componentes/componentes_basicos.php'; ?>            
        <script src="interfaces/estado_cuenta.js?ver=3" type="text/javascript"></script>            
        <script>
            var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
            var id_usuario = 0;
            if (typeof getParameterByName("id_usuario") !== 'undefined' && getParameterByName("id_usuario") != "")
            {
                id_usuario = getParameterByName("id_usuario");
            } else
            {
                alert("No hay usuario seleccionado.");
            }

        </script>            
        <style>            
            h4 small            
            {
                color: black;                
            }      
            .accordion-title {
                position: relative;
                display: block;
                padding: 1.25rem 1rem;
                border: 1px solid #e6e6e6;
                border-bottom: 0;
                font-size: 0.75rem;
                line-height: 1;
                background-color: #0071ab;
                color: #fefefe;
            }
            </style>            
        </head>        
        <body ng-app="estadoCuentaApp" ng-controller="estadoCuentaController">      
            <div id="main_container" class="grid-container off-canvas-content">            
                <div class="callout1">                
                    <?php include 'componentes/controles_superiores.php'; ?>
                    <?php include 'componentes/menu.php'; ?>
                    <div class="grid-x grid-margin-x">
                        <div class="cell small-12">
                            <br/>
                            <br/>
                            <h3>Estado de Cuenta</h3>
                        </div>
                        <div class="cell small-12 medium-offset-5 medium-1">
                            <button class="button alert" onclick="javascript:history.back();">Volver</button>
                        </div>                        
                        
                        <div class="cell small-12">
                            <h4 class="text-center">
                                Transacciones
                            </h4>
                            <ul id="pnl_estado_cuenta" class="accordion" data-accordion data-multi-expand="true" data-allow-all-closed="true">
                                <li ng-repeat="periodo in estado_cuenta track by $index" class="accordion-item" data-accordion-item>
                                    <!-- Accordion tab title -->
                                    <a ng-click="AbrirPanelPeriodo(periodo.id_periodo)" class="accordion-title">{{periodo.periodo}}</a>

                                    <!-- Accordion tab content: it would start in the open state due to using the `is-active` state class. -->
                                    <div id="panel_{{periodo.id_periodo}}" class="accordion-content" data-tab-content>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Factura</th>
                                                    <th>Concepto</th>
                                                    <th>Descripción</th>
                                                    <th>Num Factura</th>
                                                    <th>Cantidad</th>
                                                    <th>Puntos</th>
                                                </tr>
                                            </thead>
                                            <tbody ng-init="total = 0">
                                                <tr ng-repeat="registro in periodo.registros track by $index">
                                                    <td>{{registro.fecha_factura}}</td>
                                                    <td><a target="_blank" href="clases/archivos/{{registro.id_usuario}}/{{registro.img_factura}}"><i  class="fa fa-eye"></i><a/></td>
                                                    <td>{{registro.concepto}}</td>
                                                    <td>{{registro.descripcion}}</td>
                                                    <td>{{registro.num_factura}}</td>
                                                    <td>{{registro.cantidad}}</td>
                                                    <td ng-init="$parent.total = $parent.total + registro.puntos">{{registro.puntos| number}}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Total</b></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><b>{{total}}</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>  
            <?php include 'componentes/coponentes_js.php'; ?>   
        </body>        
    </html>