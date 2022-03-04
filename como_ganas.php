<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
    <head>
        <?php include 'componentes/componentes_basicos.php'; ?>
        <script>
            var usuario_en_sesion = <?php echo json_encode($_SESSION["usuario"]); ?>;
        </script> 
    </head>
    <body>        
        <div id="main_container" class="grid-container off-canvas-content">
            <div class="callout1">
                <?php include 'componentes/controles_superiores.php'; ?>
                <?php include 'componentes/menu.php'; ?>
                <div class="cell medium-12 large-12">
                    <img class="orbit-image" src="images/como-ganas3.jpg" alt="">               
                </div>  
                <?php include 'componentes/footer.php'; ?>
            </div>           
        </div>
        <?php include 'componentes/coponentes_js.php'; ?>  
    </body>
</html>