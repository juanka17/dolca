DROP PROCEDURE IF EXISTS sp_grafica_participantes_por_bonos;

DELIMITER //

CREATE PROCEDURE sp_grafica_participantes_por_bonos()
LANGUAGE SQL
DETERMINISTIC
SQL SECURITY DEFINER
BEGIN

drop temporary table if exists t_participantes;
create temporary table if not exists t_participantes AS (

SELECT
	date(fecha_registro) fecha,
	COUNT(id) registros
FROM
	productos_registrados pro
GROUP BY 
MONTH(fecha_registro),
DAY(fecha_registro)

);

drop temporary table if exists t_bonos_participantes;
create temporary table if not exists t_bonos_participantes AS (

SELECT
	date(fecha) fecha,
	COUNT(id) bonos
FROM
	bonos_solicitados
GROUP BY 
	MONTH(fecha),
	day(fecha)

);

SELECT 
	par.fecha,
	par.registros,
	bon.bonos
FROM 
	t_participantes par
	INNER JOIN t_bonos_participantes bon ON par.fecha = bon.fecha;
	
end//
DELIMITER ;

call sp_grafica_participantes_por_bonos();