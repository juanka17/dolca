<?php include 'componentes/control_sesiones.php'; ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include 'componentes/componentes_basicos.php'; ?>
    <script src="interfaces/graficas.js?ver=3" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
    </style>
</head>

<body ng-app="graficaApp" ng-controller="graficaController">

    <div id="main_container" class="grid-container off-canvas-content">
        <div class="callout1">
            <?php include 'componentes/controles_superiores.php'; ?>
            <?php include 'componentes/menu.php'; ?>
            <div class="grid-x grid-padding-x">
                <div class="cell medium-12 large-6">
                    <div id="chart"></div>
                </div>
                <div class="cell medium-12 large-6">
                <h5>Bonos Entregados</h5>
                    <div id="chart_valores"></div>
                </div>
                <div class="cell medium-12 large-12">
                <h5>Participantes Inscritos Por fecha</h5>
                    <div id="chart_dias"></div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'componentes/coponentes_js.php'; ?>
</body>

</html>