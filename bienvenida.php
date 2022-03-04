<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <?php include 'componentes/componentes_basicos.php'; ?>
        <script src="interfaces/bienvenida.js" type="text/javascript"></script>
        <script>
            var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
        </script> 
    </head>
    <body ng-app="bienvenidaApp" ng-controller="bienvenidaController">        

        <div id="main_container" class="grid-container off-canvas-content">
            <div class="callout1">
                <?php include 'componentes/controles_superiores.php'; ?>
                <?php include 'componentes/menu.php'; ?>
                <div class="cell medium-12 large-12">
                    <div class="orbit" role="region" aria-label="Favorite Space Pictures" data-orbit data-options="animInFromLeft:fade-in; animInFromRight:fade-in; animOutToLeft:fade-out; animOutToRight:fade-out;">
                        <ul class="orbit-container">
                            <button class="orbit-previous" aria-label="previous"><span class="show-for-sr">Previous Slide</span>&#9664;</button>
                            <button class="orbit-next" aria-label="next"><span class="show-for-sr">Next Slide</span>&#9654;</button>                                
                            <li class="is-active orbit-slide">
                                <figure class="orbit-figure">
                                    <img class="orbit-image" src="images/banners/bienvenida.jpg" alt="">  
                                </figure>
                            </li>                                     
                        </ul>
                    </div>
                    <br/>                    
                </div>  
            </div>           
        </div>
        <?php include 'componentes/coponentes_js.php'; ?>  
    </body>
</html>