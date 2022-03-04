<?php
include_once('clsDDBBOperations.php');
include_once('consultas.php');

class clsReportes
{
    public static function EjecutarOperacion($operacion, $parametros)
    {
        switch ($operacion)
        {
            case "participantes": $datos = clsReportes::ReporteParticipantes($parametros);break;
            case "participantes_con_datos": $datos = clsReportes::ReporteParticipantesConDatos($parametros);break;
            case "productos_registrados": $datos = clsReportes::ReporteProductosRegistrados($parametros);break;
            case "bonos_solicitados": $datos = clsReportes::ReporteBonosSolicitados($parametros);break;
            case "estado_bonos": $datos = clsReportes::ReporteEstadoBonos($parametros);break;
            case "facturas": $datos = clsReportes::ReporteFacturas($parametros);break;
            case "llamadas": $datos = clsReportes::ReporteLamadas($parametros);break;
        }
        return clsReportes::ProcesarDatos($datos);
    }
    
    private static function ProcesarDatos($datos)
    {
        if(count($datos))
        {
            $headers = array();
            $colCount = 0;
            if(count($datos) > 0)
            {
                foreach ($datos[0] as $columName => $rowDefiner)
                {
                    $headers[$colCount] = $columName;
                    $colCount++;
                }
            }

            $data = array("header" => $headers, "data" => $datos);
        }
        
        return $data;
    }
    
    private static function ReporteParticipantes($parametros)
    {
        $query = Consultas::$participantes;
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }

    private static function ReporteParticipantesConDatos($parametros)
    {
        $query = Consultas::$participantes_con_registro;
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }
    
    private static function ReporteProductosRegistrados($parametros)
    {
        
        $query = Consultas::$ReporteProductosRegistrados;
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }
    
    private static function ReporteBonosSolicitados($parametros)
    {
        
        $query = Consultas::$ReporteBonosSolicitados;
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }
    
    private static function ReporteEstadoBonos($parametros)
    {
        
        $query = Consultas::$ReporteEstadoBonos;
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }
    
    private static function ReporteFacturas($parametros)
    {
        $query = Consultas::$ReporteFacturas;
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }
    private static function ReporteLamadas($parametros)
    {
        $query = Consultas::$ReporteLlamadas;
        $results = clsDDBBOperations::ExecuteSelectNoParams($query);
        return $results;
    }
    
    
}
    
?>