<!doctype html>
<html class="no-js" lang="es" dir="ltr">
    <head>
        <?php include 'componentes/componentes_basicos.php'; ?>
        <script src="interfaces/index.js?reload=4" type="text/javascript"></script>
        <style>                      

            input[type=text] {
                border-radius: 20px;
            }

            input[type=password] {
                border-radius: 20px;
            }            

            #logo_ingreso {
                width: 23%;
                margin-top: 35px;
            }
            #texto
            {
                padding: 50px 0px 0px 0px;               
            }
            h1, .h1,
            h2, .h2,
            h3, .h3,
            h4, .h4,
            h5, .h5,
            h6, .h6
            {
                color: black;
                font-family: 'Roboto', sans-serif;
                font-weight: bold;
            }
            #footer_index
            {
                background-color: white;
            }
            @media screen and (max-width: 39.9375em) 
            {
                #texto
                {
                    padding: 0px 0px 0px 0px;
                }
            }            

        </style>
    </head>
    <body ng-app="indexApp" ng-controller="indexController" id="body_index">
        <?php include 'componentes/controles_superiores.php'; ?>
        <div class="grid-container fluid" id="login-box">
            <div class="grid-x grid-margin-x">
                <div class="cell small-12 medium-12 text-center">
                    <div class="cell small-12 medium-6">            
                        <label>
                            <h6>Usuario</h6>
                            <input type="text" placeholder="Número de documento" ng-model="datos_usuario.cedula">
                        </label>
                    </div>
                    <div class="cell small-12 medium-6">
                        <label>
                            <h6>Contraseña</h6>
                            <input type="password"  placeholder="Contraseña" ng-model="datos_usuario.clave">
                        </label>
                    </div>
                    <div class="cell small-12 medium-6 text-center">
                        <button style="border-radius:20px;" class="button small expanded" ng-click="Login()"> Ingresar </button>
                    </div>                    
                </div> 
            </div>
        </div>
        <div class="reveal" id="restaurarClave1" data-reveal>
            <h1>Restaurar clave</h1>
            <div class="grid-x">
                <div class="cell medium-12 text-left">
                    <div class="form-group">
                        <label >Ingrese su correo electrónico registrado:</label>
                        <input class="form-control" type='text' ng-model="datos_usuario.email" />
                    </div>
                    * Si no tiene un correo registrado<br/>
                    comunicate a la <strong>linea Linéa Atención 018000-416717</strong>
                    <br/>
                    <button class="button primary" ng-click="RestaurarClave()">
                        Restaurar clave
                    </button>
                </div>
            </div>
            <div class="grid-x" style="display:none; height: 300px;" id='pnlLoad'>
                <div class="cell-medium-12">
                    <img src="images/loader.gif" />
                </div>
            </div>
            <div class="grid-x">
                <div class="cell medium-12">
                    {{errorRecordar}}
                </div>
            </div>
            <div class="grid-x">
                <div class="cell medium-12">
                    {{recordarOk}}
                </div>
            </div>
            <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
        <?php include 'componentes/coponentes_js.php'; ?>

    </body>
</html>