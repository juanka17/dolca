<?php

require_once('../../conf/conex.php');

header("Content-Type: application/json; charset=UTF-8");

if ($_REQUEST) {
    extract($_REQUEST);
} else {
    exit;
}

try {
    $conexion = new Conexion();
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec("set names utf8");

    if ($search === 'id') {

        $sql = " SELECT i.*, c.nombre as producto, a.nombre as almacen
                    FROM inventario_lista as i 
                    inner join categoria_productos as c on i.id_categoria_productos = c.id
                    inner join almacenes as a on a.id = i.id_almacenes "
                . "WHERE cedula_usuario = '$id_inventario_lista' ;";

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

        $sql = " SELECT i.*, c.nombre as producto, a.nombre as almacen
                    FROM inventario_lista as i 
                    inner join categoria_productos as c on i.id_categoria_productos = c.id
                    inner join almacenes as a on a.id = i.id_almacenes";

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