<?php

require_once './environment.php';

class Conexion extends PDO {

    private $tipo_de_base = 'mysql';
    private $host = host;
    private $nombre_de_base = '';
    private $usuario = dbUser;
    private $contrasena = dbPassword;
    private $port = dbPort;

    public function __construct() {
        try {
            parent::__construct($this->tipo_de_base . ':host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->nombre_de_base, $this->usuario, $this->contrasena);

            echo 'exitosa conexion';
            echo '<br>';
        } catch (PDOException $e) {
            echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
            echo '<br>';
            exit;
        }
    }

}

try {

    $conexion = new Conexion();
 
     $database = '../../sql/vandino.sql';


    if (!is_file($database)) {

        throw new Exception('Archivos No Existen');
        echo '<br>';
    } else {

        $accesoSql = file_get_contents($database);

    }

 
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $conexion->beginTransaction();
        
    $conexion->exec('DROP DATABASE IF EXISTS vandino;');
    $conexion->exec('CREATE DATABASE vandino;');
    $conexion->exec('USE vandino;');
    $conexion->exec($accesoSql);
    echo 'SE HA CREADO BDD vandino' . '<br>';
    echo '<br>';


   //  $conexion->commit();

} catch (PDOException $e) {
    
    echo 'Fallo: ' . $e->getMessage();
   //  $conexion->rollBack();
} catch (Exception $e) {

    echo 'Fallo: ' . $e->getMessage();
    // $conexion->rollBack();
}
