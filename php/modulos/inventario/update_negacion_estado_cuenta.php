<?php

require_once('../../conf/conex.php');

header("Content-Type: application/json; charset=UTF-8");


try {
    if ($_REQUEST) {
        extract($_REQUEST);
    } else {
        exit;
    }

    $conexion = new Conexion();
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec("set names utf8");

    $conexion->beginTransaction();


    $sql = "INSERT INTO `negacion_factura`(`id_negacion_factura`, `id_negacion_factura_tipo`, `id_negacion_archivo`) 
    SELECT
    IF( MAX(`id_negacion_factura`) IS NULL, 1, MAX(`id_negacion_factura`) + 1) as id_negacion_factura,
     $id_negacion_factura_tipo,
     $id_negacion_archivo
     FROM 
     `negacion_factura`
    ";
    
    $query = $conexion->prepare($sql);
    $result = $query->execute();
    
    if ($result) {
        $update_estado  =  "UPDATE archivos SET validacion = 2 WHERE id = '$id_negacion_archivo'";
        $query2 = $conexion->prepare($update_estado);
        $result2 = $query2->execute();
    }

    $conexion->commit();

    $mensaje = [];
    $mensaje['sql'] = $sql;
    $mensaje['request'] = $_REQUEST;
    $mensaje['success'] = true;
    $mensaje['msj'] = "se almaceno registro";

    print json_encode($mensaje);
} catch (PDOException $e) {
    $mensaje['sql'] = $sql;
    $mensaje['request'] = $_REQUEST;
    $mensaje['success'] = false;
    $mensaje['msj'] = 'ERROR: PDOException ' . $e->getMessage();
    print json_encode($mensaje);
    $conexion->rollBack();
} catch (Exception $e) {
    $mensaje['sql'] = $sql;
    $mensaje['request'] = $_REQUEST;
    $mensaje['success'] = false;
    $mensaje['msj'] = 'ERROR: Exception ' . $e->getMessage();
    print json_encode($mensaje);
    $conexion->rollBack();
} catch (Throwable $e) {
    $mensaje['sql'] = $sql;
    $mensaje['request'] = $_REQUEST;
    $mensaje['success'] = false;
    $mensaje['msj'] = 'ERROR: Throwable ' . $e->getMessage();
    print json_encode($mensaje);
    $conexion->rollBack();
}
