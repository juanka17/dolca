<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('clsDDBBOperations.php');
include_once('meekrodb.2.3.class.php');

extract($_REQUEST);


DB::$nested_transactions = true;

$depth = DB::startTransaction();
try {
    $formDataFactura = json_decode($dinamyc);
    $archivo = array();
    $archivo_detalle = array();




       
        $archivo["id_participante"] = $id_usuario;
        $archivo["lugar_compra"] = $lugar_factura;
        $archivo["fecha_registro"] = $fecha_registro;
        $archivo["id_registra"] = $id_registra;

        $result =  DB::insert("factura", $archivo);    

  

    $id_nueva_factura = clsDDBBOperations::GetLastInsertedId();

    foreach ($formDataFactura as $data) {

        foreach ($data as $clave => $valor) {


            
            $archivo_detalle["id_factura"] = $id_nueva_factura;
            $archivo_detalle[$clave] = $valor;
        }
        $result =  DB::insert("factura_detalle", $archivo_detalle);    

    }

    $mensaje = [];
    $mensaje['request'] = $_REQUEST;
    $mensaje['success'] = true;
    $mensaje['msj'] = "se almaceno registro";

    print json_encode($mensaje);

    $depth = DB::commit(); // commit the outer transaction


} catch (PDOException $e) {
    #$mensaje['sql'] = $sql;
    $mensaje['request'] = $_REQUEST;
    $mensaje['success'] = false;
    $mensaje['msj'] = 'ERROR: PDOException ' . $e->getMessage();
    print json_encode($mensaje);
    DB::rollBack();
} catch (Exception $e) {
    #$mensaje['sql'] = $sql;
    $mensaje['request'] = $_REQUEST;
    $mensaje['success'] = false;
    $mensaje['msj'] = 'ERROR: Exception ' . $e->getMessage();
    print json_encode($mensaje);
    DB::rollBack();
} catch (Throwable $e) {
    #$mensaje['sql'] = $sql;
    $mensaje['request'] = $_REQUEST;
    $mensaje['success'] = false;
    $mensaje['msj'] = 'ERROR: Throwable ' . $e->getMessage();
    print json_encode($mensaje);
    DB::rollBack();
}
