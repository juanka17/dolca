<?php

class Consultas
{
    public static $consulta_usuarios = '
        SELECT  
            usu.id,
            usu.cedula,
            usu.nombre,
            usu.acepto_terminos,
            est.id id_estado,
            est.nombre estado,
            rol.id id_rol,
            rol.nombre rol
        FROM 
            usuarios usu
            INNER JOIN estado est on est.id = usu.id_estado
            INNER JOIN roles rol on rol.id = usu.id_rol
    ';

    public static $consulta_llamadas_usuarios = "
        SELECT 
            la.id, 
            la.fecha, 
            concat(tp.NOMBRE,'-',sc.NOMBRE,'-',cl.NOMBRE) categoria,
            usr.NOMBRE registro, 
            comentario
        FROM    
            llamadas_usuarios la 
            INNER JOIN categorias_llamada cl on la.ID_SUBCATEGORIA = cl.ID 
            INNER JOIN categorias_llamada sc on sc.ID = cl.ID_PADRE
            INNER JOIN categorias_llamada tp on tp.ID = sc.ID_PADRE
            LEFT JOIN usuarios usr on usr.id = la.id_usuario_registra
        ";

    public static $consulta_llamadas_usuarios_completa = "
        SELECT 
            usu.id id_usuario,
            usu.cedula,
            usu.nombre usuario,
            alm.nombre almacen,
            lla.id, 
            lla.fecha, 
            concat(tpl.NOMBRE,'-',scl.NOMBRE,'-',cal.NOMBRE) categoria,
            usr.NOMBRE registro, 
            comentario
        FROM    
            llamadas_usuarios lla 
            INNER JOIN categorias_llamada cal on lla.ID_SUBCATEGORIA = cal.ID 
            INNER JOIN categorias_llamada scl on scl.ID = cal.ID_PADRE
            INNER JOIN categorias_llamada tpl on tpl.ID = scl.ID_PADRE
            INNER JOIN usuarios usu on usu.id = lla.id_usuario
            INNER JOIN almacenes alm on alm.id = usu.id_almacen
            LEFT JOIN usuarios usr on usr.id = lla.id_usuario_registra
    ";

    public static $productos_registrados = "
        
    SELECT 
        reg.id,
        pro.nombre producto,
        reg.codigo,
        reg.lote,
        reg.fecha,
        reg.estado,
        case
            when estado = 1 then 'Valido'
            when estado = 2 then 'Solicitado'
            ELSE 'Invalido'
        END estado_producto,
        case
            when estado = 1 then pro.mecanica
            when estado = 2 then pro.mecanica
            ELSE 0
        END mecanica
    FROM
        productos_registrados reg
        INNER JOIN productos pro ON pro.id = reg.id_producto
    ";

    public static $validar_valor_productos_registrados = "
        
    SELECT 
        reg.id,
        pro.nombre producto,
        reg.codigo,
        reg.lote,
        reg.fecha,
        reg.estado,
		  sum(pro.mecanica) mecanica
    FROM
        productos_registrados reg
        INNER JOIN productos pro ON pro.id = reg.id_producto
    ";

    public static $bono_solicitado = "

    SELECT
        id,
        CONCAT('Bono Numero ',codigo) codigo,
        fecha_expiracion,
        valor,
        estado
    FROM
        bonos
    ";

    public static $participantes = "

        SELECT 
            par.id,
            par.nombre,
            tip.nombre tipo_doc,
            par.documento,
            par.correo,
            par.telefono,
            par.fecha_creacion,
            usu.nombre registra
        FROM 
            participantes par
            INNER JOIN tipo_documento tip ON tip.id = par.id_tipo_doc
            INNER JOIN usuarios usu ON usu.id = par.id_creacion
    ";
    public static $participantes_con_registro = "

    SELECT 
        par.id,
        par.nombre,
        tip.nombre tipo_doc,
        par.documento,
        par.correo,
        par.telefono,
        par.fecha_creacion,
        usu.nombre registra
    FROM 
        participantes par
        INNER JOIN tipo_documento tip ON tip.id = par.id_tipo_doc
        INNER JOIN usuarios usu ON usu.id = par.id_creacion
        WHERE par.id IN (SELECT id_participante from productos_registrados)
    ";

    public static $ReporteProductosRegistrados = "

        SELECT
            reg.id,
            pro.nombre producto,
            par.nombre participante,
            reg.codigo,
            reg.lote,
            reg.fecha,
            case
            when reg.estado = 1 then 'Valido'
            when reg.estado = 2 then 'Solicitado'
            ELSE 'Invalido'
            END estado,
            reg.fecha_registro,
            usu.nombre registra
        FROM 
            productos_registrados reg
            INNER JOIN productos pro ON pro.id = reg.id_producto
            INNER JOIN participantes par ON par.id = reg.id_participante
            INNER JOIN usuarios usu ON usu.id = reg.id_registro
    ";

    public static $ReporteBonosSolicitados = "
    
    SELECT
        bon.id,
        reg.id id_registro,
        par.id id_participante,
        par.nombre participante,
        par.documento,
        par.telefono,
        pro.nombre producto,
        reg.codigo codigo_ean,
        reg.lote,
        b.codigo bono_entregado,
        b.fecha_expiracion,
        b.valor,
        bon.fecha,
        usu.nombre registra
    FROM 
        bonos_solicitados bon
        INNER JOIN productos_registrados reg ON bon.id_registro = reg.id
        INNER JOIN participantes par ON par.id = bon.id_participante
        inner JOIN usuarios usu ON usu.id = bon.id_registra
        INNER JOIN productos pro ON pro.id = reg.id_producto
        INNER JOIN bonos b ON b.id = bon.id_bono;
    ";

    public static $ReporteEstadoBonos = "
    
    SELECT 
        id,
        CONCAT('codigo -',codigo)codigo,
        fecha_expiracion,
        valor,
        case
            when estado = 0 then 'Habilitado'
            when estado = 1 then 'Solicitado'
            when estado = 2 then 'Cancelado'
        END estado
    FROM 
        bonos
    ";

    public static $ReporteFacturas = "       

        SELECT 
            par.id id_participante,
            par.nombre participante,
            par.documento,
            fac.lugar_compra,
            fac.fecha_registro,
            pro.nombre producto,
            det.valor,
            usu.nombre registra
        FROM 
            factura_detalle det
            INNER JOIN factura fac ON fac.id = det.id_factura
            inner JOIN participantes par ON par.id = fac.id_participante
            inner JOIN productos pro ON pro.id = det.id_producto
            inner JOIN usuarios usu ON usu.id = fac.id_registra
    ";

    public static $grafica_productos = "
        
        SELECT 
            reg.id_producto,
            pro.nombre producto,
            COUNT(reg.id) total
        FROM
            productos_registrados reg
            INNER JOIN productos pro ON pro.id =  reg.id_producto
            WHERE pro.id NOT IN (7,8)
        GROUP BY
            id_producto;
        
    ";

    public static $ReporteLlamadas = "
        
    SELECT 
        usu.id id_usuario,
        usu.documento,
        usu.nombre usuario,
        lla.id, 
        lla.fecha, 
        tpl.NOMBRE tipo,
        scl.NOMBRE categoria,
        cal.NOMBRE sub_categoria,
        usr.NOMBRE registro, 
        comentario
    FROM    
        llamadas_usuarios lla 
        INNER join categorias_llamada cal on lla.ID_SUBCATEGORIA = cal.ID 
        INNER join categorias_llamada scl on scl.ID = cal.ID_PADRE
        INNER join categorias_llamada tpl on tpl.ID = scl.ID_PADRE
        INNER join participantes usu on usu.id = lla.id_usuario
        INNER join usuarios usr on usr.id = lla.id_usuario_registra
        
    ";
}
