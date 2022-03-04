<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <?php include 'componentes/componentes_basicos.php'; ?>
        <script src="interfaces/catalogo.js?fuel=5&fire=3254" type="text/javascript"></script>
        <script>
            var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
            var id_usuario = 0;
            var id_premio = 0;
            if (typeof getParameterByName("id_usuario") !== 'undefined' && getParameterByName("id_usuario") != "")
            {
                id_usuario = getParameterByName("id_usuario");
            } else
            {
                alert("No hay usuario seleccionado.");
            }
            if (typeof getParameterByName("id_premio") !== 'undefined' && getParameterByName("id_premio") != "")
            {
                id_premio = getParameterByName("id_premio");
            }


        </script>
        <style>
            .card img
            {
                height: auto;
                margin: 0 auto;
                width: 150px;
            }

            .premio .card
            {
                border: 1px solid #14679e;
                border-radius: 26px;
            }

            .premio .card .imagen-premio
            {
                height: 150px;
                margin: 0 auto;
                overflow: hidden;
            }

            .premio .card-divider
            {
                color: white;
                background-color: #139ad7;
                height: 50px;
                overflow: hidden;
            }

            .premio .nombre-grande
            {
                padding: 0.1rem 0.5rem;
                align-items: center;
            }

            .premio .descripcion
            {
                height: 100px;
                margin-bottom: 10px;
                overflow: hidden;
            }

            h5 small
            {
                color: #0a0a0a;
            }
        </style>
    </head>
    <body ng-app="catalogoApp" ng-controller="catalogoController">
        <div id="main_container" class="grid-container off-canvas-content"> 
            <div class="callout1">
                <?php include 'componentes/controles_superiores.php'; ?>
                <?php include 'componentes/menu.php'; ?>
                <div class="grid-x grid-margin-x">
                    <div class="cell small-12 medium-10">
                        <h3>Catálogo de premios - <small>Puntos Disponibles {{datos_usuario.saldo_actual| number}}</small></h3>
                    </div>
                    <div class="cell small-12 medium-2 align-right">
                        <button class="button alert" onclick="javascript:history.back();">Volver</button>
                    </div>
                    <div class="cell small-12 medium-6">
                        <label>
                            Categoria
                            <select ng-model="filtros.id_categoria" ng-change="SeleccionarPremiosVisibles()">
                                <option ng-selected="true" value="0">TODOS LOS PREMIOS</option>
                                <option ng-repeat="categoria in categoria_premios track by $index" ng-value="categoria.id" >
                                    {{categoria.nombre}}
                                </option>
                            </select>
                        </label>
                    </div>
                    <div class="cell small-12 medium-6 text-center">
                        <label>
                            Nombre del premio
                            <input ng-model="filtros.nombre" type="text" placeholder="¿Que Premio Buscas?" ng-change="SeleccionarPremiosVisibles()">
                        </label>
                    </div>   

                    <div class="cell small-12 medium-3" >
                        <button class="button expanded" ng-click="ObtenerPremios(1);"><i class="fa fa-arrow-up"></i> Ordenar Menor a Mayor</button>                        
                    </div>
                    <div class="cell small-12 medium-3" >
                        <button class="button expanded" ng-click="ObtenerPremios(2);"><i class="fa fa-star"></i> Mas redimidos</button>                        
                    </div>
                    <div class="cell small-12 medium-3" >
                        <button class="button expanded" ng-click="ObtenerPremios(3);"><i class="fa fa-cart-plus"></i> Premios que puede reclamar</button>                        
                    </div>
                    <div class="cell small-12 medium-3" >
                        <button class="button expanded" ng-click="ObtenerPremios(4);"><i class="fa fa-child"></i> Si te esfuerzas</button>                        
                    </div>
                    <div class="cell small-12">
                        <br/>
                        <button class="expanded button" 
                                data-open="modal_carrito" >
                            <i class="fa fa-shopping-basket"></i> Ver Carrito ({{carrito.elementos.length}})
                        </button>
                    </div>
                    <div class="cell small-12">
                        <div class="grid-x grid-margin-x">
                            <div class="cell small-12 medium-4 premio" ng-repeat="premio in premios_visibles track by $index">
                                <div class="card">
                                    <div class="align-center text-center card-divider {{premio.premio.length > 35 ? 'nombre-grande' : ''}}">
                                        {{premio.premio}}
                                    </div>
                                    <br/>
                                    <div class="imagen-premio">
                                        <i>* Imagen de referencia</i>
                                        <br/>
                                        <img ng-src='https://formasestrategicas.com.co/premios/{{premio.id_premio}}.jpg' 
                                             alt="No disponible" onError="this.src='images/premios/replace.png'"/>
                                    </div>
                                    <div class="card-section">
                                        <div class="expanded button-group stacked-for-small" ng-show="usuario_en_sesion.id_rol != 3">
                                            <button class="expanded button hollow" >
                                                {{ premio.puntos == premio.puntos_actuales ? premio.puntos : premio.puntos_actuales | number}}
                                                <span ng-show="premio.puntos != premio.puntos_actuales" style="color: red; text-decoration: line-through;">({{premio.puntos}})</span>
                                                Puntos
                                            </button>
                                            <button class="expanded button" 
                                                    data-open="modal_detalle_premio" 
                                                    ng-click="SeleccionarPremio($index)" 
                                                    ng-disabled="saldo_disponible < premio.puntos_actuales"
                                                    ng-show="premio.solo_call == 0 || usuario_en_sesion.id_rol == 2"
                                                    >
                                                <i class="fa fa-star"></i> Seleccionar
                                            </button>
                                            <button class="expanded button" 
                                                    ng-disabled="true" 
                                                    ng-show="premio.solo_call == 1 && usuario_en_sesion.id_rol != 2"
                                                    >
                                                <i class="fa fa-phone"></i> Llamar
                                            </button>
                                        </div>
                                        <div class="expanded button-group stacked-for-small" ng-show="usuario_en_sesion.id_rol == 3">
                                            <button class="expanded button hollow" >{{premio.puntos| number}} Puntos</button>
                                        </div>
                                        <p class="descripcion">
                                            <b>Marca:</b> {{premio.marca}}
                                            <br/>
                                            {{premio.descripcion}}
                                        </p>
                                    </div>
                                </div>
                                <br/>
                            </div>
                        </div>
                    </div>
                    <div class="cell small-12 align-center">
                        <div class="expanded button-group">
                            <button class="button" ng-disabled="pagina_actual == 0" ng-click="SeleccionarPaginaListaVisible(pagina_actual - pagina_actual)">
                                INICIO
                            </button>
                            <button class="button" ng-disabled="pagina_actual == 0" ng-click="SeleccionarPaginaListaVisible(pagina_actual - 1)">
                                <i class="fa fa-backward"></i>
                            </button>
                            <button class="button"> {{pagina_actual + 1}} de {{cantidad_paginas + 1}} </button>                           
                            <button class="button" ng-disabled="pagina_actual >= cantidad_paginas" ng-click="SeleccionarPaginaListaVisible(pagina_actual + 1)">
                                <i class="fa fa-forward"></i>
                            </button>
                            <button class="button" ng-disabled="pagina_actual >= cantidad_paginas" ng-click="SeleccionarPaginaListaVisible(pagina_actual + (cantidad_paginas - pagina_actual))">
                                FIN
                            </button>
                        </div>
                    </div>                 
                    <?php include 'componentes/footer.php'; ?>
                </div>
            </div>
        </div>

        <div class="reveal text-center" id="modal_detalle_premio" data-reveal>
            <h4>Agregar al carrito</h4>
            <img ng-src='http://formasestrategicas.com.co/premios/{{premio_seleccionado.id_premio}}.jpg' 
                 alt="No disponible" onError="this.src='images/premios/replace.png'"/>
            <h5>
                {{premio_seleccionado.premio}}
                <br/>
                <small>Marca: {{premio_seleccionado.marca}}</small>
            </h5>
            <h6>{{premio_seleccionado.puntos_actuales}} Puntos</h6>

            <p ng-show="premio_seleccionado.solo_call == 1">
                estos premios sólo se pueden redimir por nuestro call center
                en la línea 018000 413580
            </p>   
            <p ng-show="premio_seleccionado.solo_call == 0">
                {{premio_seleccionado.descripcion}}
            </p>

            <button class="button" data-open="modal_carrito"
                    ng-show=" premio_seleccionado.solo_call == 0 || usuario_en_sesion.id_rol == 2"
                    ng-click="AgregarAlCarrito()">
                <i class="fa fa-shopping-basket"></i> Agregar al Carrito
            </button>
            <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="reveal" id="modal_carrito" data-reveal>
            <div class=" grid-container">
                <div class="grid-x grid-margin-x">
                    <div class="col small-12">
                        <h4>Carrito de premios</h4>
                    </div>                    
                    <div class="col small-12 medium-6">
                        <h5>
                            Premios Seleccionados
                        </h5>
                    </div>
                    <div class="col small-12 medium-6 text-right">
                        <h5>
                            <small>
                                {{saldo_disponible| number}} 
                            </small>
                            Puntos restantes
                        </h5>
                    </div>
                    <div class="col small-12" style="max-height: 300px; overflow-y: auto;">
                        <table>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Premio</th>
                                    <th>Puntos</th>
                                    <th>Num tarjeta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="premio in carrito.elementos track by $index">
                                    <td>
                                        <button class="tiny button" ng-click="QuitarDelCarrito($index)">
                                            <i class="fa fa-remove"></i>
                                        </button>
                                    </td>
                                    <td>{{premio.premio}}</td>
                                    <td>{{premio.puntos_actuales}}</td>
                                    <td>
                                        <input type="text" ng-model="premio.comentario" placeholder="Descripción del premio EJ: talla o color o número de celular" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col small-12">
                        <div class="expanded button-group">
                            <button class="button" data-close aria-label="Close modal">
                                <i class="fa fa-eye"></i> Seleccionar más Premios
                            </button>
                            <button class="button success" data-open="modal_confirmar">
                                <i class="fa fa-shopping-bag"></i> Confirmar Este Premio
                            </button>
                        </div>
                    </div>
                </div>
                <button class="button alert text-right " data-close aria-label="Close modal" type="button">
                    Cerrar
                </button>
            </div>
        </div>

        <div class="reveal" id="modal_confirmar" data-reveal>
            <div class=" grid-container">
                <div class="grid-x grid-margin-x">
                    <div class="col small-12">
                        <h4>Confirmar Redenciones</h4>
                    </div>                    
                    <div class="col small-12" ng-show="datos_usuario.direccion == '' || datos_usuario.telefono == '' || datos_usuario.ciudad == ''">
                        Debe actualizar sus datos para proceder con la redención 
                    </div>
                    <div class="col small-12">
                        <h5>Información Envio</h5>
                        <table ng-init="editar_direccion = false">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Ciudad</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{datos_usuario.nombre}}</td>
                                    <td>{{datos_usuario.telefono}}</td>
                                    <td>
                                        <span ng-show="!editar_direccion">{{direccion}}</span>
                                        <label ng-show="editar_direccion">
                                            <input type="text" maxlength="50" ng-model="datos_usuario.direccion" />
                                        </label>
                                    </td>
                                    <td ng-show="!editar_direccion">
                                        {{datos_usuario.ciudad}}
                                    </td>
                                    <td ng-show="editar_direccion">
                                        <label ng-show="ciudades.length == 0">
                                            <input type="text" placeholder="Nombre de la ciudad" ng-blur="BuscarCiudad()" ng-model="nombre_ciudad" />
                                        </label>
                                        <label ng-show="ciudades.length > 0">
                                            <select id="dd_ciudad_usuario" ng-model='nombre_ciudad' ng-change="VerificarCambios()">
                                                <option ng-repeat="ciudad in ciudades track by $index" value='{{ciudad.nombre}}'>{{ciudad.nombre}}</option>
                                            </select>
                                        </label>
                                    </td>
                                    <td>
                                        <button class="button small" ng-show="!editar_direccion" ng-click="editar_direccion = true;"><i class="fa fa-edit"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>                        
                    </div>
                    <div class="col small-12" style="max-height: 200px; overflow-y: auto;">
                        <h5>Lista de premios</h5>
                        <table>
                            <thead>
                                <tr>
                                    <th>Premio</th>
                                    <th>Puntos</th>
                                   <th>Num Tarjeta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="premio in carrito.elementos track by $index">
                                    <td>{{premio.premio}}</td>
                                    <td>{{premio.puntos_actuales}}</td>
                                   <td>{{premio.comentario}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col small-12">
                        <div class="expanded button-group">
                            <button class="button" data-close aria-label="Close modal">
                                <i class="fa fa-eye"></i> Seleccionar más Premios
                            </button>
                            <button class="button success" 
                                    ng-disabled="datos_usuario.direccion == '' || datos_usuario.telefono == '' || datos_usuario.ciudad == ''"
                                    data-open="modal_resultado_registro" 
                                    ng-click="GuardarRedenciones()">
                                <i class="fa fa-shopping-bag"></i>Guardar y finalizar
                            </button>
                            <br/>
                        </div>
                    </div>
                </div>
            </div>
            <button class="button alert text-right " data-close aria-label="Close modal" type="button">
                Cerrar
            </button>
        </div>

        <div class="reveal" id="modal_resultado_registro" data-reveal>
            <div class=" grid-container">
                <div class="grid-x grid-margin-x">
                    <div class="col small-12">
                        <h4>Resultado Redenciones</h4>
                    </div>
                    <div class="col small-12" ng-show="redenciones_registrada.length == null">
                        <img src="images/loader.gif" style="width: 100%;" />
                    </div>
                    <div class="col small-12" style="max-height: 400px; overflow-y: auto;" ng-show="redenciones_registrada.length > 0" >
                        <h5>Lista de premios</h5>
                        <table>
                            <thead>
                                <tr>
                                    <th>Premio</th>
                                    <th>Puntos</th>
                                    <th>Num Tarjeta</th>
                                    <th>Folio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="premio in redenciones_registrada track by $index" ng-show="premio.error == ''">
                                    <td>{{premio.premio}}</td>
                                    <td>{{premio.puntos}}</td>
                                    <td>{{premio.comentario}}</td>
                                    <td>{{premio.folio}}</td>
                                </tr>
                            </tbody>
                        </table>


                        <button class="button alert" data-close aria-label="Close modal">Cerrar</button>
                    </div>
                    <div class="col small-12 text-center" ng-show="redenciones_registrada.length == 0">
                        <p>
                            Ocurrió un error en el registro de las redenciones
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'componentes/coponentes_js.php'; ?>
    </body>
</html>