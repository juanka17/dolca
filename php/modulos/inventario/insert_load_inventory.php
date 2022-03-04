<?php

require_once('../../conf/conex.php');

header("Content-Type: application/json; charset=UTF-8");

try {

    $dataRequest = !empty($_REQUEST) ? $_REQUEST : json_decode(file_get_contents('php://input'), true);

    $dataFile = !empty($_FILES) ? $_FILES : '';

    /*
    print_r($_REQUEST);

    print_r($_FILES);     
     */

    if ($_REQUEST) {
        extract($_REQUEST);
    } else {
        exit;
    }

    $csv_file = $dataFile['csv']['tmp_name'];

    $conexion = new Conexion();
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec("set names utf8");

    $conexion->beginTransaction();
    $handle = fopen($csv_file, 'r');    

//unset the first line like this
    fgets($handle);

    while (($data = fgetcsv($handle, 1000, ';')) !== false) {

        /*

        $params[':fecha'] = $data[0];
        $params[':tipo_vidrio'] = $data[1];
        $params[':cantidad'] = $data[2];
        $params[':espesor'] = $data[3];        

        # print_r($params);
        # CAST('19.45' AS DECIMAL(5,2))
        */

        $replace = str_replace(",", ".", $data[2]);
        
        $sql = "INSERT INTO `inventario_lista`(`id_inventario_lista`, `cedula_usuario`, `id_usuarios`, `id_almacenes`, `fecha`,  `id_categoria_productos`, `cantidad`, `espesor`) 
        SELECT
        IF( MAX(`id_inventario_lista`) IS NULL, 1, MAX(`id_inventario_lista`) + 1) as id_inventario_lista,    
        $cedula,
        $id_usuarios,
        $id_almacenes,    
        '$data[0]',    
        '$data[1]',
        '$replace',
        $data[3]
        FROM `inventario_lista`
        ";

 

    
        $query = $conexion->prepare($sql);
        $result = $query->execute();
        /*


        $query = $conexion->prepare($sql);
        $result = $query->execute($params);
        */

    }

    fclose($handle);

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
