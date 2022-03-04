drop procedure if exists sp_validacion_codigos;

DELIMITER //

create procedure sp_validacion_codigos()
BEGINs

drop temporary table if exists t_productos;
create temporary table if not exists t_productos AS (

SELECT * FROM productos_registrados WHERE estado = 0 AND valido = 1

);

drop temporary table if exists t_productos_validados;
create temporary table if not exists t_productos_validados AS (

SELECT * FROM codigos_participantes cod WHERE codigo IN (SELECT codigo FROM t_productos)

);

drop temporary table if exists t_productos_correctos;
create temporary table if not exists t_productos_correctos AS (

SELECT 
pro.*
FROM t_productos pro
INNER JOIN t_productos_validados val ON pro.codigo = val.codigo 
	AND pro.lote = val.lote
	AND pro.id_producto = val.id_producto

);

drop temporary table if exists t_productos_incorrectos;
create temporary table if not exists t_productos_incorrectos AS (

SELECT DISTINCT
pro.*
FROM t_productos pro
INNER JOIN t_productos_validados val ON pro.codigo = val.codigo AND pro.lote != val.lote

);

UPDATE productos_registrados SET estado = 1 WHERE id IN (SELECT id FROM t_productos_correctos);
UPDATE productos_registrados SET valido = 0 WHERE id IN (SELECT id FROM t_productos_incorrectos);

SELECT * FROM t_productos_correctos;
SELECT * FROM t_productos_incorrectos;

DROP TEMPORARY TABLE t_productos;
DROP TEMPORARY TABLE t_productos_validados;
DROP TEMPORARY TABLE t_productos_correctos;
DROP TEMPORARY TABLE t_productos_incorrectos;

end //

delimiter ;

call sp_validacion_codigos();
