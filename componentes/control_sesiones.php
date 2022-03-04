<?php
session_start();

if(isset($_GET["logout"]))
{
    session_destroy();
    header("Location: index.php");
    die();
}

$url = explode("/", $_SERVER['PHP_SELF']);
if($url[(count($url) - 1)] != "index.php")
{
    if(count($_SESSION) == 0)
    {
        session_destroy();
        header("Location: index.php");
        die();
    }
    else
    {
        if($_SESSION["usuario"]["acepto_terminos"] == 0 && $url[(count($url) - 1)] != "formulario_usuario.php")
        {
            $url_mis_datos = "Location: formulario_usuario.php?id_usuario=".$_SESSION["usuario"]["id"];
            header($url_mis_datos);
        }
    }
}
else
{
    $_SESSION["usuario"] = null;
    $_SESSION["afiliadoSeleccionado"] = null;
    session_destroy();
}

?>