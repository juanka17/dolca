<?php session_start(); ?> 
<?php
include_once('clsDDBBOperations.php');
include_once('FECrypt.php');
include_once('clsMailHelper.php');
include_once('consultas.php');

/*
Inventarse algo para hacer debug si $_SERVER["SERVER_NAME"] esta en localhost
*/
class clsEspeciales
{
    public static function EjecutarOperacion($operacion, $parametros)
    {
        switch ($operacion) {
            case "iniciar_sesion_usuario":
                return clsEspeciales::IniciarSesionUsuario($parametros);
                break;
            case "crear_usuario":
                return clsEspeciales::CrearNuevoUsuario($parametros);
                break;
            case "actualizar_usuario":
                return clsEspeciales::ActualizarUsuario($parametros);
                break;
            case "actualizar_clave":
                return clsEspeciales::ActualizarClave($parametros);
                break;
            case "SolicitarClave":
                return clsEspeciales::SolicitarClave($parametros);
                break;
            case "restaurar_clave":
                return clsEspeciales::RestaurarClave($parametros);
                break;
            case "cargar_lista_usuarios":
                return clsEspeciales::CargarListaUsuarios($parametros);
                break;
            case "registrar_redenciones":
                return clsEspeciales::RegistrarRedenciones($parametros);
                break;
            case "registrar_seguimiento_redencion":
                return clsEspeciales::RegistrarOperacionRedencion($parametros);
                break;
        }
    }

    private static function CrearNuevoUsuario($parametros)
    {
        $query = "select id from participantes where telefono = " . $parametros->datos->telefono;
        $usuario_existe = clsDDBBOperations::ExecuteSelectNoParams($query);
        if (count($usuario_existe) == 0) {
            $resultado_creacion = clsDDBBOperations::ExecuteInsert((array)$parametros->datos, $parametros->catalogo_real);
            if (is_array($resultado_creacion)) {
                $id_nuevo_usuario = clsDDBBOperations::GetLastInsertedId();
                return clsEspeciales::RetornarDatosUsuario($id_nuevo_usuario, false);
            } else {
                return array('ok' => false, 'error' => "Existe un problema en la creación.");
            }
        } else {
            return array('ok' => false, 'error' => "La cédula o telefono ya esta registrada en el sistema");
        }
    }

    private static function ActualizarUsuario($parametros)
    {
        $resultado = clsDDBBOperations::ExecuteUpdate((array)$parametros->datos, $parametros->catalogo_real, $parametros->id);

        $datos_actualizacion = clsEspeciales::ObtenerDatosUsuario($parametros->id);
        return clsEspeciales::RetornarDatosUsuario($datos_actualizacion, false);
    }

    private static function ObtenerDatosUsuario($id_usuario)
    {
        $query = Consultas::$participantes . " where par.id = " . $id_usuario . " order by usu.nombre ";
        $datos_usuario = clsDDBBOperations::ExecuteUniqueRowNoParams($query);

        return $datos_usuario;
    }

    private static function ObtenerDatosUsuarioAdmin($id_usuario)
    {
        $query = Consultas::$consulta_usuarios . " where usu.id = " . $id_usuario . " order by usu.nombre ";
        $datos_usuario = clsDDBBOperations::ExecuteUniqueRowNoParams($query);

        return $datos_usuario;
    }

    private static function CargarListaUsuarios($parametros)
    {
        if ($parametros->cedula != "") {
            $query = Consultas::$participantes . " where par.documento = %i";
            $listado = clsDDBBOperations::ExecuteSelect($query, $parametros->cedula);

            return array('ok' => true, 'listado' => $listado);
        } else if ($parametros->nombre != "") {
            $query = Consultas::$participantes . " where par.nombre like %ss";
            $listado = clsDDBBOperations::ExecuteSelect($query, $parametros->nombre);

            return array('ok' => true, 'listado' => $listado);
        } else if ($parametros->telefono != "") {
            $query = Consultas::$participantes . " where par.telefono like %ss";
            $listado = clsDDBBOperations::ExecuteSelect($query, $parametros->telefono);

            return array('ok' => true, 'listado' => $listado);
        } else {
            return array('ok' => false, 'error' => "Debe indicarse un valor");
        }
    }

    private static function RetornarDatosUsuario($datos_usuario, $modifica_sesion)
    {
        if ($datos_usuario > 0) {
            //$usuario = $datos_usuario[0];

            if ($modifica_sesion) {
                clsEspeciales::CrearSesionUsuario($datos_usuario);
            }

            return array('ok' => true, 'datos_usuario' => $datos_usuario);
        } else {
            return array('ok' => false, 'error' => "Los datos ingresados no son correctos.");
        }
    }


    private static function CrearSesionUsuario($datosAfiliado)
    {
        $_SESSION["usuario"] = $datosAfiliado;
    }

    private static function ActualizarClave($parametros)
    {
        if ($parametros->acepto_terminos == 0) {
            return clsEspeciales::ActualizaClaveUsuario($parametros->datos->clave_nueva, $parametros->id);
        } else {
            $query = "select clave from usuarios where id = " . $parametros->id;
            $resultado_clave_actual = clsDDBBOperations::ExecuteUniqueRowNoParams($query);
            $clave_actual = $resultado_clave_actual["clave"];

            if (FECrypt::Compare($parametros->datos->clave_actual, $clave_actual) == 1) {
                return clsEspeciales::ActualizaClaveUsuario($parametros->datos->clave_nueva, $parametros->id);
            } else {
                return array('ok' => false, 'resultado' => "La clave actual no es correcta");
            }
        }
    }

    private static function RestaurarClave($parametros)
    {
        $query = "select id,cedula from usuarios where id = " . $parametros->id_usuario;
        $resultado_consulta = clsDDBBOperations::ExecuteUniqueRowNoParams($query);
        $updates = array();
        $updates["CLAVE"] = $resultado_consulta["cedula"];
        $updates["acepto_terminos"] = 0;

        $resultado_actualizacion = clsDDBBOperations::ExecuteUpdate($updates, "usuarios", $resultado_consulta["id"]);

        if (is_array($resultado_actualizacion)) {
            $usuario = clsEspeciales::ObtenerDatosUsuario($resultado_consulta["id"]);
            return array('ok' => true, 'resultado' => "Clave restaurada satisfactoriamente.", 'usuario' => $usuario);
        } else {
            return array('ok' => false, 'resultado' => "Error en la operación.");
        }
    }

    private static function ActualizaClaveUsuario($clave, $id)
    {
        $updates = array();
        $updates["CLAVE"] = FECrypt::Encrypt($clave);
        $updates["acepto_terminos"] = 1;
        $resultado_actualizacion = clsDDBBOperations::ExecuteUpdate($updates, "usuarios", $id);
        if (is_array($resultado_actualizacion)) {
            $usuario = clsEspeciales::ObtenerDatosUsuario($id);
            clsEspeciales::CrearSesionUsuario($usuario);
            return array('ok' => true, 'resultado' => "Clave actualizada satisfactoriamente.", 'usuario' => $usuario);
        } else {
            return array('ok' => false, 'resultado' => "Error en la operación.");
        }
    }

    private static function IniciarSesionUsuario($parametros)
    {
        $query = "select id,cedula,clave,acepto_terminos from usuarios where id_estado = 1 and cedula = %s";
        $resultado_clave_actual = clsDDBBOperations::ExecuteUniqueRow($query, $parametros->cedula);
        $clave_ingresada = $parametros->clave;
        $clave = $resultado_clave_actual["clave"];
        $cedula = $resultado_clave_actual["cedula"];
        $acepto_terminos = $resultado_clave_actual["acepto_terminos"];

        if (count($resultado_clave_actual) > 0) {
            if ($clave_ingresada == $clave && $acepto_terminos == 0) {
                $datos_usuario = clsEspeciales::ObtenerDatosUsuarioAdmin($resultado_clave_actual["id"]);
                return clsEspeciales::RetornarDatosUsuario($datos_usuario, true);
            } else {
                if (FECrypt::Compare($parametros->clave, $clave) == 1) {
                    $datos_usuario = clsEspeciales::ObtenerDatosUsuarioAdmin($resultado_clave_actual["id"]);
                    return clsEspeciales::RetornarDatosUsuario($datos_usuario, true);
                } else {
                    return array('ok' => false, 'error' => "Datos incorrectos, por favor verifique la información e intente de nuevo.");
                }
            }
        } else {
            return array('ok' => false, 'error' => "Usuario no encontrado.");
        }
    }

    private static function RegistrarRedenciones($parametros)
    {
        $redenciones_registradas = array();
        $ids_estados_cuenta = array();
        foreach ($parametros->premios as $redencion) {
            $id_usuario = $parametros->id_usuario;
            $direccion_envio = $parametros->direccion_envio;
            $id_registra = $parametros->id_registra;
            $id_premio = $redencion->id_premio;
            $puntos = $redencion->puntos;
            $comentario = $redencion->comentario;
            $ciudad = $parametros->ciudad;

            $query = "call sp_redimir_premio(" . $id_usuario . "," . $id_premio . "," . $puntos . ",'" . $comentario . "','" . $direccion_envio . "'," . $id_registra . ",'" . $ciudad . "');";
            print $query;
            $resultado_redencion = clsDDBBOperations::ExecuteSelectNoParams($query);

            if (is_array($resultado_redencion)) {
                array_push($redenciones_registradas, $resultado_redencion[0]);
            }
        }

        if (count($redenciones_registradas) == count($parametros->premios)) {
            return array('ok' => true, 'redenciones' => $redenciones_registradas);
        } else {
            foreach ($redenciones_registradas as $redencion) {
                clsDDBBOperations::ExecuteDelete("seguimiento_redencion", $redencion["id_seguimiento"]);
                clsDDBBOperations::ExecuteDelete("redenciones", $redencion["folio"]);
                clsDDBBOperations::ExecuteDelete("estado_cuenta", $redencion["id_estado_cuenta"]);
            }

            return array('ok' => false, 'error' => "Error en la redención, comuniquese con la linea de atención al cliente.");
        }
    }

    private static function RegistrarOperacionRedencion($parametros)
    {
        $id_redencion = $parametros->datos->id_redencion;
        $id_operacion = $parametros->datos->id_operacion;
        $comentario = $parametros->datos->comentario;
        $referencia = $parametros->datos->referencia;
        $id_registra = $parametros->datos->id_registra;

        $query = "call sp_registrar_operacion_redencion(" . $id_redencion . "," . $id_operacion . ",'" . $comentario . "','" . $referencia . "'," . $id_registra . ");";
        $resultado = clsDDBBOperations::ExecuteSelectNoParams($query);

        if (is_array($resultado) && $resultado[0]["error"] == "") {
            $query = Consultas::$consulta_seguimiento_redencion . " where seg.id_redencion = " . $id_redencion . " order by seg.id";
            $seguimientos = clsDDBBOperations::ExecuteSelectNoParams($query);
            return array('ok' => true, 'data' => $seguimientos);
        } else {
            return array('ok' => false, 'error' => $resultado[0]["error"]);
        }
    }

    public static function ConstruirPasswordAleatorio()
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 5; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $newPassword = implode($pass); //turn the array into a string
        return $newPassword;
    }

    private static function SolicitarClave($parametros)
    {
        $query = "SELECT id,nombre,cedula,correo_corporativo from usuarios where correo_corporativo = '" . $parametros->email . "'";
        $resultado_consulta = clsDDBBOperations::ExecuteUniqueRowNoParams($query);
        if (is_array($resultado_consulta)) {
            $nueva = clsEspeciales::ConstruirPasswordAleatorio();
            $updates = array();
            $updates["CLAVE"] = $nueva;
            $updates["acepto_terminos"] = 0;

            $resultado_consulta["CLAVE"] = $nueva;


            $resultado_actualizacion = clsDDBBOperations::ExecuteUpdate($updates, "usuarios", $resultado_consulta["id"]);
        } else {
            return array('ok' => false, 'resultado' => "Error en la operación.");
        }

        if (is_array($resultado_actualizacion)) {
            $usuario = clsEspeciales::ObtenerDatosUsuario($resultado_consulta["id"]);
            clsMailHelper::EnviarMailSolicitarClave($resultado_consulta);

            return array('ok' => true, 'resultado' => "Clave restaurada satisfactoriamente.", 'usuario' => $usuario);
        } else {
            return array('ok' => false, 'resultado' => "Error en la operación.");
        }
    }
}

?>