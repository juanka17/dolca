<div id="menu_vidrios" data-sticky-container>
    <div data-options="marginTop:0;">

        <div class="title-bar" data-responsive-toggle="example-menu" data-hide-for="medium">
            <button class="menu-icon" type="button" data-toggle="example-menu"></button>
            <div class="title-bar-title">Menu</div>
        </div>

        <div class="top-bar" id="example-menu">
            <?php
            //rol de admin formas
            if ($_SESSION["usuario"]["id_rol"] == 1) {
            ?>
                <div class="grid-container">
                    <div id="main">
                        <ul class="vertical medium-horizontal dropdown menu" data-responsive-menu="accordion medium-dropdown">
                            <li><a href="bienvenida.php"><i class="fa fa-home"></i> Inicio</a></li>
                            <li><a href="crear_usuario.php"><i class="fa fa-plus"></i> Crear Participante</a></li>
                            <li><a href="listado_usuarios.php"><i class="fa fa-search"></i> Buscar Participante</a></li>
                            <li><a href="reportes.php"><i class="fa fa-list"></i> Reportes</a></li>
                            <li><a href="graficas.php"><i class="fa fa-pie-chart"></i> Gráficas</a></li>
                        </ul>
                    </div>
                </div>
            <?php
                //rol admin nestle
            } else if ($_SESSION["usuario"]["id_rol"] == 3) {
            ?>
                <div class="grid-container">
                    <div id="main">
                        <ul class="vertical medium-horizontal dropdown menu" data-responsive-menu="accordion medium-dropdown">
                            <li><a href="bienvenida.php"><i class="fa fa-home"></i> Inicio</a></li>
                            <li><a href="reportes.php"><i class="fa fa-list"></i> Reportes</a></li>
                            <li><a href="graficas.php"><i class="fa fa-pie-chart"></i> Gráficas</a></li>
                        </ul>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>