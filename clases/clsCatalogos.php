<?php

include_once('clsDDBBOperations.php');
include_once('consultas.php');

class clsCatalogos
{
    public static function EjecutarOperacion($operacion, $parametros)
    {
        switch ($operacion) {
            case "CargaCatalogo":
                return clsCatalogos::EjecutarConsulta($parametros);
                break;
            case "RegistraCatalogoSimple":
                return clsCatalogos::EjecutarInsercion($parametros);
                break;
            case "RegistraCatalogoMixto":
                return clsCatalogos::EjecutarInsercionMixta($parametros);
                break;
            case "RegistraCatalogoMixtoMasivo":
                return clsCatalogos::EjecutarInsercionMixtaMasiva($parametros);
                break;
            case "ModificaCatalogoSimple":
                return clsCatalogos::EjecutarModificacion($parametros);
                break;
            case "ModificaCatalogoMixto":
                return clsCatalogos::EjecutarModificacionMixta($parametros);
                break;
            case "EliminaCatalogoSimple":
                return clsCatalogos::EjecutarEliminacion($parametros);
                break;
            case "EliminaCatalogoMixta":
                return clsCatalogos::EjecutarEliminacionMixta($parametros);
                break;
        }
    }

    private static function EjecutarConsulta($parametros)
    {
        $query = "SELECT * FROM " . $parametros->catalogo;
        $order = " ORDER BY 2";

        switch ($parametros->catalogo) {

            case "usuarios": {
                    $query = Consultas::$consulta_usuarios . " where usu.id = " . $parametros->id;
                    $order = " order by nombre ";
                };
                break;

            case "participantes": {
                    $query = Consultas::$participantes . " where par.id = " . $parametros->id;
                    $order = " order by nombre ";
                };
                break;

            case "llamadas_usuarios": {
                    $query = Consultas::$consulta_llamadas_usuarios . " where la.id_usuario = " . $parametros->id_usuario;
                    $order = " order by la.fecha desc ";
                };
                break;

            case "informacion_usuario": {
                    $query = "select * from usuarios where id = " . $parametros->id;
                    $order = " order by nombre ";
                };
                break;

            case "productos": {
                    $query = $query . " where id_tipo_producto = " . $parametros->id_tipo_producto;
                    $order = " order by id ";
                };
                break;

            case "verificar_producto": {
                    $query = Consultas::$productos_registrados . " WHERE id_participante = " . $parametros->id_participante;
                    $order = " order by id ";
                };
                break;

            case "validar_valor_total": {
                    $query = Consultas::$validar_valor_productos_registrados . " WHERE id_participante = " . $parametros->id_participante . " AND estado IN (1,2)";
                    $order = " order by id ";
                };
                break;

            case "obtener_bono": {
                    $query = Consultas::$bono_solicitado . " where valor = " . $parametros->valor . " AND estado = 0 LIMIT 1";
                    $order = " ";
                };
                break;

            case "guardarBono": {
                    $query = "call sp_guardar_codigos(" . $parametros->id_registro . "," . $parametros->id_participante . "," . $parametros->id_bono . "," . $parametros->id_registra . ")";
                    $order = " ";
                };
                break;

            case "grafica_productos": {
                    $query = Consultas::$grafica_productos;
                    $order = " ";
                };
                break;

            case "grafica_valores": {
                    $query = "call sp_valores_entregados();";
                    $order = " ";
                };
                break;

            case "grafica_dias": {
                    $query = "call sp_grafica_participantes_por_bonos();";
                    $order = " ";
                };
                break;
        }
        $query = $query . $order;
        return clsDDBBOperations::ExecuteSelectNoParams($query);
    }

    private static function EjecutarInsercion($parametros)
    {
        $result = clsDDBBOperations::ExecuteInsert((array)$parametros->datos, $parametros->catalogo);
        return clsCatalogos::EjecutarConsulta($parametros);
    }

    private static function EjecutarInsercionMixta($parametros)
    {
        $result = clsDDBBOperations::ExecuteInsert((array)$parametros->datos, $parametros->catalogo_real);
        return clsCatalogos::EjecutarConsulta($parametros);
    }

    private static function EjecutarInsercionMixtaMasiva($parametros)
    {
        foreach ($parametros->lista_datos as $datos) {
            $result = clsDDBBOperations::ExecuteInsert((array)$datos, $parametros->catalogo_real);
        }

        return clsCatalogos::EjecutarConsulta($parametros);
    }

    private static function EjecutarModificacion($parametros)
    {
        clsDDBBOperations::ExecuteUpdate((array)$parametros->datos, $parametros->catalogo, $parametros->id);
        return clsCatalogos::EjecutarConsulta($parametros);
    }

    private static function EjecutarModificacionMixta($parametros)
    {
        clsDDBBOperations::ExecuteUpdate((array)$parametros->datos, $parametros->catalogo_real, $parametros->id);
        return clsCatalogos::EjecutarConsulta($parametros);
    }

    private static function EjecutarEliminacion($parametros)
    {
        clsDDBBOperations::ExecuteDelete($parametros->catalogo, $parametros->id);
        return clsCatalogos::EjecutarConsulta($parametros);
    }

    private static function EjecutarEliminacionMixta($parametros)
    {
        clsDDBBOperations::ExecuteDelete($parametros->catalogo_real, $parametros->id);
        return clsCatalogos::EjecutarConsulta($parametros);
    }
}
