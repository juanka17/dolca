drop procedure if exists sp_valores_entregados;

DELIMITER //

create procedure sp_valores_entregados()
BEGIN

DROP TEMPORARY TABLE if EXISTS t_valores_entregados;
CREATE TEMPORARY TABLE if NOT EXISTS t_valores_entregados AS (

	SELECT 
	   CONCAT('Bono-',bon.valor) valor,
	   COUNT(sol.id) cantidad,
	   SUM(valor) total
	FROM 
	   bonos_solicitados sol
	   INNER JOIN bonos bon ON bon.id = sol.id_bono
	GROUP BY
	   bon.valor
);

DROP TEMPORARY TABLE if EXISTS t_valores_sumados;
CREATE TEMPORARY TABLE if NOT EXISTS t_valores_sumados AS (

	SELECT 
	   'Total Bonos' valor,
		SUM(cantidad) cantidad,
		SUM(total) total 
	FROM 
		t_valores_entregados

);

INSERT INTO t_valores_entregados
SELECT * FROM t_valores_sumados;

SELECT * FROM t_valores_entregados;

			
END //

delimiter ;

call sp_valores_entregados();