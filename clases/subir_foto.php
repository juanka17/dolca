<?php

$target_dir = dirname(__FILE__). "/perfil_foto";

$img_exhibicion = $_FILES['img_perfil'];

$target_file_exhibicion = $target_dir."/".$_FILES["img_perfil"]["name"];

print_r($target_file_exhibicion);
echo " -- ";

if(move_uploaded_file($_FILES["img_perfil"]["tmp_name"], $target_file_exhibicion))
{
    
}
else
{
    echo "error: ".$_FILES["img_perfil"]["error"];
}

echo "ok";
?>