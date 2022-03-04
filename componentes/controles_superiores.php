<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M2BBD28"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div id="snackbar">Some text some message..</div>
<?php
$file_name = basename($_SERVER["SCRIPT_FILENAME"], '.php');
if ($file_name != "index" && $file_name != "index_especial") {
    ?>
    <div class="grid-x" id="header_usuario">
        <div class="cell small-5 medium-4">            
           
        </div>
        <div class="cell small-12  medium-4 text-center hide-for-small-only" id="contenedor_puntos">
            
        </div>
        <div class="cell small-7 medium-4" id="datos_usuario"> 
            <div class="grid-x grid-margin-x">
                <div class="cell small-12 medium-4" id="imagenperfil">            
                    <i class="fa fa-user-circle-o fa-4x hide-for-small-only"></i>
                </div>
                <div class="cell small-12  medium-8 text-left" id="nombre_usuario"> 
                    <span > <?php echo $_SESSION["usuario"]["nombre"]; ?></span>  
                    <hr/>
                    <a  href="formulario_usuario.php?id_usuario=<?php echo $_SESSION["usuario"]["id"]; ?>"><i class="fa fa-search"></i> Mis Datos</a>
                    <br/>
                    <a href="?logout"><i class="fa fa-sign-out"></i>  Salir</a>
                </div>
            </div>
        </div>
        <div class="cell small-12 medium-2 text-center show-for-small-only" id="contenedor_puntos">
            <h3 id="puntoss">Tienes <?php echo number_format($_SESSION["usuario"]["saldo_actual"]); ?> Puntos</h3>
        </div>
    </div>
    <?php
}
?>