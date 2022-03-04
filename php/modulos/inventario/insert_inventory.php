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

    #CAST( '$cantidad' AS DECIMAL(5,2)),

    $replace = str_replace(",", ".", $cantidad);

    $sql = "INSERT INTO `inventario_lista`(`cedula_usuario`, `id_usuarios`, `id_almacenes`, `fecha`, `id_inventario_lista`, `id_categoria_productos`, `cantidad`, `espesor`) 
    SELECT
     $cedula,
     $id_usuarios,
     $id_almacenes,             
     '$fecha',
    IF( MAX(`id_inventario_lista`) IS NULL, 1, MAX(`id_inventario_lista`) + 1) as id_inventario_lista,
     '$id_categoria_productos',
     '$replace',
     '$espesor'
    FROM `inventario_lista`
    ";

    #print $sql;

    $query = $conexion->prepare($sql);
    $result = $query->execute();

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
    $mensaje['msj'] = 'ERROR: PDOException' . $e->getMessage();
    print json_encode($mensaje);
    $conexion->rollBack();
} catch (Exception $e) {
    $mensaje['sql'] = $sql;
    $mensaje['request'] = $_REQUEST;
    $mensaje['success'] = false;
    $mensaje['msj'] = 'ERROR: PDOException' . $e->getMessage();
    print json_encode($mensaje);
    $conexion->rollBack();
} catch (Throwable $e) {
    $mensaje['sql'] = $sql;
    $mensaje['request'] = $_REQUEST;
    $mensaje['success'] = false;
    $mensaje['msj'] = 'ERROR: PDOException' . $e->getMessage();
    print json_encode($mensaje);
    $conexion->rollBack();
}
