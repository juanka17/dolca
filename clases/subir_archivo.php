<?php

$target_dir = dirname(__FILE__). "/evaluacion/";

print_r($_GET["id_usuario"]);

$img_avisos = $_FILES['img_avisos'];
$img_exhibidores = $_FILES['img_exhibidores'];
$img_graphic_floor = $_FILES['img_graphic_floor'];
$img_branding_vehiculo = $_FILES['img_branding_vehiculo'];
$img_branding_local = $_FILES['img_branding_local'];

$target_file_avisos = $target_dir.$_GET["id_usuario"]."_".$_GET["id_periodo"]."_".$_FILES["img_avisos"]["name"];
$target_file_exhibidores = $target_dir.$_GET["id_usuario"]."_".$_GET["id_periodo"]."_".$_FILES["img_exhibidores"]["name"];
$target_file_graphic_floor = $target_dir.$_GET["id_usuario"]."_".$_GET["id_periodo"]."_".$_FILES["img_graphic_floor"]["name"];
$target_file_branding_vehiculo = $target_dir.$_GET["id_usuario"]."_".$_GET["id_periodo"]."_".$_FILES["img_branding_vehiculo"]["name"];
$target_file_branding_local = $target_dir.$_GET["id_usuario"]."_".$_GET["id_periodo"]."_".$_FILES["img_branding_local"]["name"];

print_r($target_file_avisos);
echo " -- ";
print_r($target_file_exhibidores);
echo " -- ";
print_r($target_file_graphic_floor);
echo " -- ";
print_r($target_file_branding_vehiculo);
echo " -- ";
print_r($target_file_branding_local);

if(move_uploaded_file($_FILES["img_avisos"]["tmp_name"], $target_file_avisos))
{
    
}
else
{
    echo "error: ".$_FILES["img_avisos"]["error"];
}
if(move_uploaded_file($_FILES["img_exhibidores"]["tmp_name"], $target_file_exhibidores))
{
    
}
else
{
    echo "error: ".$_FILES["img_exhibidores"]["error"];
}
if(move_uploaded_file($_FILES["img_graphic_floor"]["tmp_name"], $target_file_graphic_floor))
{
    
}
else
{
    echo "error: ".$_FILES["img_graphic_floor"]["error"];
}
if(move_uploaded_file($_FILES["img_branding_vehiculo"]["tmp_name"], $target_file_branding_vehiculo))
{
    
}
else
{
    echo "error: ".$_FILES["img_branding_vehiculo"]["error"];
}
if(move_uploaded_file($_FILES["img_branding_local"]["tmp_name"], $target_file_branding_local))
{
    
}
else
{
    echo "error: ".$_FILES["img_branding_local"]["error"];
}

echo "ok";
?>