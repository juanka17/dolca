<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <?php include 'componentes/componentes_basicos.php'; ?>
        <script src="interfaces/calificar_negocio.js?ver=3" type="text/javascript"></script>
        <script>
            var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
            var id_usuario = 0;
            if (typeof getParameterByName("id_usuario") !== 'undefined' && getParameterByName("id_usuario") != "")
            {
                id_usuario = getParameterByName("id_usuario");
            } else
            {
                document.location.href = "listado_negocio.php";
            }
        </script>
    </head>
    <body ng-app="evaluacionApp" ng-controller="evaluacionController"> 
        <div id="main_container" class="grid-container off-canvas-content">
            <div class="callout1">
                <?php include 'componentes/controles_superiores.php'; ?>
                <?php include 'componentes/menu.php'; ?>                
                <div ng-show="evaluacion.length == 0" class="grid-x grid-padding-x">
                    <div class="cell small-12">
                        <div class="stacked-for-small button-group">
                            <button class="button disabled">Enero</button>
                            <button class="button disabled">Febrero</button>
                            <button class="button disabled">Marzo</button>
                            <button class="button">Abril</button>
                            <button class="button disabled">Mayo</button>
                            <button class="button disabled">Junio</button>
                            <button class="button disabled">Julio</button>
                            <button class="button disabled">Agosto</button>
                            <button class="button disabled">Septiembre</button>
                            <button class="button disabled">Octubre</button>
                            <button class="button disabled">Noviembre</button>
                            <button class="button disabled">Diciembre</button>
                        </div>
                    </div>
                    <div class="cell small-12 medium-2 text-center">
                        <h6>Avisos</h6>
                        <br/>
                        <div class="switch large">
                            <input class="switch-input" id="chbx_avisos" type="checkbox" ng-model="avisos" >
                            <label class="switch-paddle" for="chbx_avisos">
                                <span class="show-for-sr">¿Tiene avisos?</span>
                                <span class="switch-active" aria-hidden="true">Si</span>
                                <span class="switch-inactive" aria-hidden="true">No</span>
                            </label>
                        </div>
                        <input type="file" accept="image/*" id="uploadAvisos" class="input_foto" data-img='#img_avisos' ng-init='avisos = 0' />
                        <div class='img-container' id='img_avisos' data-upload="#uploadAvisos"></div>
                    </div>
                    <div class="cell small-12 medium-2 text-center">
                        <h6>Exhibidores</h6>
                        <br/>
                        <div class="switch large">
                            <input class="switch-input" id="chbx_exhibidores" type="checkbox" ng-model="exhibidores" >
                            <label class="switch-paddle" for="chbx_exhibidores">
                                <span class="show-for-sr">¿Cumple Exhibidores?</span>
                                <span class="switch-active" aria-hidden="true">Si</span>
                                <span class="switch-inactive" aria-hidden="true">No</span>
                            </label>
                        </div>
                        <input type="file" accept="image/*" id="uploadExhibidores" class="input_foto" data-img='#img_exhibidores' ng-init='exhibidores = 0' />
                        <div class='img-container' id='img_exhibidores' data-upload="#uploadExhibidores"></div>
                    </div>
                    <div class="cell small-12 medium-2 text-center">
                        <h6>Triciclo</h6>
                        <br/>
                        <div class="switch large">
                            <input class="switch-input" id="chbx_triciclo" type="checkbox" ng-model="triciclo" >
                            <label class="switch-paddle" for="chbx_triciclo">
                                <span class="show-for-sr">¿Tiene Triciclo?</span>
                                <span class="switch-active" aria-hidden="true">Si</span>
                                <span class="switch-inactive" aria-hidden="true">No</span>
                            </label>
                        </div>
                    </div>
                    <div class="cell small-12 medium-2 text-center">
                        <h6>Graphic Floor</h6>
                        <br/>
                        <div class="switch large">
                            <input class="switch-input" id="chbx_graphic_floor" type="checkbox" ng-model="graphic_floor" >
                            <label class="switch-paddle" for="chbx_graphic_floor">
                                <span class="show-for-sr">¿Cumple Graphic Floor?</span>
                                <span class="switch-active" aria-hidden="true">Si</span>
                                <span class="switch-inactive" aria-hidden="true">No</span>
                            </label>
                        </div>
                        <input type="file" accept="image/*" id="uploadGraphicFloor" class="input_foto" data-img='#img_graphic_floor' ng-init='graphic_floor = 0' />
                        <div class='img-container' id='img_graphic_floor' data-upload="#uploadGraphicFloor"></div>
                    </div>
                    <div class="cell small-12 medium-2 text-center">
                        <h6>Branding en Vehículo</h6>
                        <br/>
                        <div class="switch large">
                            <input class="switch-input" id="chbx_branding_vehiculo" type="checkbox" ng-model="branding_vehiculo" >
                            <label class="switch-paddle" for="chbx_branding_vehiculo">
                                <span class="show-for-sr">¿Cumple Branding en Vehículo?</span>
                                <span class="switch-active" aria-hidden="true">Si</span>
                                <span class="switch-inactive" aria-hidden="true">No</span>
                            </label>
                        </div>
                        <input type="file" accept="image/*" id="uploadBrandingVehiculo" class="input_foto" data-img='#img_branding_vehiculo' ng-init='branding_vehiculo = 0' />
                        <div class='img-container' id='img_branding_vehiculo' data-upload="#uploadBrandingVehiculo"></div>
                    </div>
                    <div class="cell small-12 medium-2 text-center">
                        <h6>Branding en Local</h6>
                        <br/>
                        <div class="switch large">
                            <input class="switch-input" id="chbx_branding_local" type="checkbox" ng-model="branding_local" >
                            <label class="switch-paddle" for="chbx_branding_local">
                                <span class="show-for-sr">¿Cumple Branding en Local?</span>
                                <span class="switch-active" aria-hidden="true">Si</span>
                                <span class="switch-inactive" aria-hidden="true">No</span>
                            </label>
                        </div>
                        <input type="file" accept="image/*" id="uploadBrandingLocal" class="input_foto" data-img='#img_branding_local' ng-init='branding_local = 0' />
                        <div class='img-container' id='img_branding_local' data-upload="#uploadBrandingLocal"></div>
                    </div>
                    <div class="cell small-12">
                        <button ng-click="GuardarEvaluacionTienda()" class='button expanded'>Guardar Evaluación</button>
                    </div>
                </div>                
                <div ng-show="evaluacion.length > 0" class="grid-x grid-padding-x">                                      
                    <div class="cell small-12 medium-2">
                        Avisos: {{evaluacion[0].avisos == 1 ? "Si" : "No"}}
                        <br/>
                        <img id='img_avisos_foto' style="width: 100%;" />
                    </div>
                    <div class="cell small-12 medium-2">
                        Exhibidores: {{evaluacion[0].exhibidores == 1 ? "Si" : "No"}}
                        <br/>
                        <img id='img_exhibidores_foto' style="width: 100%;" />
                    </div>
                    <div class="cell small-12 medium-2">
                        Triciclo: {{evaluacion[0].triciclo == 1 ? "Si" : "No"}}
                    </div>
                    <div class="cell small-12 medium-2">
                        Graphic Floor: {{evaluacion[0].graphic_floor == 1 ? "Si" : "No"}}
                        <br/>
                        <img id='img_graphic_floor_foto' style="width: 100%;" />
                    </div>
                    <div class="cell small-12 medium-2">
                        Branding Vehiculo: {{evaluacion[0].branding_vehiculo == 1 ? "Si" : "No"}}
                        <br/>
                        <img id='img_branding_vehiculo_foto' style="width: 100%;" />
                    </div>
                    <div class="cell small-12 medium-2">
                        Branding Local: {{evaluacion[0].branding_local == 1 ? "Si" : "No"}}
                        <br/>
                        <img id='img_branding_local_foto' style="width: 100%;" />
                    </div>
                </div>
                <?php include 'componentes/footer.php'; ?>
            </div>
        </div>
        <?php include 'componentes/coponentes_js.php'; ?>
    </body>
</html>