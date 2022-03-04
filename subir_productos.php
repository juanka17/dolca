<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include 'componentes/componentes_basicos.php'; ?>

    <link href="css/foundation-datepicker.css" rel="stylesheet" type="text/css" />
    <script src="js/foundation-datepicker.js" type="text/javascript"></script>
    <script src="js/locales/foundation-datepicker.es.js" type="text/javascript"></script>

    <script src="js/angular-filter.js" type="text/javascript"></script>

    <script src="interfaces/subir_archivos.js?cant=tell&if=is_true&ver=5" type="text/javascript"></script>

    <script>
        var id_usuario = 0;
        var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
        if (typeof getParameterByName("id_usuario") !== 'undefined' && getParameterByName("id_usuario") != "") {
            id_usuario = getParameterByName("id_usuario");
        } else {
            alert("No hay usuario seleccionado.");
            document.location.href = "listado_usuarios.php";
        }

        $(function() {
            $('.fecha_factura').fdatepicker({
                format: 'yyyy-mm-dd',
                disableDblClickSelection: true,
                language: 'en',
                pickTime: false
            });
        });
    </script>

    <style>
        .image_ajust {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: '200px';
            border: 1px solid #0000;
        }
    </style>

</head>

<body ng-app="subirArchivosApp" ng-controller="subirArchivosController">
    <div id="main_container" class="grid-container off-canvas-content" ng-init="SeleccionarAlmacen();">
        <div class="callout1">
            <?php include 'componentes/controles_superiores.php'; ?>
            <?php include 'componentes/menu.php'; ?>

            <div class="grid-x grid-margin-x">

                <div class="cell small-12">
                    <h4 class="text-center">Subir Productos Participante</h4>
                </div>
                <div class="cell small-12 medium-12">
                    <button class="button" ng-click="ObtenerProductosValidados()">Entregar Bonos</button>
                    <form id="dataForm" name="dataForm" ng-submit="CargarProductos()">
                        <div class="grid-x grid-margin-x">
                            <div class="cell small-12 medium-4">
                                <h6>1) Seleccione tipo de producto.</h6>
                                <div class="form-group">
                                    <select name="id_tipo_producto" id="id_tipo_producto" ng-model="id_tipo_producto" ng-change="ObtenerProductos(id_tipo_producto)">
                                        <option ng-repeat="tipo in tipo_productos" value="{{tipo.id}}">
                                            {{tipo.nombre}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="cell small-12 medium-4">
                                <h6>2) Seleccione producto.</h6>
                                <div class="form-group">
                                    <select name="id_producto" id="id_producto">
                                        <option ng-repeat="pro in productos" value="{{pro.id}}">
                                            {{pro.nombre}}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- REFERENECIA VIDRIO AZUL -->
                            <div class="cell small-12 medium-8">
                                <hr>
                                <h6>3) Ingrese los datos del producto.</h6>
                                <div class="grid-x grid-margin-x">
                                    <div class="cell small-12 medium-3">
                                        <h6>Codigo EAN</h6>
                                    </div>
                                    <div class="cell small-12 medium-3">
                                        <h6>Lote de producto</h6>
                                    </div>
                                    <div class="cell small-12 medium-3">
                                        <h6>Fecha</h6>
                                    </div>
                                </div>

                                <div ng-repeat="data in Profiles">
                                    <div class="grid-x grid-margin-x">
                                        <div class="cell small-12 medium-3">
                                            <div class="form-group">
                                                <input type="text" ng-model="data.codigo" id="referencia_{{$index}}" name="referencia_{{$index}}" required>
                                            </div>
                                        </div>
                                        <div class="cell small-12 medium-3">
                                            <div class="form-group">
                                                <input type="text" ng-model="data.lote" id="espesor_{{$index}}" name="espesor_{{$index}}" required />
                                            </div>
                                        </div>
                                        <div class="cell small-12 medium-3">
                                            <div class="form-group">
                                                <input type="date" ng-model="data.fecha" autocomplete="off" name="fecha_factura_{{$index}}" id="fecha_factura_{{$index}}" required>
                                            </div>
                                        </div>
                                        <div class="cell small-12 medium-3">
                                            <button ng-hide="$first" type="button" class='button small alert' ng-click="delete($index)">Eliminar</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class='button secondary' ng-click="add()"><i class="fa fa-plus"></i> Agregar Producto</button>
                                <hr>
                                <div class="cell small-12">
                                    <button type="submit" class='button expanded'>Haz click Aqui para verificar el proceso</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="large reveal" id="productos" data-reveal>
            <h4>Productos Registrados</h4>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Codigo</th>
                        <th>Lote</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Valor Ganado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="producto in productos_registrados">
                        <td>{{producto.producto}}</td>
                        <td>{{producto.codigo}}</td>
                        <td>{{producto.lote}}</td>
                        <td>{{producto.fecha}}</td>
                        <td>{{producto.estado_producto}}</td>
                        <td>${{producto.mecanica | number}}</td>
                    </tr>
                </tbody>
            </table>

            <div class="medium-4 cell" ng-init="factura = 0">
                <labels> ¿Tiene Factura? </label>
                    <select ng-model="factura">
                        <option value='1'>Si</option>
                        <option ng-selected="true" value='0'>No</option>
                    </select>

                    <p ng-if="factura == 0">
                        👌Eres un posible ganador de un bono de gasolina Terpel ⛽
                        por ${{total| number}}
                        🕛En máximo 24 horas hábiles nos comunicaremos para confirmar si eres ganador.
                    </p>

                    <form ng-if="factura == 1" id="dataFormFactura" name="dataFormFactura" ng-submit="GuardarDatosFactura()">
                        <div class="grid-x grid-margin-x">
                            <div class="cell small-12 medium-4">
                                <h6>1) Lugar de compra</h6>
                                <div class="form-group">
                                    <input type="text" id="lugar_factura" name="lugar_factura" required />
                                </div>
                            </div>
                            <div class="cell small-12 medium-4">
                                <h6>2) Seleccione fecha.</h6>
                                <div class="form-group">
                                    <input type="date" autocomplete="off" name="fecha_factura_compra" id="fecha_factura_compra" required>
                                </div>
                            </div>

                            <!-- REFERENECIA VIDRIO AZUL -->
                            <div class="cell small-12 medium-8">
                                <hr>
                                <h6>3) Ingrese los datos de la factura.</h6>
                                <div class="grid-x grid-margin-x">
                                    <div class="cell small-12 medium-3">
                                        <h6>Producto</h6>
                                    </div>
                                    <div class="cell small-12 medium-3">
                                        <h6>Valor</h6>
                                    </div>
                                </div>

                                <div ng-repeat="datap in profiles_factura">
                                    <div class="grid-x grid-margin-x">
                                        <div class="cell small-12 medium-3">
                                            <div class="form-group">
                                                <select ng-model="datap.id_producto" id="producto_{{$index}}" name="producto_{{$index}}" required>
                                                    <option value="1">NESCAFÉ® DOLCA® 5 Tazas </option>
                                                    <option value="2">NESCAFÉ® DOLCA® 50 G </option>
                                                    <option value="3">NESCAFÉ® DOLCA® 85 G </option>
                                                    <option value="4">NESCAFÉ® DOLCA® 170 G </option>
                                                    <option value="5">NESCAFÉ® DOLCA® 200 G </option>
                                                    <option value="6">NESCAFÉ® DOLCA® 468 G </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="cell small-12 medium-3">
                                            <div class="form-group">
                                                <input type="text" ng-model="datap.valor" id="valor_{{$index}}" name="valor_{{$index}}" required />
                                            </div>
                                        </div>
                                        <div class="cell small-12 medium-3">
                                            <button ng-hide="$first" type="button" class='button small alert' ng-click="deleteProducto($index)">Eliminar</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class='button secondary' ng-click="addProducto()"><i class="fa fa-plus"></i> Agregar Producto</button>
                                <hr>
                                <div class="cell small-12">
                                    <button type="submit" class='button expanded'>Guardar Factura</button>
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
            <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="large reveal" id="bonos" data-reveal>
            <h4>Productos Registrados</h4>
            <table>
                <thead>
                    <tr>
                        <th>id_registro</th>
                        <th>Producto</th>
                        <th>Codigo</th>
                        <th>Lote</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Valor Ganado</th>
                    </tr>
                </thead>
                <tbody ng-init="total = 0">
                    <tr ng-repeat="producto in productos_validados">
                        <td>{{producto.id}}</td>
                        <td>{{producto.producto}}</td>
                        <td>{{producto.codigo}}</td>
                        <td>{{producto.lote}}</td>
                        <td>{{producto.fecha}}</td>
                        <td>{{producto.estado_producto}}</td>
                        <td ng-init="$parent.total = total + (producto.mecanica - 0)">${{producto.mecanica | number}}</td>
                        <td><button ng-if="producto.mecanica > 0 && producto.estado == 1 && residual <= 0" ng-click="SolicitarBono(producto.id,producto.mecanica);" class="button primary">Solicitar</button></td>
                        <td><button ng-if="producto.estado == 1 && residual > 0" ng-click="SolicitarBono(producto.id,residual);" class="button primary">Solicitar valor especial de {{residual | number}}</button></td>
                      
                    </tr>
                    <tr>
                        <td><b style="color: red">Total</b></td>
                        <td colspan="5"></td>
                        <td><b style="color: red">{{total| number}}</b></td>
                    </tr>
                    <tr>
                        <td><b style="color: blue">Valor Faltante</b></td>
                        <td colspan="5"></td>
                        <td><b style="color: blue">{{20000 - total| number}}</b></td>
                    </tr>
                </tbody>
            </table>

            <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="reveal" id="bonoseleccionado" data-reveal>
            <h1>Felicitaciones</h1>
            <p class="lead">
                Eres un ganador y puedes prender motores con NESCAFÉ®️ DOLCA®️ y TERPEL ⛽<br>
                Tu Bono por {{valor}} es {{bono[0].codigo}} acercate a la Estación TERPEL más cercana y redime. <br>
                Si tienes alguna duda o inquietud puedes comunicarte con nosotros a la línea 018000 413828 <br>
                de Lunes a Domingo de 8:00 a 6:00 p.m.

            </p>
            <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php include 'componentes/coponentes_js.php'; ?>
</body>

</html>