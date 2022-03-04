<?php

require_once('../../conf/conex.php');

header("Content-Type: application/json; charset=UTF-8");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


if ($_REQUEST) {
    extract($_REQUEST);
} else {
    exit;
}

/*
 *         $sql = "SELECT 
  a.id,
  a.`id_usuario`,
  a.`fecha_factura`,
  a.`id_categoria`,
  a.`milimetros`,
  a.`metros`,
  p.nombre as producto
  FROM `archivos` as a inner join categoria_productos as p on a.id_categoria = p.id
  WHERE a.id_usuario = 'id_usuario' ;";
 * 
 *         $sql = "SELECT 
  id,
  `id_usuario`,
  `fecha`,
  `id_periodo`,
  `num_factura`,
  `metros`,
  descripcion
  FROM estado_cuenta
  WHERE id_usuario = 'id_usuario' ;";
 * 
 */

try {
    $conexion = new Conexion();
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec("set names utf8");

    if ($search === 'id') {

        $sql = "SELECT 
                a.id,
                a.`id_usuario`,
                usu.nombre,
                a.`fecha_factura`,
                a.`nombre_producto_negocio`,
                a.`nombre_producto_homologado`,
                a.`cantidad`,
                ROUND(a.`cantidad`) as puntos,
                a.validacion,
                a.num_factura,
                a.img_factura,
                CASE
                WHEN a.id_almacen = 0 THEN 'Exito'
                WHEN a.id_almacen = 1 THEN 'Carulla'
                WHEN a.id_almacen = 2 THEN 'Olímpica'
                WHEN a.id_almacen = 3 THEN 'Farmatodo'
                WHEN a.id_almacen = 4 THEN 'Jumbo'
                WHEN a.id_almacen = 5 THEN 'Metro'
                ELSE 'The quantity is under 30'
            END almacen  
                FROM `archivos` as a 
                inner join usuarios as usu on usu.id = a.id_usuario
                WHERE a.id_usuario = '$id_usuario' ;";

        $stmt = $conexion->prepare($sql);

        $stmt->execute();
        // Especificamos el fetch mode antes de llamar a fetch()
        if (!$stmt) {
            echo 'Error al ejecutar la consulta';
        } else {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $mensaje = [];
            $mensaje['sql'] = $sql;
            $mensaje['request'] = $_REQUEST;
            $mensaje['success'] = true;
            $mensaje['msj'] = "se consulto registros";
            $mensaje['data'] = $results;
            echo json_encode($mensaje);
        }
    }

    if ($search === 'general') {

        $sql = "SELECT 
                a.id,
                a.`id_usuario`,
                usu.nombre,
                a.`fecha_factura`,
                a.`nombre_producto_negocio`,
                CASE
                WHEN a.nombre_producto_homologado = 1 THEN 'Chocolate Abuelita'
                WHEN a.nombre_producto_homologado = 2 THEN 'MILO® Vending'
                WHEN a.nombre_producto_homologado = 3 THEN 'Cappuccino Original'
                WHEN a.nombre_producto_homologado = 4 THEN 'Cappuccino Vainilla'
                WHEN a.nombre_producto_homologado = 5 THEN 'Chococcino Coco'
                WHEN a.nombre_producto_homologado = 6 THEN 'Café latte Vainilla'
                WHEN a.nombre_producto_homologado = 7 THEN 'Tinto'
                WHEN a.nombre_producto_homologado = 8 THEN 'Cortado'
                WHEN a.nombre_producto_homologado = 9 THEN 'Espresso'
                WHEN a.nombre_producto_homologado = 10 THEN 'Espresso Doble'
                WHEN a.nombre_producto_homologado = 11 THEN 'Ristreto'
                WHEN a.nombre_producto_homologado = 12 THEN 'Americano'
                WHEN a.nombre_producto_homologado = 13 THEN 'Latte'  
                WHEN a.nombre_producto_homologado = 14 THEN 'Mokanella Capuccino'  
                ELSE 'The quantity is under 30'
            END nombre_producto_homologado,
                a.`cantidad`,
                ROUND(a.`cantidad`) as puntos,
                a.validacion,
                a.num_factura,
                a.img_factura,
                CASE
                    WHEN a.id_almacen = 0 THEN 'Exito'
                    WHEN a.id_almacen = 1 THEN 'Carulla'
                    WHEN a.id_almacen = 2 THEN 'Olímpica'
                    WHEN a.id_almacen = 3 THEN 'Farmatodo'
                    WHEN a.id_almacen = 4 THEN 'Jumbo'
                    WHEN a.id_almacen = 5 THEN 'Metro'
                ELSE 'The quantity is under 30'
            END almacen  
                FROM `archivos` as a 
                inner join usuarios as usu on usu.id = a.id_usuario
                where a.validacion = 0";

        $stmt = $conexion->prepare($sql);

        $stmt->execute();
        // Especificamos el fetch mode antes de llamar a fetch()
        if (!$stmt) {
            echo 'Error al ejecutar la consulta';
        } else {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $mensaje = [];
            $mensaje['sql'] = $sql;
            $mensaje['request'] = $_REQUEST;
            $mensaje['success'] = true;
            $mensaje['msj'] = "se consulto registros";
            $mensaje['data'] = $results;
            echo json_encode($mensaje);
        }
    }
} catch (PDOException $e) {
    echo 'ERROR: PDOException' . $e->getMessage();
} catch (Exception $e) {
    echo 'ERROR: Exception' . $e->getMessage();
} catch (Throwable $e) {
    echo 'ERROR: Throwable' . $e->getMessage();
}