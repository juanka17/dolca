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
$dataForm = json_decode($dinamyc);
$archivo = array();

$query = "select * from codigos_participantes";
$results =  clsDDBBOperations::ExecuteSelectNoParams($query);

$pila = array();

foreach ($results as $key => $value) {
    array_push($pila, $value['codigo']);
}


foreach($dataForm as $data) {

    foreach($data as $clave => $valor) {
        if($clave == 'codigo'){ 
            if(in_array($valor, $pila) == 1)
            {
                $valido = 1;
            }else{
                $valido = 0;
            }
        }
        
        $archivo["id_producto"] = $id_producto;
        $archivo["id_participante"] = $id_usuario;
        $archivo["estado"] = 0;
        $archivo["valido"] = $valido;
        $archivo["id_registro"] = $id_registra;
        $archivo[$clave] = $valor;       
    } 
    $result =  DB::insert("productos_registrados", $archivo);    

}

$query_validacion = "call sp_validacion_codigos();";
$results_validacion =  clsDDBBOperations::ExecuteSelectNoParams($query_validacion);


$mensaje = [];
$mensaje['request'] = $_REQUEST;
$mensaje['success'] = true;
$mensaje['msj'] = "se almaceno registro";

print json_encode($mensaje);    

$depth = DB::commit(); // commit the outer transaction


}  catch (PDOException $e) {
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